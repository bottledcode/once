<?php

use r\Connection;
use Withinboredom\Once\Repositories\KeyRepository;
use Withinboredom\Once\Repositories\MessageRepository;

it('can be used to password protect a message', function () {
	$repo = new MessageRepository(mock(Connection::class)->expect(), mock(KeyRepository::class)->expect());

	$message = 'test message';
	$encrypted = $repo->passwordProtect($message, 'password', 'test@example.com', 'sender@example.com');
	$decrypted = $repo->passwordUnprotect($encrypted, 'password', 'test@example.com', 'sender@example.com');
	expect($decrypted)->toBe($message);
});

it('can be used to encrypt a message', function () {
	$keys = mock(KeyRepository::class)->expect(getKeyFor: function ($email) {
		static $keys = [];
		if (!isset($keys[$email])) {
			$keys[$email] = sodium_crypto_box_keypair();
		}
		return $keys[$email];
	});
	$repo = new MessageRepository(mock(Connection::class)->expect(), $keys);
	$message = 'test message';
	$sender = 'sender@example.com';
	$recipient = 'test@example.com';
	$encrypted = $repo->encrypt($message, $sender, $recipient);
	$decrypted = $repo->decrypt($encrypted, $sender, $recipient);
	expect($decrypted)->toBe($message);
});
