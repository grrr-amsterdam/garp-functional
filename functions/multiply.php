<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Multiply two numbers.
 *
 * @param  int|float $left
 * @param  int|float $right
 * @return ($right is null ? callable : int|float)
 */
function multiply($left, $right = null) {
    return autocurry(
        function ($left, $right) {
            return $right * $left;
        },
        2
    )(...func_get_args());
}

const multiply = '\Garp\Functional\multiply';
