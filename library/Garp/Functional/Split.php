<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Split a string.
 *
 * @param string $separator
 * @param string $subject
 * @return array
 */
function split($separator, $subject = null) {
    $splitter = function ($subject) use ($separator) {
        return explode($separator, $subject);
    };
    return is_null($subject) ? $splitter : $splitter($subject);
}
