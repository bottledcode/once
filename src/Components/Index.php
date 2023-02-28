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
		<html lang="{<?= $this->language->currentLanguage ?>}">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Document</title>
		</head>
		<body>
		<h1>Hello World</h1>
		</body>
		</html>
		<?php
		return $this->end();
	}
}
