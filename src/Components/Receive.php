<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('receive')]
class Receive
{
	use RegularPHP;

	public function render()
	{
		$this->begin();
		?>
		<div class="p-4 dark:text-gray-300">
			<div>
				Give this link to the person you want to receive a message from:
			</div>
			<input
				type="text"
				readonly
				value="https://once.getswytch.com/sendto/<?= strstr($_SERVER['HTTP_X_AUTH_REQUEST_USER'], ':', true) ?>"
				class="dark:text-gray-300 dark:bg-gray-900 rounded-md mt-3 w-full max-w-2xl"
			>
		</div>
		<?php
		return $this->end();
	}
}
