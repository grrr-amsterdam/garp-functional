<?php
declare(strict_types=1);

namespace Garp\Functional\Types;

use Garp\Functional\Types\TypeClasses\Functor;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 * @see      https://github.com/fantasyland/fantasy-land#functor
 */
final class Identity implements Functor {

    public $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function map(callable $fn): Functor {
        return new self($fn($this->value));
    }

}
