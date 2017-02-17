<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Substract two numbers.
 * Note that the first argument is subtracted from the last argument.
 *
 * @param int $left
 * @param int $right
 * @return int
 */
function substract($left, $right = null) {
    $subtractor = function ($right) use ($left) {
        return $right - $left;
    };
    return func_num_args() < 2 ? $subtractor : $subtractor($right);
}
