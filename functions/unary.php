<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Changes the number of arguments accepted by the given function to 1.
 *
 * @param  callable $fn
 * @return callable
 */
function unary(callable $fn): callable {
    return function ($arg) use ($fn) {
        return call_user_func($fn, $arg);
    };
}

const unary = '\Garp\Functional\unary';