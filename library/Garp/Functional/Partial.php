<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Partially apply a function where initial arguments form the 'left' arguments of the function, and
 * the new function will accept the rest arguments on the right side of the signature.
 *
 * Example:
 * function sayHello($to, $from, $message) {
 *   return "Hello {$to}, {$from} says '{$message}'";
 * }
 *
 * $sayHelloToJohn = partial('sayHello', 'John');
 * $sayHelloToJohn('Hank', "How's it going?"); // Hello John, Hank says 'How's it going?'
 *
 * @param  callable $fn      The partially applied function
 * @param  mixed[]  ...$args Initial arguments
 * @return callable
 */
function partial(callable $fn, ...$args): callable {
    return function (...$remainingArgs) use ($fn, $args) {
        return $fn(...array_merge($args, $remainingArgs));
    };
}
