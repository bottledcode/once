<?php

namespace Withinboredom\Once\Services;

use BackedEnum;
use Bottledcode\SwytchFramework\Template\Interfaces\AuthenticationServiceInterface;

class AuthService implements AuthenticationServiceInterface
{
	public function isAuthenticated(): bool
	{
		$user = $_SERVER['HTTP_X_AUTH_REQUEST_USER'] ?? null;

		return $user !== null;
	}

	public function isAuthorizedVia(BackedEnum ...$role): bool
	{
		$roles = $_SERVER['HTTP_X_AUTH_REQUEST_USER'] ?? '';
		$roles = explode(':', $roles, 2)[1] ?? null;

		if ($roles === null) {
			return false;
		}

		$roles = explode(',', $roles);

		foreach ($role as $r) {
			if (in_array($r->value, $roles)) {
				return true;
			}
		}

		return false;
	}
}
