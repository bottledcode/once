<?php

namespace Withinboredom\Once\Components;

trait Urls
{
	public function getUrlForPath(string $path, bool $escapeHost = true): string
	{
		$currentHost = $_SERVER['HTTP_HOST'];
		if (!str_ends_with($currentHost, 'getswytch.com')) {
			return 'https://once.getswytch.com' . $path;
		}
		if ($escapeHost) {
			return "https://{{$currentHost}}{$path}";
		}
		return "https://{$currentHost}{$path}";
	}
}
