<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ReduceAssocTest extends TestCase {

    public function test_should_reduce_array() {
        $assoc = array(
            'foo' => [1, 2, 3],
            'bar' => [4],
            'baz' => []
        );
        $reduced = f\reduce_assoc(
            function ($acc, $cur, $key) {
                return f\prop_set(
                    $key, count($cur), $acc
                );
            },
            array(),
            $assoc
        );
        $fixture = array(
            'foo' => 3,
            'bar' => 1,
            'baz' => 0
        );
        $this->assertEquals(
            $fixture,
            $reduced,
            'It has access to the array\'s keys in the callback function'
        );

        $names = array('Pete', 'Jane', 'Bob', 'Mary', 'Hank');
        $reduced = f\reduce_assoc(
            function ($acc, $cur, $key) {
                return $acc + $key;
            },
            0,
            $names
        );
        $fixture = 10;
        $this->assertEquals(
            $fixture,
            $reduced,
            'But of course it also works with numerically indexed arrays.'
        );
    }

    public function test_should_reduce_iterable_object() {
        $mockSpiceTraver = new MockSpiceTraverser();
        $reduced = f\reduce_assoc(
            function ($acc, $cur, $key) {
                return $acc . $key;
            },
            '',
            $mockSpiceTraver
        );
        $this->assertEquals(
            '012',
            $reduced
        );
    }

    public function test_should_be_curried() {
        $reducer = f\reduce_assoc(f\concat(), '');
        $this->assertTrue(is_callable($reducer));
        $this->assertEquals(
            'foo0bar1',
            $reducer(array('foo', 'bar'))
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\reduce_assoc));
    }
}
