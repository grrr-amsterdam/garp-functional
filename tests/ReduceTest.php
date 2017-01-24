<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ReduceTest extends TestCase {

    public function test_should_reduce_array() {
        $numbers = array(100, 23, 1, -2, 59);
        $reduced = f\reduce(
            function ($acc, $cur) {
                return $acc + $cur;
            },
            0,
            $numbers
        );
        $fixture = 181;
        $this->assertEquals(
            $fixture,
            $reduced
        );
    }

    public function test_should_reduce_iterable_object() {
        $mockSpiceTraver = new MockSpiceTraverser();
        $reduced = f\reduce(
            f\join(),
            '',
            $mockSpiceTraver
        );
        $this->assertEquals(
            'nutmegcinnamonclove',
            $reduced
        );
    }

    public function test_should_be_curried() {
        $reducer = f\reduce(f\join(), '');
        $this->assertTrue(is_callable($reducer));
        $this->assertEquals(
            'foobar',
            $reducer(array('foo', 'bar'))
        );
    }

}
