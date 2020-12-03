<?php 
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */ 
namespace Garp\Functional;

/**
 * Match a regex.
 *
 * @param  string $regex
 * @param  mixed  $subject
 * @return bool|array|callable FALSE if no match is made, but an array of matches otherwise
 */
function match_regex(string $regex, $subject = null) {
    return autocurry(
        function ($regex, $subject) {
            if (is_array($subject)
                || (is_object($subject) && !method_exists($subject, '__toString'))
            ) {
                return false;
            }
            $success = preg_match($regex, strval($subject), $matches);
            return $success ? $matches : false;
        },
        2
    )(...func_get_args());
}

const match_regex = '\Garp\Functional\match_regex';
