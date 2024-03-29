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
 * Checks if $right is greater than or equal to $left.
 *
 * @param  int|float|Ord $left
 * @param  int|float|Ord $right
 * @return ($right is null ? callable : bool)
 */
function gte($left, $right = null) {
    return autocurry(
        function ($left, $right): bool {
            return $left instanceof Ord && $right instanceof Ord
                ? $left->lte($right)
                : $right >= $left;
        },
        2
    )(...func_get_args());
}

const gte = '\Garp\Functional\gte';
