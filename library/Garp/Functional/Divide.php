<?php
/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Divide two numbers.
 *
 * @param int $left
 * @param int $right
 * @return int
 */
function divide($left, $right = null) {
    $divider = function ($right) use ($left) {
        return $right / $left;
    };
    return func_num_args() < 2 ? $divider : $divider($right);
}
