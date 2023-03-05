<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use r\Connection;
use r\ConnectionOptions;
use r\Options\Durability;
use r\Options\TableCreateOptions;

use function r\db;
use function r\dbCreate;
use function r\row;

//ini_set('display_errors', '1');
//ini_set('error_reporting', E_ALL & !E_DEPRECATED);

define('DATABASE', getenv('RETHINKDB_DATABASE') ?: throw new LogicException('RETHINKDB_DATABASE not set'));
define('USER', getenv('RETHINKDB_USER') ?: throw new LogicException('RETHINKDB_USER not set'));
define('PASSWORD', getenv('RETHINKDB_PASSWORD') ?: throw new LogicException('RETHINKDB_PASSWORD not set'));

echo "Starting up...\n";

try {
	$admin_connection = new Connection(
		new ConnectionOptions(
			host: getenv('RETHINKDB_HOST') ?: 'localhost',
			db: 'rethinkdb',
			user: 'admin',
			password: getenv('RETHINKDB_ADMIN_PASSWORD') ?: throw new LogicException(
				'RETHINKDB_ADMIN_PASSWORD not set'
			),
		)
	);
} catch (Throwable $exception) {
	echo "Could not connect to RethinkDB: {$exception->getMessage()}\n";
	exit(1);
}

echo "Connected...\n";

$tables = [
	'messages' => [],
];

doForSuccess(checkDatabaseExists(DATABASE), noop(...), createDatabase(DATABASE));
echo "Database " . DATABASE . " created\n\nCreating tables\n";
foreach ($tables as $table => $indices) {
	doForSuccess(checkTable(DATABASE, $table), noop(...), createTable(DATABASE, $table));
	echo "Table $table created\n\n";
}
echo "Tables created\n\nCreating indices\n";
doForSuccess(static function () use ($tables) {
	global $admin_connection;

	foreach ($tables as $table => $indices) {
		$actual = db(DATABASE)->table($table)->indexList()->run($admin_connection);
		$indices = array_keys($indices);
		sort($actual);
		sort($indices);
		if ($actual !== $indices) {
			return false;
		}
	}

	return true;
}, noop(...), static function () use ($tables) {
	global $admin_connection;

	foreach ($tables as $table => $indices) {
		$actual = db(DATABASE)->table($table)->indexList()->run($admin_connection);
		sort($actual);
		foreach ($actual as $index) {
			if (!array_key_exists($index, $indices)) {
				echo "Index $index on table $table dropped\n";
				db(DATABASE)->table($table)->indexDrop($index)->run($admin_connection);
			}
		}
		foreach ($indices as $index => $options) {
			echo "Creating index $index on table $table\n";
			if (!in_array($index, $actual, true)) {
				try {
					$func = match ([$options['geo'] ?? false, $options['multi'] ?? false]) {
						[true, true] => 'indexCreateMultiGeo',
						[true, false] => 'indexCreateGeo',
						[false, true] => 'indexCreateMulti',
						default => 'indexCreate',
					};
					db(DATABASE)->table($table)->$func($index, $options['options'] ?? null)->run($admin_connection);
				} catch (Throwable $ex) {
					echo "$ex\nFailed to create $index on table $table\n";
					exit(1);
				}
				echo "Index $index on table $table created\n";
			}
		}
	}
});
echo "Indices created\n\nCreating user\n";
doForSuccess(static function () use ($admin_connection) {
	$user = db('rethinkdb')->table('users')->get(USER)->run($admin_connection);

	return $user !== null;
}, noop(...), static function () use ($admin_connection) {
	db('rethinkdb')->table('users')->insert([
		'id' => USER,
		'password' => PASSWORD,
	])->run($admin_connection);
});
echo "User created\n\nGranting access\n";
doForSuccess(static function () use ($admin_connection) {
	foreach (
		db('rethinkdb')
			->table('permissions')
			->filter(['database' => DATABASE, 'user' => USER])
			->run($admin_connection) as $permission
	) {
		return true;
	}

	return false;
}, noop(...), static function () use ($admin_connection) {
	echo "Visit http://" . dns_get_record(
			getenv('RETHINKDB_HOST'),
			DNS_A,
			raw: false
		)[0]['ip'] . ":8080/#dataexplorer and run:\n";
	echo "\tr.db('" . DATABASE . "').grant('" . USER . "', {read: true, write: true, config: true})\n";
	sleep(5);
});
echo "User access granted\n";

function doForSuccess(callable $check, callable $success, callable $fail)
{
	if ($check()) {
		$success();
	} else {
		$fail();
		sleep(1);
		doForSuccess($check, $success, $fail);
	}
}

function noop(): void
{
}

function checkDatabaseExists(string $database): callable
{
	global $admin_connection;

	return static function () use ($admin_connection, $database): bool {
		echo "Checking for database '$database'...\n";
		try {
			db($database)->info()->run($admin_connection);

			return true;
		} catch (Throwable) {
			return false;
		}
	};
}

function createDatabase(string $database): callable
{
	global $admin_connection;

	return static function () use ($admin_connection, $database): void {
		echo "Creating database '$database'...\n";
		dbCreate($database)->run($admin_connection);
	};
}

function checkTable(string $db, string $table): callable
{
	global $admin_connection;

	return static function () use ($admin_connection, $db, $table): bool {
		echo "Checking for table '$table'...\n";
		try {
			db($db)->table($table)->info()->run($admin_connection);

			return true;
		} catch (Throwable) {
			return false;
		}
	};
}

function createTable(
	string $db,
	string $table,
	Durability $durability = Durability::Soft,
	int $shards = 3,
	int $replicas = 3,
	string $primaryKey = 'id'
): callable {
	global $admin_connection;

	return static function () use ($replicas, $shards, $durability, $primaryKey, $admin_connection, $table, $db): void {
		echo "Creating table '$table'...\n";
		db($db)->tableCreate(
			$table,
			new TableCreateOptions(
				primaryKey: $primaryKey,
				durability: $durability,
				shards: $shards,
				replicas: $replicas
			)
		)->run($admin_connection);
	};
}
