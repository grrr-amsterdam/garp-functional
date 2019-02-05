<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns a function which executes but once.
 *
 * @param  callable $fn
 * @return callable
 */
function once(callable $fn): callable {
    return function (...$args) use ($fn) {
        static $done = false;
        static $result = null;
        if (!$done) {
            $done = true;
            $result = $fn(...$args);
            return $result;
        }
        return $result;
    };
}
