<?php

use Bottledcode\SwytchFramework\App;
use Bottledcode\SwytchFramework\Logging\StdOutputLogger;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Log\LoggerInterface;
use Withinboredom\Once\Components\Index;

use function DI\create;
use function DI\get;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/attributes.php';

$app = new App(
	function_exists('xdebug_break'),
	Index::class,
	[
		StdOutputLogger::class => create(StdOutputLogger::class)
			->method(
				'setFormatter',
				get(LogstashFormatter::class)
			),
		LogstashFormatter::class => create(LogstashFormatter::class)->constructor('once'),
		LoggerInterface::class => create(Logger::class)
			->method(
				'pushHandler',
				get(StdOutputLogger::class)
			)
			->method('pushProcessor', get(MemoryUsageProcessor::class))
			->method('pushProcessor', get(MemoryPeakUsageProcessor::class))
			->method('pushProcessor', get(WebProcessor::class)),
	],
);

$app->run();
