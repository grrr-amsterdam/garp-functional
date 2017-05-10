<?php
/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Modulo of two numbers.
 *
 * @param int $left
 * @param int $right
 * @return int
 */
function modulo($left, $right = null) {
    $moduler = function ($right) use ($left) {
        return $right % $left;
    };
    return func_num_args() < 2 ? $moduler : $moduler($right);
}
