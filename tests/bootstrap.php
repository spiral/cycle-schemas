<?php

/**
 * Cycle DataMapper ORM
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

use Cycle\Database\Config;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', '1');

//Composer
require dirname(__DIR__) . '/vendor/autoload.php';

$drivers = [
    'sqlite' => new Config\SQLiteDriverConfig(
        queryCache: true,
    ),
    'mysql' => new Config\MySQLDriverConfig(
        connection: new Config\MySQL\TcpConnectionConfig(
            database: 'spiral',
            host: '127.0.0.1',
            port: 13306,
            user: 'root',
            password: 'YourStrong!Passw0rd',
        ),
        queryCache: true,
    ),
    'postgres' => new Config\PostgresDriverConfig(
        connection: new Config\Postgres\TcpConnectionConfig(
            database: 'spiral',
            host: '127.0.0.1',
            port: 15432,
            user: 'postgres',
            password: 'YourStrong!Passw0rd',
        ),
        schema: 'public',
        queryCache: true,
    ),
    'sqlserver' => new Config\SQLServerDriverConfig(
        connection: new Config\SQLServer\TcpConnectionConfig(
            database: 'tempdb',
            host: '127.0.0.1',
            port: 11433,
            user: 'SA',
            password: 'YourStrong!Passw0rd',
        ),
        queryCache: true,
    ),
];

$db = getenv('DB') ?: null;
\Cycle\Schema\Tests\BaseTest::$config = [
    'debug' => false,
    'strict' => true,
    'benchmark' => true,
] + (
    $db === null
        ? $drivers
        : array_intersect_key($drivers, array_flip((array) $db))
);
