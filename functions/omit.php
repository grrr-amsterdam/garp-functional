<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a copy of the array that does not contain the specified keys.
 *
 * @param  array           $omitted
 * @param  iterable|object $collection
 * @return array|callable
 */
function omit(array $omitted, $collection = null) {
    return autocurry(
        function ($omitted, $collection): array {
            return reduce(
                function ($obj, $key) use ($collection) {
                    $obj[$key] = prop($key, $collection);
                    return $obj;
                },
                [],
                filter(not(partial_right('in_array', $omitted)), keys($collection))
            );
        },
        2
    )(...func_get_args());
}

const omit = '\Garp\Functional\omit';
