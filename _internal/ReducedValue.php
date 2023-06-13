<?php
declare(strict_types=1);

namespace Garp\Functional\Internal;

/**
 * Object for signaling an early return in a reduce context.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 *
 * @template T
 */
final class ReducedValue {

    /**
     * @var T
     */
    public $value;

    /**
     * @param T $value
     */
    public function __construct($value) {
        $this->value = $value;
    }

}


