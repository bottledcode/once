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
		$this->begin();
		?>
		<!DOCTYPE html>
		<html lang="{<?= $this->language->currentLanguage ?>}" class="h-full bg-color-black dark:bg-slate">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<link rel="icon" href="/assets/logo-small.svg" type="image/svg+xml">
			<link rel="stylesheet" href="/assets/compiled.css">
			<title>Once -- Simple Security</title>
		</head>
		<body class="h-full">
		<div class="min-h-full dark:bg-slate-800">
			<Navbar open=""></Navbar>

			<Route path="/" render="<Homepage />"></Route>
			<Route path="/app/send" render="<Send />"></Route>
			<Route path="/about" render="<About />"></Route>
			<DefaultRoute render="<not-found />"></DefaultRoute>
		</div>
		</body>
		</html>
		<?php
		return $this->end();
	}
}
