<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\MySQL;

use Cycle\Schema\Tests\Relation\RefersToRelationCompositePKTest as BaseTest;

/**
 * @group driver
 * @group driver-mysql
 */
class RefersToRelationCompositePKTest extends BaseTest
{
    public const DRIVER = 'mysql';
}
