<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Changes the number of arguments accepted by the given function to 2.
 *
 * @param  callable $fn
 * @return callable
 */
function binary(callable $fn): callable {
    return function ($x, $y) use ($fn) {
        return call_user_func($fn, $x, $y);
    };
}
