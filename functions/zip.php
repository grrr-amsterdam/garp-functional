<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns an array containing elements from the given arrays.
 *
 * @param  array ...$arrays At least two arrays are required, but more is allowed
 * @return mixed
 */
function zip(...$arrays) {
    if (!every('is_iterable', $arrays)) {
        throw new \InvalidArgumentException(__FUNCTION__ . ' requires all arguments to be arrays');
    }
    $keys = array_unique(flatten(map('Garp\Functional\keys', $arrays)));
    return reduce(
        function ($zipped, $cur) use ($keys) {
            foreach ($keys as $key) {
                $zipped[$key][] = prop($key, $cur);
            }
            return $zipped;
        },
        [],
        $arrays
    );
}

const zip = '\Garp\Functional\zip';