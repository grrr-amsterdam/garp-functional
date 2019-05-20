<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\{Max, Min};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class FoldTest extends TestCase {

    public function test_should_fold_into_monoid() {
        $this->assertEquals(
            new Max(100),
            f\fold(Max::class, [10, 2, 100, 30, 58])
        );

        $this->assertEquals(
            new Min(20),
            f\fold(Min::class, [200, 314, 33, 20, 50, 9302])
        );
    }

    public function test_should_return_identity_value_for_empty_list() {
        $this->assertEquals(
            Max::empty(),
            f\fold(Max::class, [])
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_should_throw_on_non_monoid() {
        f\fold(TestCase::class, ['foo', 'bar', 'baz']);
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\fold));
    }

    public function test_should_be_curried() {
        $max = f\fold(Max::class);
        $this->assertTrue(is_callable($max));
        $this->assertEquals(new Max(10), $max([10, 2, 7, 1]));
    }

}
