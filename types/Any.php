<?php
declare(strict_types=1);

namespace Garp\Functional\Types;

use Garp\Functional\Types\TypeClasses\{Semigroup, Setoid, Monoid};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 * @see      https://github.com/fantasyland/fantasy-land#semigroup
 */
final class Any implements Semigroup, Setoid, Monoid {

    /**
     * @var bool
     */
    public $value;

    public static function empty(): Monoid {
        return new static(false);
    }

    public function __construct(bool $value) {
        $this->value = $value;
    }

    public function equals(Setoid $that): bool {
        return $that->value === $this->value;
    }

    public function concat(Semigroup $that): Semigroup {
        if (!$that instanceof self) {
            throw new \LogicException('Semigroup cannot concatenate two distinct types.');
        }
        return new self($this->value || $that->value);
    }

}
