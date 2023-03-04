<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('about')]
class About
{
	use RegularPHP;

	public function render(): string
	{
		$this->begin();
		?>
		<div>This is an about page</div>
		<?php
		return $this->end();
	}
}
