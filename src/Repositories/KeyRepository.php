<?php

namespace Withinboredom\Once\Repositories;

use r\Connection;
use r\Options\TableInsertOptions;

use function r\table;
use function r\uuid;

class KeyRepository
{
	public function __construct(private readonly Connection $connection)
	{
	}

	public function getKeyFor(string $email): string
	{
		$key = table('keys')->get(uuid($email))->run($this->connection);

		if ($key !== null) {
			return sodium_hex2bin($key['key']);
		}

		$key = sodium_crypto_box_keypair();
		$this->saveKey($email, $key);

		return $key;
	}

	private function saveKey(string $email, string $key): void
	{
		table('keys')->insert([
			'id' => uuid($email),
			'key' => sodium_bin2hex($key),
		], new TableInsertOptions(conflict: 'error'))->run($this->connection);
	}
}
