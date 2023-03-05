<?php

namespace Withinboredom\Once\Repositories;

use DateTimeImmutable;
use r\Connection;
use Symfony\Component\Serializer\Serializer;
use Withinboredom\Once\Models\Message;
use Withinboredom\Once\Models\NewMessage;

use function r\table;
use function r\uuid;

readonly class MessageRepository
{
	public function __construct(private Connection $connection, private Serializer $serializer)
	{
	}

	public function save(NewMessage $message): Message
	{
		$password = $message->set_password ? $message->password ?? '' : '';
		$id = uuid()->run($this->connection);
		$key = sodium_crypto_secretbox_keygen();
		$key = $password . substr($key, strlen($password));
		$encryptedMessage = $this->encrypt($message->text_editor, $key);

		$toSave = new Message(
			$message->email_address,
			$encryptedMessage,
			strlen($password) > 0,
			$message->first_name,
			new DateTimeImmutable($message->time_limit ? '+12 hours' : '+72 hours'),
			$message->once_rule,
			$id
		);

		table('messages')->insert((array)$toSave)->run($this->connection);

		return $toSave;
	}

	private function encrypt(string $message, string $key): string
	{
		$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		return base64_encode($nonce . sodium_crypto_secretbox($message, $nonce, $key));
	}

	private function decrypt(string $ciphertext, string $key): string
	{
		$ciphertext = base64_decode($ciphertext);
		$nonce = substr($ciphertext, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		$ciphertext = substr($ciphertext, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		return sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
	}
}
