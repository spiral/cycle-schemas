<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\Postgres;

use Cycle\Schema\Tests\Relation\RefersToRelationCompositePKTest as BaseTest;

/**
 * @group driver
 * @group driver-postgres
 */
class RefersToRelationCompositePKTest extends BaseTest
{
    public const DRIVER = 'postgres';
}
