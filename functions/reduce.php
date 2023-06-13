<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried version of array_reduce.
 * Also works on iterable objects.
 *
 * @param  callable $fn Reduction function
 * @param  mixed    $default
 * @param  iterable<mixed,mixed> $collection
 * @return ($collection is null ? callable : mixed)
 */
function reduce(callable $fn, $default, iterable $collection = null) {
    $reduce = function ($fn, $acc, $collection) {
        foreach ($collection as $item) {
            $acc = $fn($acc, $item);
            if (is_reduced($acc)) {
                return $acc->value;
            }
        }
        return $acc;
    };
    return autocurry(
        $reduce,
        3
    )(...func_get_args());
}

const reduce = '\Garp\Functional\reduce';
