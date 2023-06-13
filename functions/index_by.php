<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Like group_by, but the values of the resulting map are no collections – only a single result is
 * indexed by the given $indexFn.
 *
 * @param  callable|string $indexFn
 * @param  array<mixed,mixed> $collection
 * @return ($collection is null ? callable : int)
 * @see group_by
 */
function index_by($indexFn, iterable $collection = null) {
    return autocurry(
        function ($indexFn, $collection): array {
            $indexFn = !is_callable($indexFn) ? prop($indexFn) : $indexFn;
            return reduce(
                function ($acc, $cur) use ($indexFn) {
                    $key = $indexFn($cur);
                    if (!is_int($key) && !is_string($key)) {
                        throw new \InvalidArgumentException(
                            'index_by expects result of first argument to be of type integer or string'
                        );
                    }
                    $acc[$key] = $cur;
                    return $acc;
                },
                [],
                $collection
            );
        },
        2
    )(...func_get_args());
}

const index_by = '\Garp\Functional\index_by';
