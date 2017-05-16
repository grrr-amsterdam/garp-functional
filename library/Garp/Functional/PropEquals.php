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
function prop_equals($prop, $value = null, $obj = null) {
    if (func_num_args() === 1) {
        return partial('Garp\Functional\prop_equals', $prop);
    }
    $checker = function ($value, $obj = null) use ($prop) {
        $checker2 = function ($obj) use ($prop, $value) {
            return prop($prop, $obj) === $value;
        };
        return func_num_args() < 2 ? $checker2 : $checker2($obj);
    };
    return func_num_args() < 3 ? $checker($value) : $checker($value, $obj);
}
