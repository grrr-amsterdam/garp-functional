<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class KeysTest extends TestCase {

    public function test_should_get_keys_of_array() {
        $this->assertEquals(
            array(0, 1, 2, 3),
            f\keys(array('Clove', 'Nutmeg', 'Cinnamon', 'Cumin'))
        );
        $this->assertEquals(
            array('first_name', 'last_name', 'instrument'),
            f\keys(
                array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'Trumpet')
            )
        );
    }

    public function test_should_work_with_objects() {
        $this->assertEquals(
            array(0, 1, 2),
            f\keys(new ArrayIterator(array('foo', 'bar', 'baz')))
        );
        $this->assertEquals(
            array('first_name', 'last_name'),
            f\keys(new ArrayIterator(array('first_name' => 'Miles', 'last_name' => 'Davis')))
        );

        $obj = new stdClass();
        $obj->first_name = 'Miles';
        $obj->last_name = 'Davis';
        $this->assertEquals(
            array('first_name', 'last_name'),
            f\keys($obj)
        );
    }

    public function test_should_work_with_strings() {
        $this->assertEquals(
            array(0, 1, 2),
            f\keys('foo')
        );
    }

    public function test_should_throw_on_invalid_argument() {
        $this->expectException(InvalidArgumentException::class);
        f\keys(123);
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\keys));
    }
}
