<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Compiler;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('Homepage')]
class Homepage
{
	use Htmx;
	use RegularPHP;

	public function __construct(private readonly Compiler $compiler)
	{
	}

	public function render(): string
	{
		$this->begin();
		?>
		<div class="py-16 sm:py-24">
			<div class="mx-auto max-w7xl px-6 lg:px-8">
				<div class="mx-auto max-w-2xl lg:text-center">
					<h2 class="text-base font-semibold leading-7 text-indigo-700">
						Share Secrets Securely
					</h2>
					<p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-300 sm:text-4xl">
						A simple secret sharing service
					</p>
					<p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
						Once is a simple, secure, and free service for sharing secrets with friends, family, and
						businesses.
					</p>
				</div>
				<div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg-mt-24 lg:max-w-4xl">
					<dl class="grid max-w-xl grid-cols-1 gap-y-10 gap-x-8 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
						<div class="relative pl-16">
							<dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-300">
								<div class="absolute top-0 left-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
									<img src="/assets/lock.svg" class="h-8 w-8 fill-gray-300" alt="Encryption">
								</div>
								Secure
							</dt>
							<dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
								Secrets are encrypted end-to-end using state-of-the-art encryption algorithms. Only the
								people you share them with can read them.
							</dd>
						</div>

						<div class="relative pl-16">
							<dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-300">
								<div class="absolute top-0 left-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
									<img class="h-8 w-8 fill-gray-300" src="/assets/private.svg" alt="Private">
								</div>
								Private
							</dt>
							<dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
								Secrets are only accessible by the people you share them with. The only cookies we use
								are strictly necessary for the site to function. We don't track you.
							</dd>
						</div>
					</dl>
				</div>
			</div>
		</div>
		<?php
		return $this->end();
	}
}
