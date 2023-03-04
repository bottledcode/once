<?php

namespace Withinboredom\Once\Components\Send;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('send:text')]
class TextInput
{
	use RegularPHP;

	public function render(string $name, string $autocomplete, string $placeholder, string $type = 'text'): string
	{
		$this->begin();
		?>
		<input
			type="{<?= $type ?>}"
			name="{<?= $name ?>}"
			id="{<?= $name ?>}"
			required
			maxlength="512"
			autocomplete="{<?= $autocomplete ?>}"
			placeholder="{<?= $placeholder ?>}"
			class="mt-2 block w-full rounded-md border-0 py-1.5 dark:text-gray-300 dark:bg-gray-800 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
		>
		<?php
		return $this->end();
	}
}
