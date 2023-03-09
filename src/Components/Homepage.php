<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Hooks\Common\Headers;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Compiler;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('Homepage')]
class Homepage
{
	use Htmx;
	use RegularPHP;

	public function __construct(private readonly Compiler $compiler, private readonly Headers $headers)
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
						<?= __('Once: Powered by Swytch') ?>
					</h2>
					<p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-300 sm:text-4xl">
						<?= __('Say it securely, once and for all') ?>
					</p>
					<p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
						<?= __(
							'Our messaging service allows you to send secure, self-destructing messages that can only be read once and must be read within a specific time frame. This means that your messages will always be kept private and confidential, and can only be accessed by the intended recipient.'
						) ?>
					</p>
					<p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
						<?= __(
							'Additionally, you have the option to password-protect your messages for an extra layer of security. Our service is perfect for anyone who needs to send sensitive or confidential information, such as business professionals, lawyers, doctors, or anyone who values their privacy. With our easy-to-use platform, you can send and receive messages quickly and efficiently, and always have the peace of mind that your messages are secure.'
						) ?>
					</p>
				</div>
				<div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
					<dl class="grid max-w-xl grid-cols-1 gap-y-10 gap-x-8 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
						<div class="relative pl-16">
							<dt class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-300">
								<div class="absolute top-0 left-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
									<img src="/assets/lock.svg" class="h-8 w-8 fill-gray-300" alt="Encryption">
								</div>
								Secure
							</dt>
							<dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-400">
								Send secure messages that can only be read once and must be read within a specific time
								frame
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
								Password-protect your messages for an extra layer of security
							</dd>
						</div>
					</dl>
				</div>
				<div class="mx-auto max-w-2xl lg:text-center mt-16 sm:mt-20 lg:mt-24">
					<p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-300 sm:text-4xl">
						<?= __('How it works') ?>
					</p>
					<p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
						<?= __(
							'First you %s write a message %s and address it to a recipient.',
							'<a href="/app/send" class="text-gray-900 dark:text-gray-300 underline">',
							'</a>'
						) ?>
					</p>
					<p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
						<?= __(
							'After you finish the message, you will receive a link to the message that %s only %s your intended recipient can access.',
							'<em class="text-gray-300">',
							'</em>'
						) ?>
					</p>
					<p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
						<?= __(
							'When your recipient opens the link, they will be able to read the message, and it will be deleted from our servers after the configured rules are applied.'
						) ?>
					</p>
					<a href="/app/send">
						<button
							type="button"
							class="inline-block rounded-md bg-indigo-600 px-6 pt-2.5 pb-2 text-sm font-medium uppercase leading-normal text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-8"
						>
							<?= __('Send your first message') ?>
						</button>
					</a>
				</div>
			</div>
		</div>
		<?php
		return $this->end();
	}
}
