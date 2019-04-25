<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Modulo of two numbers.
 *
 * @param  int|float $left
 * @param  int|float $right
 * @return int|float
 */
function modulo($left, $right = null) {
    return autocurry(
        function ($left, $right) {
            return $right % $left;
        },
        2
    )(...func_get_args());
}

const modulo = '\Garp\Functional\modulo';