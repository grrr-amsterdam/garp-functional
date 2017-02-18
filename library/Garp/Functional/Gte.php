<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Checks if $right is greater than or equal to $left.
 *
 * @param int $left
 * @param int $right
 * @return true
 */
function gte($left, $right = null) {
    $checker = function ($right) use ($left) {
        return $right >= $left;
    };
    return func_num_args() < 2 ? $checker : $checker($right);
}
