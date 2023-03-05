<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Language\LanguageAcceptor;
use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('Index')]
class Index
{
	use RegularPHP;

	public function __construct(private LanguageAcceptor $language)
	{
	}

	public function render()
	{
		$meta = '';
		if ($_SERVER['REQUEST_URI'] === '/') {
			$this->begin();
			?>
			<!-- Primary Meta Tags -->
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
			<?php
			$meta = $this->end();
		}

		$this->begin();
		?>
		<!DOCTYPE html>
		<html lang="{<?= $this->language->currentLanguage ?>}" class="h-full bg-color-black dark:bg-slate">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<link rel="icon" href="/assets/logo-small.svg" type="image/svg+xml">
			<link rel="stylesheet" href="/assets/compiled.css">
			<title>Once — Simple Security</title>
			<?= $meta ?>
		</head>
		<body class="h-full">
		<div class="min-h-full dark:bg-slate-800">
			<Navbar open=""></Navbar>

			<Route path="/" render="<Homepage />"></Route>
			<Route path="/app/send" render="<Send />"></Route>
			<Route path="/app/receive" render="<Receive />"></Route>
			<Route path="/about" render="<About />"></Route>
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
