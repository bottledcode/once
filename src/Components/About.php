<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Hooks\Html\HeadTagFilter;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('about')]
class About
{
	use RegularPHP;
	use Urls;

	public function __construct(private readonly HeadTagFilter $headers)
	{
	}

	public function render(): string
	{
		$this->headers->setTitle('Once — About');
		$this->headers->setOpenGraph(
			$this->getUrlForPath('/about', false),
			'About Once',
			'Say it securely, Once and for all',
			$this->getUrlForPath('/assets/preview.png', false)
		);

		$this->begin();
		?>
		<script>
			document.title = 'Once — About';
		</script>
		<div class="py-6 sm:py-8">
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="mx-auto max-w-2xl lg:mx-0">
					<h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-300 sm:text-4xl">
						<?= __(
							'About Once'
						) ?>
					</h2>
					<p class="mt-2 text-lg leading-8 text-gray-600 dark:text-gray-400">
						<?= __('Say it securely, Once and for all') ?>
					</p>
				</div>
				<div class="mx-auto mt-8 grid max-w-2xl grid-cols-1 gap-y-16 gap-x-8 border-t border-gray-200 dark:border-gray-700 pt-10 sm:mt-8 lg:mx-0 lg:max-w-none">
					<article class="prose dark:prose-invert prose-lg lg:prose-xl">
						<p>
							<?= __(
								'Welcome to our messaging service! We are proud to offer a secure, efficient, and user-friendly platform for sending self-destructing messages. Our service was built using the Swytch Framework, a cutting-edge development tool that enables us to create fast and responsive web applications.'
							) ?>
						</p>
						<p>
							<?= __(
								"Our team at Wicked Monkey Software developed this project as an example of the Swytch Framework's capabilities, showcasing its ability to create complex and robust applications with ease. We wanted to demonstrate how the framework can be used to create applications that are both powerful and intuitive, making it easier than ever to build scalable and reliable software solutions."
							) ?>
						</p>
						<p>
							<?= __(
								"At Wicked Monkey Software, we are committed to using the latest tools and technologies to build innovative solutions that meet the needs of our clients. Our team of experienced developers and designers bring a wealth of expertise to every project, and we are passionate about creating software that is not only functional, but also beautiful and user-friendly."
							) ?>
						</p>
						<p>
							<?= __(
								"We believe that our messaging service is an excellent example of our commitment to excellence in software development. With its intuitive user interface, powerful security features, and support for all devices, it provides a seamless and secure way to send sensitive information. We hope that you will enjoy using our service, and that it will serve as a testament to the power and versatility of the Swytch Framework."
							) ?>
						</p>
					</article>
				</div>
			</div>
		</div>
		<?php
		return $this->end();
	}
}
