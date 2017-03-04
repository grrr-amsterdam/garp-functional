<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Take $n items of a collection.
 *
 * @param int $n
 * @param array|string $collection
 * @return array|string
 */
function take($n, $collection = null) {
    if (!is_numeric($n)) {
        throw new \InvalidArgumentException('take expects the first argument to be numeric');
    }
    $taker = function ($collection) use ($n) {
        if (is_array($collection)) {
            return array_slice($collection, 0, $n);
        }
        if (is_string($collection)) {
            return substr($collection, 0, $n);
        }
        if ($collection instanceof \Traversable) {
            $out = array();
            $count = 0;
            foreach ($collection as $key => $value) {
                $out[] = $value;
                $count++;
                if ($count >= $n) {
                    break;
                }
            }
            return $out;
        }
        throw new \InvalidArgumentException('take expects argument 2 to be a collection');
    };
    return func_num_args() < 2 ? $taker : $taker($collection);
}
