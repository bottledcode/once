<?php

namespace Withinboredom\Once\Services;

use BackedEnum;
use Bottledcode\SwytchFramework\Template\Interfaces\AuthenticationServiceInterface;

class AuthService implements AuthenticationServiceInterface
{
	public function isAuthorizedVia(BackedEnum ...$role): bool
	{
		// we have no roles
		return $this->isAuthenticated();
	}

	public function isAuthenticated(): bool
	{
		$user = $_SERVER['HTTP_X_AUTH_REQUEST_USER'] ?? null;

		return $user !== null;
	}
}
