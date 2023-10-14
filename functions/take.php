<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Take $n items of a collection.
 *
 * @param  int $n
 * @param  array|string $collection
 * @return ($collection is null ? callable : array|string)
 */
function take(int $n, $collection = null) {
    $reduce = reduce(
        function ($acc, $item) use ($n) {
            return count($acc) === $n
                ? reduced($acc)
                : concat($acc, [$item]);
        },
        []
    );
    return autocurry(
        function ($n, $collection) use ($reduce) {
            if (is_string($collection)) {
                $collection = str_split($collection);
                $reduce = compose(join(''), $reduce);
            }
            if (!is_iterable($collection)) {
                throw new \InvalidArgumentException('take expects argument 2 to be a collection');
            }
            return $reduce($collection);
        },
        2
    )(...func_get_args());
}

const take = '\Garp\Functional\take';
