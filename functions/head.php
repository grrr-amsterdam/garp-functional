<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Grab the first item of a list
 *
 * @param  iterable|string $collection The collection to search in
 * @return mixed
 */
function head($collection) {
    return prop(0, $collection);
}

const head = '\Garp\Functional\head';