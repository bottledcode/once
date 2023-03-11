<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Hooks\Common\Headers;
use Bottledcode\SwytchFramework\Router\Attributes\Route;
use Bottledcode\SwytchFramework\Router\Method;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Compiler;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;
use Withinboredom\Once\Services\AuthService;

#[Component('navbar')]
class Navbar
{
	use RegularPHP;
	use Htmx;
	use Urls;

	public function __construct(
		private readonly Compiler $compiler,
		private readonly AuthService $authService,
		private readonly Headers $headers
	) {
	}

	#[Route(Method::POST, '/api/navbar/open')]
	public function open(string $target_id, array $state): string
	{
		return $this->rerender($target_id, [...$state, 'open' => true]);
	}

	#[Route(Method::POST, '/api/navbar/close')]
	public function close(string $target_id, array $state): string
	{
		return $this->rerender($target_id, [...$state, 'open' => false]);
	}

	public function render(bool $open): string
	{
		$this->begin();
		?>
		<nav class="bg-gray-800 dark:bg-gray-900 dark:text-gray-800">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				<div class="flex h-16 items-center justify-between">
					<div class="flex items-center">
						<div class="flex-shrink-0">
							<a href="/">
								<img
									class="h-8 w-8" src="/assets/logo-small.svg" alt="<?= __('Swytch') ?>"
								>
							</a>
						</div>
						<div class="hidden md:block">
							<div class="ml-10 flex items-baseline space-x-4">
								<!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
								<NavbarPageSelector href="/" label="<?= __('Home') ?>"></NavbarPageSelector>
								<NavbarPageSelector href="/app/send" label="<?= __('Send') ?>"></NavbarPageSelector>
								<NavbarPageSelector
									href="/app/receive" label="<?= __('Receive') ?>"
								></NavbarPageSelector>
								<NavbarPageSelector href="/about" label="<?= __('About') ?>"></NavbarPageSelector>
								<?php
								if ($this->authService->isAuthenticated()): ?>
									<NAVBARPAGESELECTOR
										href="https://auth.getswytch.com/api/logout?rd={<?= $this->getUrlForPath('', false) ?>}"
										label="<?= __('Logout') ?>"
									></NAVBARPAGESELECTOR>
								<?php
								endif; ?>
							</div>
						</div>
					</div>
					<div class="-mr-2 flex md:hidden">
						<!-- Mobile menu button -->
						<form hx-post="<?= $open ? '/api/navbar/close' : '/api/navbar/open' ?>" class="m-0">
							<button
								type="submit"
								class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
								aria-controls="mobile-menu"
								aria-expanded="false"
							>
								<span class="sr-only"><?= __('Open main menu') ?></span>
								<img
									class="<?= $open ? 'hidden' : 'block' ?> h-6 w-6"
									src="/assets/hamburger.svg"
									alt="<?= __('open') ?>"
								>
								<!-- Menu open: "block", Menu closed: "hidden" -->
								<img
									class="<?= $open ? 'block' : 'hidden' ?> h-6 w-6"
									src="/assets/close.svg"
									alt="<?= __('close') ?>"
								>
							</button>
						</form>
					</div>
				</div>
			</div>
			<?php
			if ($open):
				?>
				<!-- Mobile menu, show/hide based on menu state. -->
				<div class="md:hidden" id="mobile-menu">
					<div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
						<!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
						<NavbarPageSelector mobile="true" href="/" label="<?= __('Home') ?>"></NavbarPageSelector>
						<NavbarPageSelector
							mobile="true" href="/app/send" label="<?= __('Send') ?>"
						></NavbarPageSelector>
						<NavbarPageSelector
							mobile="true" href="/app/receive" label="<?= __('Receive') ?>"
						></NavbarPageSelector>
						<NavbarPageSelector mobile="true" href="/about" label="<?= __('About') ?>"></NavbarPageSelector>
						<?php
						if ($this->authService->isAuthenticated()): ?>
							<NAVBARPAGESELECTOR
								href="https://auth.getswytch.com/api/logout?rd={<?= $this->getUrlForPath('', false) ?>}"
								label="<?= __('Logout') ?>"
								mobile
							></NAVBARPAGESELECTOR>
						<?php
						endif; ?>
					</div>
				</div>
			<?php
			endif;
			?>
		</nav>
		<?php
		return $this->end();
	}
}
