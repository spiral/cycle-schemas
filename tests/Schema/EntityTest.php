<?php

/**
 * Cycle ORM Schema Builder.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Cycle\Schema\Tests;

use Cycle\Schema\Definition\Entity;
use Cycle\Schema\Definition\Field;
use Cycle\Schema\Definition\Relation;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testRole(): void
    {
        $e = new Entity();
        $e->setRole('role');
        $this->assertSame('role', $e->getRole());
    }

    public function testFields(): void
    {
        $e = new Entity();
        $e->setRole('role');

        $e->getFields()->set('id', new Field());

        $this->assertTrue($e->getFields()->has('id'));
        $e->getFields()->remove('id');
        $this->assertFalse($e->getFields()->has('id'));
    }

    public function testFieldOptions(): void
    {
        $e = new Entity();
        $e->setRole('role');

        $e->getFields()->set('id', new Field());

        $e->getFields()->get('id')->getOptions()->set('name', 'value');
        $this->assertSame('value', $e->getFields()->get('id')->getOptions()->get('name'));
    }

    /**
     * @expectedException \Cycle\Schema\Exception\OptionException
     */
    public function testGetUndefinedOption(): void
    {
        $e = new Entity();
        $e->setRole('role');

        $e->getFields()->set('id', new Field());

        $e->getFields()->get('id')->getOptions()->get('name');
    }

    public function testSetRelation(): void
    {
        $e = new Entity();
        $e->setRole('role');
        $this->assertSame('role', $e->getRole());

        $e->getRelations()->set('test', new Relation());

        $this->assertTrue($e->getRelations()->has('test'));
    }

    /**
     * @expectedException \Cycle\Schema\Exception\RelationException
     */
    public function testGetUndefined(): void
    {
        $e = new Entity();
        $e->setRole('role');
        $this->assertSame('role', $e->getRole());

        $e->getRelations()->get('test');
    }

    /**
     * @expectedException \Cycle\Schema\Exception\RelationException
     */
    public function testSetRelationDouble(): void
    {
        $e = new Entity();
        $e->setRole('role');
        $this->assertSame('role', $e->getRole());

        $e->getRelations()->set('test', new Relation());
        $e->getRelations()->set('test', new Relation());
    }

    /**
     * @expectedException \Cycle\Schema\Exception\RelationException
     */
    public function testRelationNoTarget(): void
    {
        $e = new Entity();
        $e->setRole('role');
        $this->assertSame('role', $e->getRole());

        $e->getRelations()->set('test', new Relation());
        $e->getRelations()->get('test')->getTarget();
    }

    /**
     * @expectedException \Cycle\Schema\Exception\RelationException
     */
    public function testRelationNoType(): void
    {
        $e = new Entity();
        $e->setRole('role');
        $this->assertSame('role', $e->getRole());

        $e->getRelations()->set('test', new Relation());
        $e->getRelations()->get('test')->getType();
    }

    public function testMapper(): void
    {
        $e = new Entity();
        $e->setMapper('mapper');

        $this->assertSame('mapper', $e->getMapper());
    }

    public function testSource(): void
    {
        $e = new Entity();
        $e->setSource('source');

        $this->assertSame('source', $e->getSource());
    }

    public function testConstrain(): void
    {
        $e = new Entity();
        $e->setConstrain('constrain');

        $this->assertSame('constrain', $e->getConstrain());
    }

    public function testRepository(): void
    {
        $e = new Entity();
        $e->setRepository('repository');

        $this->assertSame('repository', $e->getRepository());
    }

    public function testSchema(): void
    {
        $e = new Entity();
        $e->setSchema(['schema']);

        $this->assertSame(['schema'], $e->getSchema());
    }
}
