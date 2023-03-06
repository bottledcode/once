<?php

namespace Withinboredom\Once\Repositories;

use DateTimeImmutable;
use r\Connection;
use Withinboredom\Once\Exceptions\MessageExpired;
use Withinboredom\Once\Exceptions\PasswordRequired;
use Withinboredom\Once\Models\Message;
use Withinboredom\Once\Models\NewMessage;

use function r\table;
use function r\uuid;

readonly class MessageRepository
{
	public function __construct(private Connection $connection, private KeyRepository $keyRepository)
	{
	}

	public function get(string $id, string $for, string|null $password = null): Message|null
	{
		$result = table('messages')->get($id)->run($this->connection);
		if ($result === null) {
			return null;
		}
		$message = new Message(
			$result['destinationAddress'],
			$result['message'],
			$result['passwordProtected'],
			$result['name'],
			$result['expiresAt'],
			$result['selfDestruct'],
			$result['id'],
			$result['sender']
		);

		if ($message->destinationAddress !== $for) {
			return null;
		}

		if ($message->expiresAt < new DateTimeImmutable()) {
			table('messages')->get($id)->delete()->run($this->connection);
			throw new MessageExpired();
		}

		if ($message->passwordProtected && $password === null) {
			throw new PasswordRequired();
		}

		$text = $message->message;
		if ($message->passwordProtected) {
			$text = $this->passwordUnprotect($text, $password, $for, $message->sender);
		}
		$text = $this->decrypt($text, $message->sender, $for);

		if ($message->selfDestruct) {
			table('messages')->get($id)->delete()->run($this->connection);
		}

		return $message->with(message: $text);
	}

	public function passwordUnprotect(string $encrypted, string $password, string $recipient, string $sender): string
	{
		$key = hash('sha256', $password . $recipient . $sender, true);
		$ciphertext = sodium_base642bin($encrypted, SODIUM_BASE64_VARIANT_ORIGINAL);
		$nonce = mb_substr($ciphertext, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
		$ciphertext = mb_substr($ciphertext, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
		$plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);

		if ($plaintext === false) {
			throw new PasswordRequired();
		}

		sodium_memzero($key);
		sodium_memzero($nonce);
		sodium_memzero($ciphertext);
		return $plaintext;
	}

	public function decrypt(string $ciphertext, string $from, string $recipient): string
	{
		$public = $this->keyRepository->getKeyFor($from);
		$public = sodium_crypto_box_publickey($public);
		$private = $this->keyRepository->getKeyFor($recipient);
		$private = sodium_crypto_box_secretkey($private);

		$key = sodium_crypto_box_keypair_from_secretkey_and_publickey($private, $public);
		$decoded = sodium_base642bin($ciphertext, SODIUM_BASE64_VARIANT_ORIGINAL);
		$nonce = substr($decoded, 0, SODIUM_CRYPTO_BOX_NONCEBYTES);
		$ciphertext = substr($decoded, SODIUM_CRYPTO_BOX_NONCEBYTES);
		$return = sodium_crypto_box_open($ciphertext, $nonce, $key);

		sodium_memzero($public);
		sodium_memzero($private);
		sodium_memzero($key);
		sodium_memzero($nonce);
		sodium_memzero($ciphertext);
		sodium_memzero($decoded);

		return $return;
	}

	public function save(NewMessage $message, string $sender): Message
	{
		$password = $message->set_password ? $message->password ?? '' : '';
		$id = uuid()->run($this->connection);
		$encryptedMessage = $message->text_editor;
		$encryptedMessage = $this->encrypt($encryptedMessage, $sender, $message->email_address);
		if ($message->set_password) {
			$encryptedMessage = $this->passwordProtect($encryptedMessage, $password, $message->email_address, $sender);
		}

		$toSave = new Message(
			mb_strtolower($message->email_address),
			$encryptedMessage,
			strlen($password) > 0,
			$message->first_name,
			new DateTimeImmutable($message->time_limit ? '+12 hours' : '+72 hours'),
			$message->once_rule,
			$id,
			$sender
		);

		table('messages')->insert((array)$toSave)->run($this->connection);

		return $toSave;
	}

	public function encrypt(string $message, string $sender, string $receiver): string
	{
		$public = $this->keyRepository->getKeyFor($receiver);
		$public = sodium_crypto_box_publickey($public);
		$private = $this->keyRepository->getKeyFor($sender);
		$private = sodium_crypto_box_secretkey($private);

		$nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
		$key = sodium_crypto_box_keypair_from_secretkey_and_publickey($private, $public);
		$encrypted = sodium_crypto_box($message, $nonce, $key);

		$return = sodium_bin2base64($nonce . $encrypted, SODIUM_BASE64_VARIANT_ORIGINAL);
		sodium_memzero($nonce);
		sodium_memzero($encrypted);
		sodium_memzero($key);
		sodium_memzero($public);
		sodium_memzero($private);

		return $return;
	}

	public function passwordProtect(string $message, string $password, string $recipient, string $sender): string
	{
		$key = hash('sha256', $password . $recipient . $sender, true);
		$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		$encrypted = sodium_crypto_secretbox($message, $nonce, $key);
		$result = sodium_bin2base64($nonce . $encrypted, SODIUM_BASE64_VARIANT_ORIGINAL);
		sodium_memzero($key);
		sodium_memzero($nonce);
		sodium_memzero($encrypted);
		return $result;
	}
}
