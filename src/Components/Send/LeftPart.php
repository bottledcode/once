<?php

namespace Withinboredom\Once\Components\Send;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('send-left-part')]
class LeftPart
{
	use RegularPHP;

	public function render(string $title, string $subtitle): string
	{
		$this->begin();
		?>
		<div class="md:col-span-1 pt-2">
			<div class="px-4 sm:px-0">
				<h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-300">
					{<?= $title ?>}
				</h3>
				<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
					{<?= $subtitle ?>}
				</p>
			</div>
		</div>
		<?php
		return $this->end();
	}
}
