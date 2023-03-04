<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;

#[Component('send')]
class Send
{
	public function render(): string
	{
		return "Sending!";
	}
}
