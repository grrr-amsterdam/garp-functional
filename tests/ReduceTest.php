<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
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
            f\concat(),
            '',
            $mockSpiceTraver
        );
        $this->assertEquals(
            'nutmegcinnamonclove',
            $reduced
        );
    }

    public function test_should_be_curried() {
        $reducer = f\reduce(f\concat(), '');
        $this->assertTrue(is_callable($reducer));
        $this->assertEquals(
            'foobar',
            $reducer(array('foo', 'bar'))
        );
    }

    public function test_iteration_should_halt_early_when_given_signal() {
        // Re-implement find
        $find = function ($predicate, $collection) {
            return f\reduce(
                function ($_, $item) use ($predicate) {
                    if ($predicate($item)) {
                        return f\reduced($item);
                    }
                },
                null,
                $collection
            );
        };
        $numbers = [42, 100, 90, 1, -5, 50];
        $this->assertEquals(
            1,
            $find(f\lt(20), $numbers)
        );

        // Create a logging predicate to prove the other items remain untouched
        $objects = [['name' => 'Miles'], ['name' => 'John'], ['name' => 'Herbie']];
        $log = [];
        $logPredicate = function (&$log, $predicate) {
            $log = [];
            return function ($item) use ($predicate, &$log) {
                $log[] = $item;
                return $predicate($item);
            };
        };
        $miles = $find($logPredicate($log, f\prop_equals('name', 'Miles')), $objects);
        $this->assertEquals(['name' => 'Miles'], $miles);
        $this->assertEquals(
            [['name' => 'Miles']],
            $log
        );

        $john = $find($logPredicate($log, f\prop_equals('name', 'John')), $objects);
        $this->assertEquals(['name' => 'John'], $john);
        $this->assertEquals(
            [['name' => 'Miles'], ['name' => 'John']],
            $log
        );
    }

}
