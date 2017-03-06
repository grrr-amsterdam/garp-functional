<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Sort a collection by the given prop.
 *
 * @param string $prop
 * @param array $collection
 * @return int
 */
function sort_by($prop, $collection = null) {
    $sorter = function ($collection) use ($prop) {
        return usort(
            function ($a, $b) use ($prop) {
                $propA = prop($prop, $a);
                $propB = prop($prop, $b);
                return ($propA < $propB) ? -1 : 1;
            },
            $collection
        );
    };
    return func_num_args() < 2 ? $sorter : $sorter($collection);
}
