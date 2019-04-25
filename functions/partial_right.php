<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Partially apply a function where initial arguments form the 'right' arguments of the function,
 * and the new function will accept the rest arguments on the left side of the signature.
 *
 * Example:
 * function sayHello($to, $from, $message) {
 *   return "Hello {$to}, {$from} says '{$message}'";
 * }
 *
 * $askDirections = partial_right('sayHello', "Where's the supermarket?");
 * $askDirections('John', 'Hank'); // Hello John, Hank says 'Where's the supermarket?'
 *
 * We can it further by saying:
 * $lindaAsksDirections = partial_right('sayHello', 'Linda', "Where's the supermarket?");
 * $lindaAsksDirections('John'); // Hello John, Linda says 'Where's the supermarket?'
 *
 * @param  callable $fn      The partially applied function
 * @param  mixed[]  ...$args Initial arguments
 * @return callable
 */
function partial_right(callable $fn, ...$args): callable {
    return function (...$remainingArgs) use ($fn, $args) {
        return $fn(...array_merge($remainingArgs, $args));
    };
}

const partial_right = '\Garp\Functional\partial_right';