<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Router\Attributes\Route;
use Bottledcode\SwytchFramework\Router\Method;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Compiler;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;
use Withinboredom\Once\Exceptions\MessageExpired;
use Withinboredom\Once\Exceptions\PasswordRequired;
use Withinboredom\Once\Repositories\MessageRepository;

#[Component('reader')]
readonly class Reader
{
	use Htmx;
	use RegularPHP;

	public function __construct(private Compiler $compiler, private MessageRepository $messageRepository)
	{
	}

	#[Route(Method::PUT, '/api/user/message/decrypt')]
	public function usePassword(string $password, string $target_id, array $state): string
	{
		return $this->rerender($target_id, [...$state, 'password' => $password]);
	}

	public function render(string $messageId, string|null $password = null): string
	{
		try {
			$message = $this->messageRepository->get($messageId, $_SERVER['HTTP_X_AUTH_REQUEST_EMAIL'], $password);
		} catch (MessageExpired) {
			$this->begin();
			?>
			<div class="p-5 bg-gray-100 dark:text-gray-300 dark:bg-slate-800 min-h-full prose dark:prose-invert">
				<h2>This message has expired</h2>
				<p>
					There was a message here, but it has expired and thus, inaccessible. The sender will need to send it
					again. There is nothing support can do, so don't bother asking.
				</p>
			</div>
			<?php
			return $this->end();
		} catch (PasswordRequired) {
			$this->begin();
			?>
			<div class="p-5 bg-gray-100 dark:text-gray-300 dark:bg-slate-800 min-h-full">
				<form hx-put="/api/user/message/decrypt">
					<div class="p-5 bg-gray-100 dark:bg-slate-800">
						<div class="md:grid md:grid-cols-3 md:gap-6">
							<send-left-part
								title="{<?= __('A password is required') ?>}"
								subtitle="{<?= __(
									'The sender has password protected this message. They need to share that with you, or maybe you are a lucky guesser.'
								) ?>}"
							></send-left-part>
							<div class="mt-5 md:col-span-2 md:mt-0">
								<div class="shadow sm:overflow-hidden sm:rounded-md">
									<div class="space-y-6 bg-white dark:bg-gray-900 px-4 py-5 sm:p-6">
										<div class="grid grid-cols-6 gap-6">
											<div class="col-span-6 sm:col-span-3">
												<send-label for="first_name">
													{<?= __('Password') ?>}
												</send-label>
												<send-text
													name="password"
													autocomplete="given-name"
													autofocus
													placeholder="{<?= __('My best friend') ?>}"
												></send-text>
											</div>
										</div>
									</div>
								</div>
								<div class="bg-gray-50 dark:bg-slate-600 px-4 py-3 grid grid-cols-2 sm:px-6">
									<div class="col-span-1">
										<p class=" prose dark:prose-invert">
											{<?= p__('A link to swytch follows', 'Do this and more with') ?>} <a
												class=""
												href="https://getswytch.com"
											>Swytch</a>
										</p>
									</div>
									<div class="col-span-1 text-right">
										<button
											type="submit"
											class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
										>
											{<?= __('Unlock') ?>}
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<?php
			return $this->end();
		}

		$this->begin();
		if ($message === null) {
			?>
			<div class="p-5 bg-gray-100 dark:text-gray-300 dark:bg-slate-800 min-h-full">
				No message found

				Please make sure you are signed in with the correct email address and that you have the correct link.
			</div>
			<?php
			return $this->end();
		}

		?>
		<script src="/assets/quill.js"></script>
		<div class="p-5 bg-gray-100 dark:text-gray-300 dark:bg-slate-800 min-h-full">
			<div class="grid grid-cols-1 prose dark:prose-invert prose-lg lg:prose-xl">
				<h2 class="text-xl font-semibold">A message from {<?= $message->sender ?>}</h2>
				<div class="text-xl" id="viewer"></div>
				<input type="hidden" id="message" value="{<?= $message->message ?>}">
			</div>
		</div>
		<script src="/assets/reader.js"></script>
		<?php
		return $this->end();
	}
}
