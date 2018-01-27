<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Splice something into an array.
 *
 * @param mixed $object The thing to splice into the array.
 * @param mixed $index  Either the actual index (numeric or associative) or a predicate function.
 *                      In case of a function the first item in $target the function returns true
 *                      for will determine the index.
 * @param array $target The receiver of the spliced-in object.
 * @return array        A new array.
 */
function merge_at($object, $index, array $target = null) {
    $merger = function ($target) use ($object, $index) {
        $targetIsAssoc = every('is_string', array_keys($target));
        $objectIsAssoc = is_array($object) && count($object) === 1 && every('is_string', array_keys($object));
        $wrappedObject = $objectIsAssoc && $targetIsAssoc ? $object : array($object);

        if (is_string($index)) {
            $keys = array_keys($target);
            $targetKey = array_search($index, $keys, true);
            // If no match is found, add object to the end.
            $targetKey = $targetKey === false ? count($target) : $targetKey;

            return concat(
                array_slice($target, 0, $targetKey, true),
                $wrappedObject,
                array_slice($target, $targetKey, null, true)
            );
        }
        if (is_numeric($index)) {
            return concat(
                array_slice($target, 0, $index, true),
                $wrappedObject,
                array_slice($target, $index, null, true)
            );
        }
        if (is_callable($index)) {
            $targetIndex = count($target);
            foreach ($target as $key => $val) {
                if ($index($val, $key)) {
                    $targetIndex = $key;
                    break;
                }
            }
            return merge_at($object, $targetIndex, $target);
        }

        throw new \InvalidArgumentException(
            sprintf(
                'merge_at expects index to be numeric, string or callable. Instead got %s',
                gettype($index)
            )
        );
    };
    return func_num_args() < 3 ? $merger : $merger($target);
}
