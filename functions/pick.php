<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a new array containing only the keys from the original that you want.
 *
 * @param  array $allowed
 * @param  array $collection
 * @return array
 */
function pick(array $allowed, $collection = null) {
    return autocurry(
        function ($allowed, $collection): array {
            $keys = filter(
                partial_right('in_array', $allowed, true),
                keys($collection)
            );
            return array_combine(
                $keys,
                map(partial_right('Garp\Functional\Prop', $collection), $keys)
            );
        },
        2
    )(...func_get_args());
}

const pick = '\Garp\Functional\pick';