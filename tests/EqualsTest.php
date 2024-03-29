<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use Garp\Functional\Types\StringM;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class EqualsTest extends TestCase {

    public function test_should_determine_equality(): void {
        $this->assertTrue(f\equals('123', '123'));
        $this->assertTrue(f\equals(true, true));
        $spices = ['clove', 'nutmeg', 'allspice', 'cumin'];
        $this->assertTrue(f\equals($spices, $spices));

        $traverser = new MockSpiceTraverser();
        $this->assertTrue(f\equals($traverser, $traverser));
        $this->assertFalse(f\equals(new MockSpiceTraverser, new MockSpiceTraverser));
    }

    public function test_should_be_curried(): void {
        $isCumin = f\equals('cumin');
        $this->assertTrue(is_callable($isCumin));
        $spices = ['clove', 'nutmeg', 'allspice', 'cumin'];
        $this->assertEquals(
            ['cumin'],
            f\reindex(f\filter($isCumin, $spices))
        );
    }

    public function test_works_with_setoids(): void {
        $setoidA = new StringM('A');
        $setoidB = new StringM('B');
        $setoidC = new StringM('A');

        $this->assertFalse(f\equals($setoidA, $setoidB));
        $this->assertTrue(f\equals($setoidA, $setoidC));
        $this->assertTrue(f\equals($setoidB, $setoidB));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\equals));
    }
}
