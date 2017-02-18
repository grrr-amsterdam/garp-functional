<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns an array containing elements from the given arrays.
 *
 * @param array $array1,... At least two arrays are required, but more is allowed
 * @return mixed
 */
function zip() {
    $arrayOrTraversable = either('is_array', partial_right('is_a', 'Traversable'));
    if (!every($arrayOrTraversable, func_get_args())) {
        throw new \InvalidArgumentException(__FUNCTION__ . ' requires all arguments to be arrays');
    }
    $keys = array_unique(flatten(map('Garp\Functional\keys', func_get_args())));
    return reduce(
        function ($zipped, $cur) use ($keys) {
            foreach ($keys as $key) {
                $zipped[$key][] = prop($key, $cur);
            }
            return $zipped;
        },
        [],
        func_get_args()
    );
}
