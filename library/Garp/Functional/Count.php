<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Counts arrays and strings.
 *
 * @param mixed $subject
 * @return int
 */
function count($subject) {
    if (is_object($subject) && !method_exists($subject, '__toString')) {
        throw new \InvalidArgumentException('count requires argument to be string or array');
    }
    return is_array($subject) ?
        \count($subject) :
        mb_strlen(strval($subject));
}
