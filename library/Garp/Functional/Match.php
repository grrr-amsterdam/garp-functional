<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Match a regex.
 *
 * @param mixed $regex
 * @param mixed $subject
 * @return bool
 */
function match($regex, $subject = null) {
    $matcher = function ($subject) use ($regex) {
        if (is_array($subject)
            || (is_object($subject) && !method_exists($subject, '__toString'))
        ) {
            return false;
        }
        return 1 === preg_match($regex, strval($subject));
    };
    return is_null($subject) ? $matcher : $matcher($subject);
}
