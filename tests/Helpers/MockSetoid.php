<?php
namespace Garp\Functional\Tests\Helpers;

use Garp\Functional\Types\Setoid;

/**
 * Mock object implementing Setoid.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MockSetoid implements Setoid {
    public $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function equals(Setoid $that): bool {
        return $this->value === $that->value;
    }

}
