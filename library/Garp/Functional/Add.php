<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Add two numbers.
 *
 * @param int $left
 * @param int $right
 * @return int
 */
function add($left, $right = null) {
    return autocurry(
        function ($left, $right) {
            return $right + $left;
        },
        2
    )(...func_get_args());
}
