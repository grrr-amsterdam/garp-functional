<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns a value from a nested associative structure matching the given keys.
 *
 * @param array  $keys       The keys representing a nested structure from left to right
 * @param mixed  $collection The collection to search in
 * @return mixed
 */
function prop_in(array $keys, $collection = null) {
    if (!count($keys)) {
        return null;
    }
    $getter = function ($collection) use ($keys) {
        return reduce(
            function ($acc, $key) use ($collection) {
                return prop($key, $acc);
            },
            $collection,
            $keys
        );
    };
    return func_num_args() < 2 ? $getter : $getter($collection);
}
