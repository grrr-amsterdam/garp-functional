<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a copy of the array that does not contain the specified keys.
 *
 * @param array $omitted
 * @param array $collection
 * @return array
 */
function omit(array $omitted, $collection = null) {
    $omitter = function ($collection) use ($omitted) {
        return reduce(
            function ($obj, $key) use ($collection) {
                $obj[$key] = prop($key, $collection);
                return $obj;
            },
            array(),
            filter(not(partial_right('in_array', $omitted)), keys($collection))
        );
    };
    return func_num_args() < 2 ? $omitter : $omitter($collection);
}
