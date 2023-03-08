<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Router\Attributes\Route;
use Bottledcode\SwytchFramework\Router\Method;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Compiler;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('modal')]
readonly class Modal
{
	use RegularPHP;
	use Htmx;

	public function __construct(private Compiler $compiler)
	{
	}

	#[Route(Method::POST, '/api/modal/set-password')]
	public function setPassword(string $password): string
	{
		$this->retarget('#password');
		$this->begin();
		?>
		<send-checkbox
			hx-swap-oob="true"
			id="password_checkbox"
			hx-get="/api/user/message/password"
			name="set_password"
			checked
			label="{<?= __('Password protect') ?>}"
			description="{<?= __(
				'All messages are encrypted so only the recipient can read the message, but you can add additional protection with a password'
			) ?>}"
		></send-checkbox>
		<div id="modal" hx-swap-oob="true"></div>
		<input
			type="hidden" name="password" id="password" value="{<?= $password ?>}"
		>
		<?php
		return $this->html($this->end());
	}

	#[Route(Method::GET, '/api/modal/close')]
	public function close(): string
	{
		$this->retarget('#modal');
		$this->begin();
		?>
		<send-checkbox
			hx-swap-oob="true"
			id="password_checkbox"
			hx-get="/api/user/message/password"
			name="set_password"
			label="{<?= __('Password protect') ?>}"
			description="{<?= __(
				'All messages are encrypted so only the recipient can read the message, but you can add additional protection with a password'
			) ?>}"
		></send-checkbox>
		<span></span>
		<?php
		return $this->html($this->end());
	}

	public function render(string $destination): string
	{
		$this->begin();
		?>
		<form hx-post="/api/modal">
			<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
				<div class="fixed inset-0 bg-gray-600 bg-opacity-20 transition-opacity ease-in-out duration-700"></div>
				<div class="fixed inset-0 z-10 overflow-y-auto">
					<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
						<div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all ease-in-out duration-700 sm:my-8 sm:w-full sm:max-w-lg">
							<div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
								<div class="sm:flex sm:items-start">
									<div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
										<svg
											class="h-6 w-6 text-red-600"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											aria-hidden="true"
										>
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
											/>
										</svg>
									</div>
									<div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
										<h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-300">
											<?= __('Set a password') ?>
										</h3>
										<div class="mt-2">
											<input
												type="text"
												name="password"
												id="password"
												required
												minlength="3"
												autofocus
												maxlength="512"
												autocomplete="new-password"
												placeholder="<?= __('Enter a password') ?>"
												class="mt-2 block w-full rounded-md border-0 py-1.5 dark:text-gray-300 dark:bg-gray-800 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
											>
										</div>
									</div>
								</div>
								<div class="mt-3 text-center dark:text-gray-300">
									<?= __(
										'We do not store this password. You will need to remember it and share it with the recipient.'
									) ?>
								</div>
							</div>
							<div class="bg-gray-50 dark:bg-slate-600 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
								<button
									type="button"
									hx-get="/api/modal/close"
									class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
								>
									<?= __('Go back') ?>
								</button>
								<button
									type="submit"
									hx-post="/api/modal/set-password"
									class="mt-3 inline-flex w-full justify-center rounded-md dark:bg-slate-400 bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
								>
									<?= __('Set the password') ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php
		return $this->end();
	}
}
