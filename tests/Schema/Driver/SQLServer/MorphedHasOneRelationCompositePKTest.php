<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests\Driver\SQLServer;

use Cycle\Schema\Tests\Relation\Morphed\MorphedHasOneRelationCompositePKTest as BaseTest;

class MorphedHasOneRelationCompositePKTest extends BaseTest
{
    public const DRIVER = 'sqlserver';
}
