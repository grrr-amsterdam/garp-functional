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
 * @param  iterable<mixed,mixed> $iterable
 * @return bool
 */
function is_assoc(iterable $iterable): bool {
    return !empty($iterable)
        && keys($iterable) !== range(0, count($iterable) - 1);
}

const is_assoc = '\Garp\Functional\is_assoc';
