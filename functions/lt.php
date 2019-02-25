<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

use Garp\Functional\Types\TypeClasses\Ord;

/**
 * Checks if $right is less than $left.
 *
 * @param  int|float|Ord $left
 * @param  int|float|Ord $right
 * @return true
 */
function lt($left, $right = null) {
    return autocurry(
        function ($left, $right): bool {
            return $left instanceof Ord && $right instanceof Ord
                ? $right->lte($left) && !$right->equals($left)
                : $right < $left;
        },
        2
    )(...func_get_args());
}

const lt = '\Garp\Functional\lt';
