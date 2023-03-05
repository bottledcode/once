<?php

namespace Withinboredom\Once\Models;

readonly class Message
{
	public function __construct(
		public string $destinationAddress,
		public string $message,
		public bool $passwordProtected,
		public string $name,
		public \DateTimeImmutable|null $expiresAt,
		public bool $selfDestruct,
		public string $id,
	) {
	}
}
