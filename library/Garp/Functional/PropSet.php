<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a copy of an object, setting or overriding the given property with the given value.
 * Thrice curried.
 *
 * @param string $key
 * @param mixed  $value
 * @param mixed  $object
 * @return mixed
 */
function prop_set($key, $value = null, $object = null) {
    if (func_num_args() === 1) {
        return partial('Garp\Functional\prop_set', $key);
    }
    $setter = function ($value, $object = null) use ($key) {
        /**
         * TODO this is a bit ugly. There has to be a better way. Even in PHP5.3.
         */
        $realSetter = function ($object) use ($key, $value) {
            $copy = $object;
            $copy[$key] = $value;
            return $copy;
        };
        return is_null($object) ? $realSetter : $realSetter($object);
    };
    return is_null($object) ? $setter($value) : $setter($value, $object);
}
