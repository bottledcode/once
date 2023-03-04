<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Authenticated;
use Bottledcode\SwytchFramework\Template\Attributes\Component;

#[Component('send')]
#[Authenticated(visible: true)]
class Send
{
	public function render(): string
	{
		return "Sending!";
	}
}
