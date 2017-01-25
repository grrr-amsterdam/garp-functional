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
    $adder = function ($right) use ($left) {
        return $right + $left;
    };
    return is_null($right) ? $adder : $adder($right);
}
