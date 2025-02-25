<?php

declare(strict_types=1);

namespace Cycle\Schema;

use Cycle\Schema\Definition\Entity;

/**
 * Gives ability for the relation to be inverted.
 */
interface InversableInterface extends RelationInterface
{
    /**
     * Return all targets to which relation must be inversed to.
     *
     * @return Entity[]
     */
    public function inverseTargets(Registry $registry): array;

    /**
     * Inverse relation options into given schema.
     *
     * @param string            $into Target relation name.
     * @param int|null          $load Target relation pre-load method (null, EAGER, PROMISE)
     *
     */
    public function inverseRelation(RelationInterface $relation, string $into, ?int $load = null): RelationInterface;
}
