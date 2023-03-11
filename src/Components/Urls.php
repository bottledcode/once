<?php

namespace Withinboredom\Once\Components;

trait Urls
{
	public function getUrlForPath(string $path, bool $escapeHost = true): string
	{
		$currentHost = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST);
		if (!str_ends_with($currentHost, 'getswytch.com')) {
			return 'https://once.getswytch.com' . $path;
		}
		if ($escapeHost) {
			return "https://{{$currentHost}}{$path}";
		}
		return "https://{$currentHost}{$path}";
	}
}
