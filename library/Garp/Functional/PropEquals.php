<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Functional equality check.
 *
 * @param  string $prop
 * @param  mixed $value
 * @param  mixed $obj
 * @return bool
 */
function prop_equals($prop, $value = null, $obj = null) {
    return autocurry(
        function ($prop, $value, $obj) {
            return equals(prop($prop, $obj), $value);
        },
        3
    )(...func_get_args());
}
