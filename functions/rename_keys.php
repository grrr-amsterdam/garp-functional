<?php
declare(strict_types=1);

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
 * @param  array $collection
 * @return array|callable
 */
function rename_keys($transformMap, array $collection = null) {
    return autocurry(
        function ($transformMap, $collection) {
            if (!is_callable($transformMap) && !is_array($transformMap)) {
                throw new \InvalidArgumentException(
                    'rename_keys expects argument 1 to be an array or a function'
                );
            }
            return reduce(
                function ($acc, $cur) use ($transformMap, $collection) {
                    $prop = is_callable($transformMap)
                        ? $transformMap($cur)
                        : prop($cur, $transformMap);

                    return prop_set(
                        $prop ?: $cur,
                        always($collection[$cur]), // Why? Because: https://github.com/grrr-amsterdam/garp-functional/pull/20
                        $acc
                    );
                },
                [],
                keys($collection)
            );
        },
        2
    )(...func_get_args());
}

const rename_keys = '\Garp\Functional\rename_keys';
