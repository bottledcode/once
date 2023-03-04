<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Authenticated;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('send')]
#[Authenticated(visible: true)]
class Send
{
	use RegularPHP;
	use Htmx;

	public function render(): string
	{
		$this->begin();
		?>
		<script xmlns:send="http://www.w3.org/1999/html">
			document.title = '{<?= __('Once — Send A Message') ?>}';
		</script>
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
									<send:label for="first-name">
										{<?= __('Name') ?>}
									</send:label>
									<send:text
										name="first-name"
										autocomplete="given-name"
										placeholder="{<?= __('My best friend') ?>}"
									></send:text>
								</div>
								<div class="col-span-6 sm:col-span-3">
									<send:label for="email-address">
										{<?= __('Email address') ?>}
									</send:label>
									<send:text
										name="email-address"
										autocomplete="email"
										type="email"
										placeholder="{<?= __('friend@example.com') ?>}"
									></send:text>
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
				<div class="mt-5 md:col-span-2 md:mt-0">
					<div class="shadow sm:overflow-hidden sm:rounded-md">
						<div class="space-y-6 pb-0 sm:pb-0 bg-white dark:bg-gray-900 px-4 py-5 sm:p-6">
							<div class="grid grid-cols-6 gap-6">
								<div class="col-span-6 dark:bg-white">
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
							<div class="grid grid-cols-6 gap-6">
								<div class="col-span-6 sm:col-span-3">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<link href="/assets/quill.snow.css" rel="stylesheet">
		<script src="/assets/quill.js"></script>
		<script src="/assets/editor.js"></script>
		<?php
		return $this->end();
	}
}
