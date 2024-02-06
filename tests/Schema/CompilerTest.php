<?php

declare(strict_types=1);

namespace Cycle\Schema\Tests;

use Cycle\Database\DatabaseProviderInterface;
use Cycle\ORM\Parser\Typecast;
use Cycle\ORM\SchemaInterface;
use Cycle\Schema\Compiler;
use Cycle\Schema\Definition\Entity;
use Cycle\Schema\Definition\Field;
use Cycle\Schema\Exception\CompilerException;
use Cycle\Schema\Exception\SchemaModifierException;
use Cycle\Schema\Registry;
use Cycle\Schema\Tests\Fixtures\Author;
use Cycle\Schema\Tests\Fixtures\BrokenSchemaModifier;
use Cycle\Schema\Tests\Fixtures\Typecaster;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{
    public function testWrongGeneratorShouldThrowAnException(): void
    {
        $this->expectException(CompilerException::class);
        $this->expectExceptionMessage(
            'Invalid generator `\'Cycle\\\\Schema\\\\Tests\\\\Fixtures\\\\Author\'`. '
            . 'It should implement `Cycle\Schema\GeneratorInterface` interface.'
        );

        $r = new Registry(
            $this->createMock(DatabaseProviderInterface::class)
        );

        $author = new Entity();
        $author->setRole('author')->setClass(Author::class);
        $author->getFields()->set('id', (new Field())->setType('primary')->setColumn('id'));

        $r->register($author);

        (new Compiler())->compile($r, [
            Author::class,
        ]);
    }

    public function testWrongEntitySchemaModifierShouldThrowAnException(): void
    {
        $this->expectException(SchemaModifierException::class);
        $this->expectExceptionMessage(
            'Unable to apply schema modifier `Cycle\Schema\Tests\Fixtures\BrokenSchemaModifier` '
            . 'for the `author` role. Something went wrong'
        );

        $r = new Registry(
            $this->createMock(DatabaseProviderInterface::class)
        );

        $author = new Entity();
        $author->setRole('author')->setClass(Author::class);
        $author->getFields()->set('id', (new Field())->setType('primary')->setColumn('id'));

        $author->addSchemaModifier(new BrokenSchemaModifier(BrokenSchemaModifier::class . '::modifySchema'));

        $r->register($author);

        (new Compiler())->compile($r);
    }

    /**
     * @dataProvider renderTypecastDataProvider
     */
    public function testRenderTypecast(mixed $expected, array $defaults, mixed $entityTypecast = null): void
    {
        $entity = new Entity();
        $entity->setRole('author')->setClass(Author::class);
        $entity->getFields()->set('id', (new Field())->setType('primary')->setColumn('id'));
        if ($entityTypecast) {
            $entity->setTypecast($entityTypecast);
        }

        $r = new Registry($this->createMock(DatabaseProviderInterface::class));
        $r->register($entity);

        $schema = (new Compiler())->compile($r, [], $defaults);

        $this->assertSame($expected, $schema['author'][SchemaInterface::TYPECAST_HANDLER]);
    }

    public function testRenderGeneratedFields(): void
    {
        $entity = new Entity();
        $entity->setRole('author')->setClass(Author::class);
        $entity->getFields()->set('id', (new Field())->setType('primary')->setColumn('id'));
        $entity->getFields()->set('name', (new Field())->setType('string')->setColumn('name'));
        $entity->getFields()->set('createdAt', (new Field())
            ->setType('datetime')
            ->setColumn('created_at')
            ->setGenerated(SchemaInterface::GENERATED_PHP_INSERT)
        );
        $entity->getFields()->set('updatedAt', (new Field())
            ->setType('datetime')
            ->setColumn('created_at')
            ->setGenerated(SchemaInterface::GENERATED_PHP_INSERT | SchemaInterface::GENERATED_PHP_UPDATE)
        );
        $entity->getFields()->set('sequence', (new Field())
            ->setType('serial')
            ->setColumn('some_sequence')
            ->setGenerated(SchemaInterface::GENERATED_DB)
        );

        $r = new Registry($this->createMock(DatabaseProviderInterface::class));
        $r->register($entity);

        $schema = (new Compiler())->compile($r);

        $this->assertSame([
            'createdAt' => SchemaInterface::GENERATED_PHP_INSERT,
            'updatedAt' => SchemaInterface::GENERATED_PHP_INSERT | SchemaInterface::GENERATED_PHP_UPDATE,
            'sequence' => SchemaInterface::GENERATED_DB,
        ], $schema['author'][SchemaInterface::GENERATED_FIELDS]);
    }

    public static function renderTypecastDataProvider(): \Traversable
    {
        yield [null, []];
        yield [Typecaster::class, [], Typecaster::class];
        yield [[Typecaster::class], [SchemaInterface::TYPECAST_HANDLER => Typecaster::class]];
        yield [
            [Typecaster::class, Typecast::class],
            [SchemaInterface::TYPECAST_HANDLER => Typecast::class],
            Typecaster::class,
        ];
        yield [
            [Typecaster::class, Typecast::class],
            [SchemaInterface::TYPECAST_HANDLER => [Typecaster::class, Typecast::class]],
            Typecaster::class,
        ];
    }
}
