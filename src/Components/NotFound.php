<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('not-found')]
class NotFound
{
	use RegularPHP;

	public function render(): string
	{
		http_response_code(404);

		$this->begin();
		?>
		<main class="grid min-h-full place-items-center py-24 px-6 sm:py-32 lg:px-8">
			<div class="text-center">
				<p class="text-base font-semibold text-indigo-600"><?= __('404') ?></p>
				<h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-300 sm:text-5xl">
					<?= __('Page not found') ?>
				</h1>
				<p class="mt-6 text-base leading-7 text-gray-600 dark:text-gray-400">
					<?= __('Sorry, we couldn’t find the page you’re looking for.') ?>
				</p>
				<div class="mt-10 flex items-center justify-center gap-x-6">
					<a
						href="/"
						class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
					>
						<?= __('Go back home') ?>
					</a>
					<a
						href="mailto://support@getswytch.com"
						class="text-sm font-semibold text-gray-900 dark:text-gray-300"
					>
						<?= __('Contact support') ?>
						<span aria-hidden="true">&rarr;</span>
					</a>
				</div>
			</div>
		</main>
		<?php
		return $this->end();
	}
}
