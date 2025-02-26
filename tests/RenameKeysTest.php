<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class RenameKeysTest extends TestCase {

    public function test_should_rename_keys(): void {
        $a = array(
            'foo' => 123,
            'bar' => 456
        );
        $this->assertSame(
            array(
                'baz' => 123,
                'qud' => 456
            ),
            f\rename_keys(array('foo' => 'baz', 'bar' => 'qud'), $a)
        );

        $b = array(1, 2, 3);
        $this->assertSame(
            array(
                'foo' => 1,
                'bar' => 2,
                'baz' => 3
            ),
            f\rename_keys(array(0 => 'foo', 1 => 'bar', 2 => 'baz'), $b)
        );
    }

    public function test_should_ignore_unknown_keys(): void {
        $a = array(
            'foo' => 123,
            'bar' => 456
        );
        $this->assertSame(
            array(
                'baz' => 123,
                'qud' => 456
            ),
            f\rename_keys(array('foo' => 'baz', 'bar' => 'qud', 'xxx' => 'zzz'), $a)
        );
    }

    public function test_should_leave_omitted_keys(): void {
        $a = array(
            'foo' => 123,
            'bar' => 456
        );
        $this->assertSame(
            array(
                'baz' => 123,
                'bar' => 456
            ),
            f\rename_keys(array('foo' => 'baz'), $a)
        );
    }

    public function test_should_accept_function_as_transformer(): void {
        $a = array(1, 2, 3);
        $this->assertSame(
            array(1 => 1, 2 => 2, 3 => 3),
            f\rename_keys(f\add(1), $a)
        );

        $b = array(
            'foo' => 123,
            'bar' => 456
        );
        $this->assertSame(
            array('oof' => 123, 'rab' => 456),
            f\rename_keys('strrev', $b)
        );
    }

    public function test_callable_should_not_be_executed_in_collection(): void {
        $actual = f\rename_keys(
            array(0 => 'new_key'),
            array('Garp\Functional\rename_keys')
        );

        $this->assertEquals(array('new_key' => 'Garp\Functional\rename_keys'), $actual);
    }

    public function test_should_be_curried(): void {
        $renamer = f\rename_keys(array('foo' => 'bar'));
        $this->assertTrue(is_callable($renamer));
        $this->assertSame(
            array('bar' => 123),
            $renamer(array('foo' => 123))
        );
    }

    /**
     * @dataProvider invalidArgumentProvider
     * @param mixed $arg
     * @return void
     */
    public function test_should_throw_on_invalid_arguments($arg): void {
        $this->expectException(InvalidArgumentException::class);
        f\rename_keys($arg, []);
    }

    public static function invalidArgumentProvider(): array {
        return array(
            array(new stdClass),
            array(true),
            array(999)
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\rename_keys));
    }
}
