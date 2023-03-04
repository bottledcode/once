<?php

use Bottledcode\SwytchFramework\App;
use Bottledcode\SwytchFramework\Template\Interfaces\AuthenticationServiceInterface;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Log\LoggerInterface;
use Withinboredom\Once\Components\Index;
use Withinboredom\Once\Services\AuthService;

use function DI\create;
use function DI\get;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/attributes.php';

$app = new App(
	function_exists('xdebug_break'),
	Index::class,
	[
		LogstashFormatter::class => create(LogstashFormatter::class)->constructor('once'),
		LoggerInterface::class => create(Logger::class)
			->constructor(name: 'once')
			->method('pushHandler', get(StreamHandler::class))
			->method('pushProcessor', get(MemoryUsageProcessor::class))
			->method('pushProcessor', get(MemoryPeakUsageProcessor::class))
			->method('pushProcessor', get(WebProcessor::class)),
		StreamHandler::class => create(StreamHandler::class)
			->constructor('php://stderr', 100),
		AuthenticationServiceInterface::class => create(AuthService::class)
	],
);

$app->run();
