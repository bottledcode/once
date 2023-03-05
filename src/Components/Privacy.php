<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('Privacy')]
class Privacy
{
	use RegularPHP;

	public function render(): string
	{
		$this->begin();
		?>
		<div class=""></div>
		<?php
		return $this->end();
	}
}
