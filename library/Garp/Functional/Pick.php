<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a new array containing only the keys from the original that you want.
 *
 * @param array $allowed
 * @param array $collection
 * @return array
 */
function pick(array $allowed, $collection = null) {
    $picker = function ($collection) use ($allowed) {
        return array_combine(
            $allowed,
            map(partial_right('Garp\Functional\Prop', $collection), $allowed)
        );
    };
    return is_null($collection) ? $picker : $picker($collection);
}
