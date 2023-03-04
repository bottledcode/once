<?php

namespace Withinboredom\Once\Components\Send;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('send:label')]
class Label
{
	use RegularPHP;

	public function render(string $for): string
	{
		$this->begin();
		?>
		<label for="<?= $for ?>" class="block text-sm font-medium leading-6 text-gray-900">
			<children />
		</label>
		<?php
		return $this->end();
	}
}
