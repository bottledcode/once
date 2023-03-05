<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('app:footer')]
class Footer
{
	use RegularPHP;

	public function render(): string
	{
		$this->begin();
		?>
		<footer class="text-center text-white bg-gray-800">
			<div class="flex justify-around items-center">
				<div class="pt-3">
					<a class="underline font-semibold" href="https://auth.getswytch.com/privacy" target="_blank">Privacy
						Policy</a>
					|
					<a class="underline font-semibold" href="https://auth.getswytch.com/tos" target="_blank">Terms of
						Service</a>
				</div>
			</div>
			<div class="p-4 pt-2 text-center">
				&copy; 2023 by Wicked Monkey Software. All rights reserved.
			</div>
		</footer>
		<?php
		return $this->end();
	}
}
