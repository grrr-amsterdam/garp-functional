<?php
declare(strict_types=1);

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
 * @template T of iterable<mixed,mixed>|string
 * @param  callable $predicate
 * @param  T $collection
 * @return ($collection is null ? callable : T)
 */
function take_while(callable $predicate, $collection = null) {
    return autocurry(
        function (callable $predicate, $collection): array {
            $collection = is_string($collection) ? str_split($collection) : $collection;
            if (!is_iterable($collection)) {
                throw new \InvalidArgumentException('take_while expects argument 2 to be a collection');
            }
            return reduce(
                function ($collection, $item) use ($predicate) {
                    return $predicate($item)
                        ? concat($collection, [$item])
                        : reduced($collection);
                },
                [],
                $collection
            );
        },
        2
    )(...func_get_args());
}

const take_while = '\Garp\Functional\take_while';
