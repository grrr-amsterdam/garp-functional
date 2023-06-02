<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockMusician;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ReplaceTest extends TestCase {

    public function test_should_replace_strings(): void {
        $this->assertEquals(
            'goodbye world',
            f\replace('/(hello)/', 'goodbye', 'hello world')
        );
        $this->assertEquals(
            'hello you',
            f\replace('/(world)/', 'you', 'hello world')
        );
    }

    public function test_should_return_unusable_objects(): void {
        $stdClass = new stdClass();
        $this->assertEquals(
            $stdClass,
            f\replace('/^(.*)$/', 'foobar', $stdClass)
        );
        $exception = new InvalidArgumentException('Something terrible happened');
        $this->assertEquals(
            $exception,
            f\replace('/^(.*)$/', 'foobar', $exception)
        );
        $array = array(1, 2, 3);
        $this->assertEquals(
            $array,
            f\replace('/^(.*)$/', 'foobar', $array)
        );
    }

    public function test_should_match_objects_that_support_tostring(): void {
        $musician = new MockMusician('Miles', 'Davis');
        $this->assertEquals(
            'Miles Smiles',
            f\replace('/(Miles) Davis/', '$1 Smiles', $musician)
        );
    }

    public function test_should_be_curried(): void {
        $replaceNum = f\replace('/(\d)/', 'x');
        $this->assertTrue(is_callable($replaceNum));
        $data = array(123, 'abc', array('90'), 456);
        $this->assertEquals(
            array('xxx', 'abc', array('90'), 'xxx'),
            f\reindex(f\map($replaceNum, $data))
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\replace));
    }
}
