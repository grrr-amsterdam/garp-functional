<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

use Garp\Functional\Types\Ord;

/**
 * Checks if $right is greater than $left.
 *
 * @param  int|float $left
 * @param  int|float $right
 * @return true
 */
function gt($left, $right = null) {
    return autocurry(
        function ($left, $right): bool {
            return $left instanceof Ord && $right instanceof Ord
                ? $left->lte($right) && !$left->equals($right)
                : $right > $left;
        },
        2
    )(...func_get_args());
}

const gt = '\Garp\Functional\gt';