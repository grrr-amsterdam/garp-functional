<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Drop the first $n items of a collection.
 *
 * @param  int $n
 * @param  iterable<mixed, mixed>|string $collection
 * @return ($collection is null ? callable : array|string)
 */
function drop(int $n, $collection = null) {
    return autocurry(
        function ($n, $collection) {
            if (is_array($collection)) {
                return array_slice($collection, $n);
            }
            if (is_string($collection)) {
                return substr($collection, $n);
            }
            if ($collection instanceof \Traversable) {
                return drop($n, iterator_to_array($collection));
            }
            throw new \InvalidArgumentException('drop expects argument 2 to be a collection');
        },
        2
    )(...func_get_args());
}

const drop = '\Garp\Functional\drop';
