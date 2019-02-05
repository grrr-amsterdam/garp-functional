<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Checks if $right is less than $left.
 *
 * @param  int|float $left
 * @param  int|float $right
 * @return true
 */
function lt($left, $right = null) {
    return autocurry(
        function ($left, $right): bool {
            return $right < $left;
        },
        2
    )(...func_get_args());
}
