<?php

namespace Withinboredom\Once\Models;

use DateTimeInterface;

readonly class Message
{
	public function __construct(
		public string $destinationAddress,
		public string $message,
		public bool $passwordProtected,
		public string $name,
		public DateTimeInterface|null $expiresAt,
		public bool $selfDestruct,
		public string $id,
		public string $sender,
	) {
	}

	public function with(string $message): Message
	{
		return new Message(...[...((array)$this), 'message' => $message]);
	}
}
