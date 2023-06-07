<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Drop items from a collection while the predicate function returns true.
 * Stop dropping at the first falsey value.
 *
 * @param  callable $predicate
 * @param  array|string $collection
 * @return ($collection is null ? callable : array)
 */
function drop_while(callable $predicate, $collection = null) {
    return autocurry(
        function ($predicate, $collection): array {
            $collection = is_string($collection) ? str_split($collection) : $collection;
            if (!is_array($collection) && !$collection instanceof \Traversable) {
                throw new \InvalidArgumentException('drop_while expects argument 2 to be a collection');
            }
            return reduce(
                function ($collection, $item) use ($predicate) {
                    return !count($collection) && $predicate($item)
                        ? $collection
                        : concat($collection, [$item]);
                },
                [],
                $collection
            );
        },
        2
    )(...func_get_args());
}

const drop_while = '\Garp\Functional\drop_while';
