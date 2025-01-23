<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried map function.
 * Accepts more than arrays.
 *
 * @param  callable $fn
 * @param  iterable<mixed,mixed>|null $collection
 * @return ($collection is null ? callable : array)
 */
function map(callable $fn, ?iterable $collection = null) {
    return autocurry(
        function ($fn, $collection): array {
            $collection = $collection instanceof \Traversable ? iterator_to_array($collection) : $collection;
            return array_map($fn, $collection);
        },
        2
    )(...func_get_args());
}

const map = '\Garp\Functional\map';
