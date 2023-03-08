<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Hooks\Html\HeadTagFilter;
use Bottledcode\SwytchFramework\Language\LanguageAcceptor;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('Index')]
class Index
{
	use RegularPHP;

	public function __construct(private readonly LanguageAcceptor $language, private readonly HeadTagFilter $headers)
	{
	}

	/*
	 * <!-- Primary Meta Tags -->
			<title>Once — A simple secret sharing service</title>
			<meta name="title" content="Once — A simple secret sharing service">
			<meta
				name="description"
				content="Once is a tool to allow securely sharing secrets with friends, family, and businesses."
			>

			<!-- Open Graph / Facebook -->
			<meta property="og:type" content="website">
			<meta property="og:url" content="https://once.getswytch.com/">
			<meta property="og:title" content="Once — A simple secret sharing service">
			<meta
				property="og:description"
				content="Once is a tool to allow securely sharing secrets with friends, family, and businesses."
			>
			<meta property="og:image" content="https://once.getswytch.com/assets/preview.png">

			<!-- Twitter -->
			<meta property="twitter:card" content="summary_large_image">
			<meta property="twitter:url" content="https://once.getswytch.com/">
			<meta property="twitter:title" content="Once — A simple secret sharing service">
			<meta
				property="twitter:description"
				content="Once is a tool to allow securely sharing secrets with friends, family, and businesses."
			>
			<meta property="twitter:image" content="https://once.getswytch.com/assets/preview.png">
	 */

	public function render()
	{
		$meta = '';
		if ($_SERVER['REQUEST_URI'] === '/') {
			$this->begin();
			?><?php
			$meta = $this->end();
		}

		$this->headers->setTitle('Once — Secret Messages');
		$this->headers->addCss('/assets/compiled.css');
		$this->headers->setOpenGraph(
			'https://once.getswytch.com',
			__('Once — Securely share secrets'),
			__('Say it securely, Once and for all.'),
			'https://once.getswytch.com/assets/preview.png'
		);
		$this->headers->setTwitterCard('summary_large_image', '@withinboredom', '@withinboredom');

		$this->begin();
		?>
		<!DOCTYPE html>
		<html lang="<?= $this->language->currentLanguage ?>" class="h-full bg-color-black dark:bg-slate">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<link rel="icon" href="/assets/logo-small.svg" type="image/svg+xml">
		</head>
		<body class="h-full">
		<div class="min-h-full dark:bg-slate-800">
			<Navbar open=""></Navbar>

			<Route path="/" render="<Homepage />"></Route>
			<Route path="/app/send" render="<Send />"></Route>
			<route path="/app/send/:receiver" render="<Send receiver=':receiver' />"></route>
			<Route path="/app/receive" render="<Receive />"></Route>
			<Route path="/about" render="<About />"></Route>
			<Route path="/app/read/:id" render="<Reader messageId='{{:id}}' />"></Route>
			<Route path="/read/:id" render="<ReadRedirector messageId='{{:id}}' />"></Route>
			<route path="/sendto/:receiver" render="<sendto receiver='{{:receiver}}' />"></route>
			<DefaultRoute render="<not-found />"></DefaultRoute>
		</div>
		<div id="modal"></div>
		<app:footer></app:footer>
		</body>
		</html>
		<?php
		return $this->end();
	}
}
