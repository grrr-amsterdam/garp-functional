<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns a function which executes but once.
 *
 * @param callable $fn
 * @return callable
 */
function once($fn) {
    return function () use ($fn) {
        static $done = false;
        static $result = null;
        if (!$done) {
            $done = true;
            $result = call_user_func_array($fn, func_get_args());
            return $result;
        }
        return $result;
    };
}
