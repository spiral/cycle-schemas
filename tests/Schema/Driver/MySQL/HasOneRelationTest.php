<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\MySQL;

use Cycle\Schema\Tests\Relation\HasOneRelationTest as BaseTest;

/**
 * @group driver
 * @group driver-mysql
 */
class HasOneRelationTest extends BaseTest
{
    public const DRIVER = 'mysql';
}
