<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns an array from the given collection, keyed by the given index.
 * If index is callable, the collection is keyed by the result of
 * calling the function with the given item in the collection.
 *
 * Inspired by Clojure's group-by function.
 *
 * @param  callable|string $indexFn
 * @param  iterable array $collection
 * @return ($collection is null ? callable : array)
 */
function group_by($indexFn, iterable $collection = null) {
    return autocurry(
        function ($indexFn, $collection): array {
            $indexFn = !is_callable($indexFn) ? prop($indexFn) : $indexFn;
            return reduce(
                function (array $acc, $cur) use ($indexFn) {
                    $key = $indexFn($cur);
                    if (!is_int($key) && !is_string($key)) {
                        throw new \InvalidArgumentException(
                            'group_by expects result of first argument to be of type integer or string'
                        );
                    }
                    $acc[$key][] = $cur;
                    return $acc;
                },
                [],
                $collection
            );
        },
        2
    )(...func_get_args());
}

const group_by = '\Garp\Functional\group_by';
