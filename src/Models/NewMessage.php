<?php

namespace Withinboredom\Once\Models;

readonly class NewMessage
{
	public function __construct(
		public string $first_name,
		public string $text_editor,
		public string|null $email_address = null,
		public bool $once_rule = false,
		public bool $time_limit = false,
		public bool $set_password = false,
		public string|null $password = null,
		public string|null $receiver = null,
	) {
	}
}
