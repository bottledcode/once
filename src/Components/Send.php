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
		<div class="p-5 bg-gray-100">
			<div class="md:grid md:grid-cols-3 md:gap-6">
				<send:left-part
					title="{<?= __('Send a message') ?>}"
					subtitle="{<?= __('Send a message to someone') ?>}"
				></send:left-part>
				<div class="mt-5 md:col-span-2 md:mt-0">
					<div class="shadow sm:overflow-hidden sm:rounded-md">
						<div class="space-y-6 bg-white px-4 py-5 sm:p-6">
							<div class="grid grid-cols-3 gap-6">
								<div class="col-span-3 sm:col-span-2">
									<send:label for="somethign">
										{<?= __('Email Address') ?>}
									</send:label>
									<div class="mt-2 flex rounded-md shadow-sm">
											<span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 px-3 text-gray-500 sm:text-sm">
												http://
											</span>
										<input
											type="text"
											name="saf"
											id="somethign"
											class="block w-full flex-1 rounded-none rounded-r-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
											placeholder="safds"
										>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return $this->end();
	}
}
