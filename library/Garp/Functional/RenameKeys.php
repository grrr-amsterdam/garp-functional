<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Rename keys in an array.
 *
 * @param  mixed $transformMap
 * @param  mixed $collection
 * @return array
 */
function rename_keys($transformMap, array $collection = null) {
    if (!is_callable($transformMap) && !is_array($transformMap)) {
        throw new \InvalidArgumentException(
            'rename_keys expects argument 1 to be an array or a function'
        );
    }
    $transformer = function ($collection) use ($transformMap) {
        return reduce(
            function ($acc, $cur) use ($transformMap, $collection) {
                $prop = is_callable($transformMap)
                    ? $transformMap($cur)
                    : prop($cur, $transformMap);
                return prop_set(
                    $prop ?: $cur,
                    $collection[$cur],
                    $acc
                );
            },
            [],
            keys($collection)
        );
    };
    return func_num_args() < 2 ? $transformer : $transformer($collection);
}
