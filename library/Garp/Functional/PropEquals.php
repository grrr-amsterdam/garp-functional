<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Functional equality check.
 *
 * @param string $prop
 * @param mixed $value
 * @param mixed $obj
 * @return bool
 */
function prop_equals($prop, $value, $obj = null) {
    $checker = function ($obj) use ($prop, $value) {
        return prop($prop, $obj) === $value;
    };
    return func_num_args() < 3 ? $checker : $checker($obj);
}
