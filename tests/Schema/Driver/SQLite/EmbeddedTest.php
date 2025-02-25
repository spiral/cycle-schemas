<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\SQLite;

use Cycle\Schema\Tests\Relation\EmbeddedTest as BaseTest;

/**
 * @group driver
 * @group driver-sqlite
 */
class EmbeddedTest extends BaseTest
{
    public const DRIVER = 'sqlite';
}
