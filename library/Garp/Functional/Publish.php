<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Method decorator for publishing private methods.
 * Basically a simple wrapper around \Closure::bindTo
 *
 * @param  string $method
 * @param  object $context Used for both "newscope" and "newthis"
 * @return Closure
 * @see http://php.net/manual/en/closure.bindto.php
 */
function publish($method, $context) {
    $caller = function () use ($method) {
        return call_user_func_array([$this, $method], func_get_args());
    };
    return $caller->bindTo($context, $context);
}
