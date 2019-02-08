<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Types\Setoid;
use Garp\Functional\Types\Traits\TestsSetoidLaws;

/**
 * This TestCase actually tests whether the test trait tests a reliable situation correctly.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TestsSetoidLawsTest extends TestCase {

    use TestsSetoidLaws;

    public function test_setoid_laws() {
        $setoidA = $this->_createSetoid('A');
        $setoidB = $this->_createSetoid('B');
        $setoidC = $this->_createSetoid('C');
        $this->assertObeysSetoidLaws($setoidA, $setoidB, $setoidC);
    }

    private function _createSetoid(string $value): Setoid {
        return new class($value) implements Setoid {
            public $value;

            public function __construct($value) {
                $this->value = $value;
            }

            public function equals(Setoid $that): bool {
                return $that->value === $this->value;
            }
        };
    }

}
