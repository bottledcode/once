<?php

namespace Withinboredom\Once\Components\Send;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('send:checkbox')]
class Checkbox
{
	use RegularPHP;

	public function render(string $name, string $label, string $description): string
	{
		$this->begin();
		?>
		<div class="flex items-start">
			<div class="flex h-6 items-center">
				<input
					id="<?= $name ?>"
					name="<?= $name ?>"
					type="checkbox"
					class="h-4 w-4 rounded border-gray-200 dark:border-gray-700 text-indigo-600 focus:ring-indigo-600"
				>
			</div>
			<div class="ml-3">
				<label for="<?= $name ?>" class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">
					{<?= $label ?>}
				</label>
				<p class="text-sm text-gray-500">
					{<?= $description ?>}
				</p>
			</div>
		</div>
		<?php
		return $this->end();
	}
}
