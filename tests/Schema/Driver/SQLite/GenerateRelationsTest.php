<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\SQLite;

use Cycle\Schema\Tests\Generator\GenerateRelationsTest as BaseTest;

/**
 * @group driver
 * @group driver-sqlite
 */
class GenerateRelationsTest extends BaseTest
{
    public const DRIVER = 'sqlite';
}
