<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns a value from a nested associative structure matching the given keys.
 *
 * @param  array  $keys       The keys representing a nested structure from left to right
 * @param  mixed  $collection The collection to search in
 * @return mixed
 */
function prop_in(array $keys, $collection = null) {
    return autocurry(
        function ($keys, $collection) {
            if (!count($keys)) {
                return null;
            }
            return reduce(
                function ($acc, $key) use ($collection) {
                    return prop($key, $acc);
                },
                $collection,
                $keys
            );
        },
        2
    )(...func_get_args());
}

const prop_in = '\Garp\Functional\prop_in';