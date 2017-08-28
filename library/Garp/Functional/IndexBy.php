<?php
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
 * @param callable|string $indexFn
 * @param array $collection
 * @return int
 * @see group_by
 */
function index_by($indexFn, $collection = null) {
    $indexFn = !is_callable($indexFn) ? prop($indexFn) : $indexFn;
    $grouper = function ($collection) use ($indexFn) {
        return reduce(
            function ($acc, $cur) use ($indexFn) {
                $key = $indexFn($cur);
                if (!is_int($key) && !is_string($key)) {
                    throw new \InvalidArgumentException(
                        'Key is not usable as index. Must be of type integer or string'
                    );
                }
                $acc[$key] = $cur;
                return $acc;
            },
            array(),
            $collection
        );
    };
    return func_num_args() < 2 ? $grouper : $grouper($collection);
}
