<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Sort an array by a given reference array.
 *
 * @param  array    $map
 * @param  iterable $collection
 * @return array
 */
function sort_by_map(array $map, $collection = null) {
    return autocurry(
        function ($map, $collection) {
            if (is_assoc($collection)) {
                $map = array_flip(array_intersect($map, array_keys($collection)));
                return array_merge($map, $collection);
            }
            $map = array_flip($map);
            $length = count($collection);
            return usort(
                function ($a, $b) use ($map, $length) {
                    return ($map[$a] ?? $length) <=> ($map[$b] ?? $length);
                },
                $collection
            );
        },
        2
    )(...func_get_args());
}

const sort_by_map = '\Garp\Functional\sort_by_map';