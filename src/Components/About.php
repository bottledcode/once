<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('about')]
class About
{
	use RegularPHP;

	public function render(): string
	{
		$this->begin();
		?>
		<script>
			document.title = 'Once — About';
		</script>
		<div class="py-6 sm:py-8">
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="mx-auto max-w-2xl lg:mx-0">
					<h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-300 sm:text-4xl">{<?= __(
							'About'
						) ?>}</h2>
					<p class="mt-2 text-lg leading-8 text-gray-600 dark:text-gray-400">
						A simple tool for sharing quick secrets with friends, family, and businesses.
					</p>
				</div>
				<div class="mx-auto mt-8 grid max-w-2xl grid-cols-1 gap-y-16 gap-x-8 border-t border-gray-200 dark:border-gray-700 pt-10 sm:mt-8 lg:mx-0 lg:max-w-none">
					<article class="prose dark:prose-invert prose-lg lg:prose-xl">
						<p>
							Once is powered by the <a href="https://github.com/bottledcode/swytch-framework">Swytch
								Framework</a>, a PHP framework for rapid development of web applications. We're proud to
							share this <a href="https://github.com/bottledcode/once">open source</a> project with you.
						</p>
						<p>
							This project scratches an itch for when you need to share a secret with someone, but don't
							want it to be stored insecurely while in-transit. For example, email is not a secure way to
							transmit secure information. Once can allow you to do that.
						</p>
						<p>
							Once is <em>not</em> a replacement for a password manager. It is <em>not</em> a replacement
							for a secure communication channel. It is <em>not</em> a replacement for a secure file
							storage service. It is a <strong>simple</strong> tool for sharing quick secrets with
							friends, family, and businesses.
						</p>
						<p>
							If you so desire, you can self-host this application for your own use. If you choose that
							route, please be aware that you are responsible for the security of your own data. We will
							certainly help you out if you run into any issues.
						</p>
					</article>
				</div>
			</div>
		</div>
		<?php
		return $this->end();
	}
}
