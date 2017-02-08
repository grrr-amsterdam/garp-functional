<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Grab the rest of a list
 *
 * @param mixed $collection The collection to search in
 * @return mixed
 */
function tail($collection) {
    if (is_string($collection)) {
        return substr($collection, 1);
    }
    if (is_array($collection)) {
        return array_slice($collection, 1);
    }
    if ($collection instanceof \Traversable) {
        $out = array();
        // It really hurts having to loop here. I hate PHP.
        foreach ($collection as $i => $item) {
            if (!$i) {
                continue;
            }
            $out[] = $item;
        }
        return $out;
    }
    throw new \InvalidArgumentException(
        'tail expects argument 1 to be a collection'
    );
}
