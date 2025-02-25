<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\Postgres;

use Cycle\Schema\Tests\Relation\BelongsToRelationCompositePKTest as BaseTest;

/**
 * @group driver
 * @group driver-postgres
 */
class BelongsToRelationCompositePKTest extends BaseTest
{
    public const DRIVER = 'postgres';
}
