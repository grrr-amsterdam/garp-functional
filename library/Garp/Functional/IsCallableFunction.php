<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Used internally to determine wether a given argument is callable but not an object instance with
 * an __invoke method.
 * For this library the latter is usually not what we want.
 *
 * For instance when using Carbon, a variable that might be a Carbon instance or NULL is otherwise
 * not detectable with either() because is_callable() will be true for that instance, and therefore
 * either() will return a closure, instead of the instance (or the fallback).
 *
 * @param  mixed $callable
 * @return bool
 */
function is_callable_function($callable): bool {
    if (!is_callable($callable)) {
        return false;
    }
    return !is_object($callable) || $callable instanceof \Closure;
}

