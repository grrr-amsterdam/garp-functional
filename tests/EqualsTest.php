<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use Garp\Functional\Types\Setoid;
use Garp\Functional as f;
use PHPUnit\Framework\TestCase;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class EqualsTest extends TestCase {

    public function test_should_determine_equality() {
        $this->assertTrue(f\equals('123', '123'));
        $this->assertTrue(f\equals(true, true));
        $spices = ['clove', 'nutmeg', 'allspice', 'cumin'];
        $this->assertTrue(f\equals($spices, $spices));

        $traverser = new MockSpiceTraverser();
        $this->assertTrue(f\equals($traverser, $traverser));
        $this->assertFalse(f\equals(new MockSpiceTraverser, new MockSpiceTraverser));
    }

    public function test_should_be_curried() {
        $isCumin = f\equals('cumin');
        $this->assertTrue(is_callable($isCumin));
        $spices = ['clove', 'nutmeg', 'allspice', 'cumin'];
        $this->assertEquals(
            ['cumin'],
            f\reindex(f\filter($isCumin, $spices))
        );
    }

    public function test_works_with_setoids() {
        $setoidA = $this->_createSetoid('A');
        $setoidB = $this->_createSetoid('B');
        $setoidC = $this->_createSetoid('A');

        $this->assertFalse(f\equals($setoidA, $setoidB));
        $this->assertTrue(f\equals($setoidA, $setoidC));
        $this->assertTrue(f\equals($setoidB, $setoidB));
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
