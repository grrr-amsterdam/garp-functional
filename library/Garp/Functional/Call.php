<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried method caller.
 * Can be used by array_filter and the like.
 *
 * Usage:
 * Imagine an array of User objects, all supporting a `getName()` method.
 * Mapping the array of User objects to an array of names could be done as follows:
 *
 * $names = array_map(call('getName', array()), $objects);
 *
 * @param string $method
 * @param array  $args
 * @param object $obj
 * @return mixed
 */
function call($method, array $args = array(), $obj = null) {
    $caller = function ($obj) use ($method, $args) {
        return call_user_func_array(array($obj, $method), $args);
    };
    return is_null($obj) ? $caller : $caller($obj);
}
