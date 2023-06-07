<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Replace a regex.
 *
 * @param  string $regex
 * @param  string $replacement
 * @param  mixed  $subject
 * @return ($subject is null ? callable : mixed) The replaced string, or the subject if unusable
 */
function replace(string $regex, $replacement, $subject = null) {
    return autocurry(
        function ($regex, $replacement, $subject) {
            if (is_array($subject)
                || (is_object($subject) && !method_exists($subject, '__toString'))
            ) {
                return $subject;
            }
            return preg_replace($regex, $replacement, strval($subject));
        },
        3
    )(...func_get_args());
}

const replace = '\Garp\Functional\replace';
