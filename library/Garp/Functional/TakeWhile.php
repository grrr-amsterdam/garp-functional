<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Take items from a collection while the predicate function returns true.
 * Stop retrieval at the first falsey value.
 *
 * @param callable $predicate
 * @param array $collection
 * @return array
 */
function take_while($predicate, $collection = null) {
    if (!is_callable($predicate)) {
        throw new \InvalidArgumentException('take_while expects the first argument to be callable');
    }
    $taker = function ($collection) use ($predicate) {
        $collection = is_string($collection) ? str_split($collection) : $collection;
        if (!is_array($collection) && !$collection instanceof \Traversable) {
            throw new \InvalidArgumentException('take_while expects argument 2 to be a collection');
        }
        $out = array();
        foreach ($collection as $key => $value) {
            if (!$predicate($value)) {
                break;
            }
            $out[] = $value;
        }
        return $out;
    };
    return func_num_args() < 2 ? $taker : $taker($collection);
}
