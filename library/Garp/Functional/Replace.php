<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Replace a regex.
 *
 * @param mixed $regex
 * @param string $replacement
 * @param mixed $subject
 * @return mixed The replaced string, or the subject if unusable
 */
function replace($regex, $replacement, $subject = null) {
    $replacer = function ($subject) use ($regex, $replacement) {
        if (is_array($subject)
            || (is_object($subject) && !method_exists($subject, '__toString'))
        ) {
            return $subject;
        }
        return preg_replace($regex, $replacement, strval($subject));
    };
    return func_num_args() < 3 ? $replacer : $replacer($subject);
}
