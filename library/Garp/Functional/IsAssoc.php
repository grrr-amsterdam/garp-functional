<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Checks wether an array is associative, rather than sequential.
 * Based on https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential
 *
 * @param  iterable $iterable
 * @return bool
 */
function is_assoc($iterable): bool {
    // TODO should use is_iterable when switching to PHP 7.1
    $isIterable = is_array($iterable) || (is_object($iterable) && $iterable instanceof \Traversable);
    return $isIterable
        && !empty($iterable)
        && keys($iterable) !== range(0, count($iterable) - 1);
}
