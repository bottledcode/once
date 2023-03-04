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
            <!--
                        <header class="bg-white shadow">
                            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
                            </div>
                        </header>
                        <main>
                            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                            </div>
                        </main>
                        -->
        </div>
        </body>
        </html>
		<?php
		return $this->end();
	}
}
