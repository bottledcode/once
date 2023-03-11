<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Hooks\Common\Headers;
use Bottledcode\SwytchFramework\Hooks\Html\HeadTagFilter;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\Htmx;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;
use Withinboredom\Once\Repositories\MessageRepository;

#[Component('ReadRedirector')]
class ReadRedirector
{
	use Htmx;
	use Urls;
	use RegularPHP;

	public function __construct(
		private readonly HeadTagFilter $htmlHead,
		private readonly MessageRepository $messageRepository,
		private readonly Headers $headers,
	) {
	}

	public function render(string $messageId): string
	{
		if (!$this->messageRepository->exists($messageId)) {
			throw new \Bottledcode\SwytchFramework\Router\Exceptions\NotFound();
		}

		$this->htmlHead->setOpenGraph(
			$this->getUrlForPath('/read/' . $messageId, false),
			'Once — Read your secret message',
			'A friend has sent you a secret message. Read it here.',
			$this->getUrlForPath('/assets/preview.png', false)
		);
		$this->htmlHead->setTitle('Once — Read your secret message');

		$this->begin();
		?>
		<div class="w-full flex py-16 sm:py-8 prose prose-lg lg:prose-xl dark:prose-invert justify-center flex-col max-w-none">
			<h1 class="text-center"><?= __('Redirecting...') ?></h1>
			<p class="text-center"><?= __('You will be redirected to the message in a moment.') ?></p>
			<p class="text-center">
				<a
					href="/app/read/{<?= $messageId ?>}"
					class="rounded-md w-fit bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
				>
					<?= __('Open your message') ?>
				</a>
			</p>
		</div>
		<script>
			setTimeout(() =>
					window.location.href = '/app/read/{<?= $messageId ?>}'
				, 1000)
		</script>
		<?php
		return $this->end();
	}
}
