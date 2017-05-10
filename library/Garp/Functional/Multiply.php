<?php
/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Multiply two numbers.
 *
 * @param int $left
 * @param int $right
 * @return int
 */
function multiply($left, $right = null) {
    $multiplier = function ($right) use ($left) {
        return $right * $left;
    };
    return func_num_args() < 2 ? $multiplier : $multiplier($right);
}
