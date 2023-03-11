<?php

namespace Withinboredom\Once\Services;

use Bottledcode\SwytchFramework\Router\Attributes\Route;
use Bottledcode\SwytchFramework\Router\Method;

class HealthCheck {

	#[Route(Method::GET, '/api/healthz')]
	public function check(): string {
		return 'OK';
	}
}
