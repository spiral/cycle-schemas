<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\MySQL;

use Cycle\Schema\Tests\Relation\HasOneRelationCompositePKTest as BaseTest;

/**
 * @group driver
 * @group driver-mysql
 */
class HasOneRelationCompositePKTest extends BaseTest
{
    public const DRIVER = 'mysql';
}
