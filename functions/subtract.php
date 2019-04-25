<?php
declare(strict_types=1);

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
 * @param  int|float $left
 * @param  int|float $right
 * @return int|float
 * @deprecated This function name contains a typo, and will be removed in the next major version. Use subtract instead.
 * @see subtract
 */
function substract($left, $right = null) {
    trigger_error(
        'substract is deprecated and will be removed in the next major version. Use Garp\Functional\subtract instead',
        E_USER_DEPRECATED
    );
    return subtract(...func_get_args());
}

/**
 * Subtract two numbers.
 * Note that the first argument is subtracted from the last argument.
 *
 * @param  int|float $left
 * @param  int|float $right
 * @return int|float
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