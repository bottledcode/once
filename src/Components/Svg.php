<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Interfaces\RemovePassedAttributes;
use Bottledcode\SwytchFramework\Template\Interfaces\ReplacesHtml;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;
use Exception;

#[Component('svg')]
class Svg implements ReplacesHtml, RemovePassedAttributes
{
	use RegularPHP;

	private bool $rendered = false;

	public static function removePassedAttributes(): bool
	{
		return false;
	}

	public function render(string|null $src = null, string $class = ''): string
	{
		if ($src === null) {
			return '';
		}

		$src = str_replace('..', '', $src);

		$this->rendered = true;

		$file = __DIR__ . '/../../html' . $src;
		if (!file_exists($file)) {
			throw new Exception("File $file does not exist");
		}
		$svg = file_get_contents($file);

		if (!empty($class)) {
			$svg = str_replace('<svg', "<svg class=\"$class\"", $svg);
		}

		str_replace('</svg>', '', $svg);

		return $svg;
	}

	public function replaceTag(): bool
	{
		return $this->rendered;
	}
}
