<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Sort a collection by comparing the results of the given function applied to the arguments in the
 * collection.
 *
 * Inspired by Clojure's `sort-by`
 *
 * @param  callable $fn
 * @param  array $collection
 * @return int
 */
function sort_by(callable $fn, array $collection = null) {
    return autocurry(
        function (callable $fn, array $collection): array {
            return usort(
                function ($a, $b) use ($fn) {
                    $resultA = $fn($a);
                    $resultB = $fn($b);
                    return $resultA <=> $resultB;
                },
                $collection
            );
        },
        2
    )(...func_get_args());
}

const sort_by = '\Garp\Functional\sort_by';