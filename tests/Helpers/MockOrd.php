<?php
namespace Garp\Functional\Tests\Helpers;

use Garp\Functional\Types\TypeClasses\Setoid;
use Garp\Functional\Types\TypeClasses\Ord;

/**
 * Mock object implementing Ord.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MockOrd implements Ord {
    public $value;

    const OPTIONS = [
        'huge' => 1000,
        'big' => 100,
        'small' => 10,
        'tiny' => 1
    ];

    public function __construct(string $value) {
        if (!array_key_exists($value, self::OPTIONS)) {
            throw new \InvalidArgumentException('Unknown value');
        }
        $this->value = $value;
    }

    public function equals(Setoid $that): bool {
        return self::OPTIONS[$this->value] === self::OPTIONS[$that->value];
    }

    public function lte(Ord $that): bool {
        return self::OPTIONS[$this->value] <= self::OPTIONS[$that->value];
    }
}
