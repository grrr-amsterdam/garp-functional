<?php
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
 * $askDirections = call_right('sayHello', "Where's the supermarket?");
 * $askDirections('John', 'Hank'); // Hello John, Hank says 'Where's the supermarket?'
 *
 * We can it further by saying:
 * $lindaAsksDirections = call_right('sayHello', 'Linda', "Where's the supermarket?");
 * $lindaAsksDirections('John'); // Hello John, Linda says 'Where's the supermarket?'
 *
 * Note: the function signature doesn't show the rest parameters. This is confusing, but
 * unfortunately we have to support PHP5.3. In PHP5.6 the signature would have been
 *
 * ```
 * function call_right($fn, ...$args)
 * ```
 *
 * @param callable $fn The partially applied function
 * @return callable
 */
function call_right($fn) {
    $args = array_slice(func_get_args(), 1);
    return function () use ($fn, $args) {
        $remainingArgs = func_get_args();
        return call_user_func_array($fn, array_merge($remainingArgs, $args));
    };
}
