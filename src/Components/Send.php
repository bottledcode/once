<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Router\Attributes\Authorized;
use Bottledcode\SwytchFramework\Router\Attributes\Route;
use Bottledcode\SwytchFramework\Router\Method;
use Bottledcode\SwytchFramework\Template\Attributes\Authenticated;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Compiler;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;
use Withinboredom\Once\Models\NewMessage;
use Withinboredom\Once\Repositories\MessageRepository;
use Withinboredom\Once\Roles;

#[Component('send')]
#[Authenticated(visible: true)]
readonly class Send
{
	use RegularPHP;
	use Htmx;

	public function __construct(private Compiler $compiler, private MessageRepository $messageRepository)
	{
	}

	#[Route(Method::PUT, '/api/user/message')]
	#[Authorized(role: Roles::User)]
	public function send(
		NewMessage $message
	): string {
		$savedMessage = $this->messageRepository->save($message);

		// todo: send email to receiver??
		$this->historyPush('/sent/' . $savedMessage->id);

		$this->begin();
		?>
		<div class="p-5 bg-gray-100 dark:bg-slate-800 min-h-full">
			<div class="grid grid-cols-1">
				<h2 class="text-xl font-semibold tracking-tight mx-auto dark:text-gray-300">Your message has been
					stored</h2>
				<p class="mx-auto py-3 dark:text-gray-300">
					<strong>What now?</strong> Below is a link to your message. Only the person who has this link and
					the ability to login with that email address can read your message. <strong>We do <em>NOT</em> send
						an email to your recipient for you. You will need to give them the link below.</strong>
				</p>
				<div class="my-3 relative">
					<input
						type="text"
						readonly
						id="message_link"
						class="rounded-md w-full text-sm dark:bg-gray-900 dark:text-gray-400"
						value="https://auth.getswytch.com/app/read/{<?= $savedMessage->id ?>}"
					>
					<div
						class="absolute ease-in-out transition-opacity duration-700 opacity-0 inset-y-0 right-0 flex items-center rounded-md bg-red-600 h-full text-gray-300 text-sm"
						id="message_copied"
					>
						Copied to clipboard
					</div>
					<script src="/assets/copy-to-cb.js"></script>
				</div>
				<div class="py-6 dark:text-gray-300 mx-auto">
					Send <a href="/app/send" class="underline font-semibold">another message</a>
				</div>
			</div>
		</div>
		<?php
		return $this->html($this->end());
	}

	#[Route(Method::GET, '/api/user/message/password')]
	public function setPassword(): string
	{
		$this->retarget('#modal');
		$this->begin();
		?>
		<modal destination="#password"></modal>
		<?php
		return $this->html($this->end());
	}

	public function render(): string
	{
		$this->begin();
		?>
		<script xmlns:send="http://www.w3.org/1999/html">
			document.title = '{<?= __('Once — Send A Message') ?>}';
		</script>
		<form hx-put="/api/user/message">
			<div class="p-5 bg-gray-100 dark:bg-slate-800">
				<div class="md:grid md:grid-cols-3 md:gap-6">
					<send:left-part
						title="{<?= __('Receiver') ?>}"
						subtitle="{<?= __('Tell us who should receive this message') ?>}"
					></send:left-part>
					<div class="mt-5 md:col-span-2 md:mt-0">
						<div class="shadow sm:overflow-hidden sm:rounded-md">
							<div class="space-y-6 bg-white dark:bg-gray-900 px-4 py-5 sm:p-6">
								<div class="grid grid-cols-6 gap-6">
									<div class="col-span-6 sm:col-span-3">
										<send:label for="first_name">
											{<?= __('Name') ?>}
										</send:label>
										<send-text
											name="first_name"
											autocomplete="given-name"
											placeholder="{<?= __('My best friend') ?>}"
										></send-text>
									</div>
									<div class="col-span-6 sm:col-span-3">
										<send:label for="email_address">
											{<?= __('Email address') ?>}
										</send:label>
										<send-text
											name="email_address"
											autocomplete="email"
											type="email"
											placeholder="{<?= __('friend@example.com') ?>}"
										></send-text>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hidden sm:block" aria-hidden="true">
				<div class="py-5">
					<div class="border-t border-gray-200 dark:border-gray-700"></div>
				</div>
			</div>
			<div class="p-5 bg-gray-100 dark:bg-slate-800">
				<div class="md:grid md:grid-cols-3 md:gap-6">
					<send:left-part
						title="{<?= __('What is the message') ?>}"
						subtitle="{<?= __('Enter the message to deliver') ?>}"
					>
					</send:left-part>
					<input type="hidden" id="text-editor" name="text_editor" value=""/>
					<div class="mt-5 md:col-span-2 md:mt-0">
						<div class="shadow sm:overflow-hidden sm:rounded-md">
							<div class="space-y-6 bg-white dark:bg-gray-900 px-4 py-5 sm:p-6">
								<div class="grid grid-cols-6 gap-6">
									<div class="col-span-6 dark:bg-white h-fit">
										<div id="editor">
											<p>Enter your message here</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hidden sm:block" aria-hidden="true">
				<div class="py-5">
					<div class="border-t border-gray-200 dark:border-gray-700"></div>
				</div>
			</div>
			<div class="p-5 bg-gray-100 dark:bg-slate-800">
				<div class="md:grid md:grid-cols-3 md:gap-6">
					<send:left-part
						title="{<?= __('Define your rules') ?>}"
						subtitle="{<?= __('How will the recipient be allowed to view this message') ?>}"
					></send:left-part>
					<div class="mt-5 md:col-span-2 md:mt-0">
						<div class="shadow sm:overflow-hidden sm:rounded-md">
							<div class="space-y-6 bg-white dark:bg-gray-900 px-4 py-5 sm:p-6">
								<fieldset>
									<legend class="sr-only">Rules</legend>
									<div
										class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300"
										aria-hidden="true"
									>
										Rules
									</div>
									<div class="mt-4 space-y-4">
										<send-checkbox
											name="once_rule"
											label="{<?= __('Self-destruct') ?>}"
											description="{<?= __(
												'Only allow this message to be viewed exactly once'
											) ?>}"
										></send-checkbox>
										<send-checkbox
											name="time_limit"
											label="{<?= __('Time limit') ?>}"
											description="{<?= __(
												'This message will only be available for 12 hours. The default is 72 hours.'
											) ?>}"
										></send-checkbox>
										<send-checkbox
											id="password_checkbox"
											hx-get="/api/user/message/password"
											name="set_password"
											label="{<?= __('Password protect') ?>}"
											description="{<?= __(
												'All messages are encrypted so only the recipient can read the message, but you can add additional protection with a password'
											) ?>}"
										></send-checkbox>
										<input type="hidden" id="password" name="password" value=""/>
									</div>
								</fieldset>
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
										{<?= __('Send it') ?>}
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<link href="/assets/quill.snow.css" rel="stylesheet">
		<script src="/assets/quill.js"></script>
		<script src="/assets/editor.js"></script>
		<?php
		return $this->end();
	}
}
