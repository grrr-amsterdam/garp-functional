<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ConcatWithTest extends TestCase {

    public function test_should_be_curried() {
        $concatWithAdd = f\concat_with('Garp\Functional\add');
        $this->assertTrue(is_callable($concatWithAdd));

        $foo = ['total' => 100, 'amount' => 4];
        $concatFooWithAdd = f\concat_with('Garp\Functional\add', $foo);
        $this->assertTrue(is_callable($concatFooWithAdd));
    }

    public function test_should_throw_on_non_array_arguments() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('concat_with expects arguments 2 and up to be arrays.');
        f\concat_with('array_merge', 999, 'foo');
    }

    public function test_should_merge_with_add_function() {
        $a = ['total' => 100, 'amount' => 4];
        $b = ['total' => 50, 'amount' => 5];
        $this->assertEquals(
            [
                'total' => 150,
                'amount' => 9
            ],
            f\concat_with('Garp\Functional\add', $a, $b)
        );

        $c = ['name' => 'Foo'];
        $d = ['name' => 'Bar'];
        $this->assertEquals(
            ['name' => 'FooBar'],
            f\concat_with('Garp\Functional\concat', $c, $d)
        );
    }

    public function test_should_be_variadic() {
        $a = ['total' => 100, 'amount' => 4];
        $b = ['total' => 50, 'amount' => 5];
        $c = ['total' => 20, 'amount' => 1];
        $this->assertEquals(
            [
                'total' => 170,
                'amount' => 10
            ],
            f\concat_with('Garp\Functional\add', $a, $b, $c)
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\concat_with));
    }
}
