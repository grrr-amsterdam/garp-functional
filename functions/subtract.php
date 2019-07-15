<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Subtract two numbers.
 * Note that the first argument is subtracted from the last argument.
 *
 * @param  int|float $left
 * @param  int|float $right
 * @return int|float|callable
 */
function subtract($left, $right = null) {
    return autocurry(
        function ($left, $right) {
            return $right - $left;
        },
        2
    )(...func_get_args());
}

const subtract = '\Garp\Functional\subtract';
