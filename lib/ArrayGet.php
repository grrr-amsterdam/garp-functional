<?php
namespace GarpFunctional;

/**
 * Safely get an array index.
 * Curried to easily use with `array_map` and friends.
 *
 * @param string $key
 * @param mixed  $default
 * @param array  $array
 * @return mixed
 */
function arrayGet($key, $default = null, $array = null) {
    $getter = function ($array) use ($key, $default) {
        return isset($array[$key]) ? $array[$key] : $default;
    };
    return is_null($array) ? $getter : $getter($array);
}
