<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Carbon\Carbon;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PropTest extends TestCase {

    public function test_should_read_from_indexed() {
        $spices = array('nutmeg', 'cinnamon', 'clove');
        $this->assertEquals('nutmeg', f\prop(0, $spices));
    }

    public function test_should_read_from_assoc() {
        $colors = array(
            'red' => '#FF0000',
            'green' => '#00FF00',
            'blue' => '#0000FF'
        );
        $this->assertEquals('#00FF00', f\prop('green', $colors));
        $this->assertNull(f\prop('yellow', $colors));
    }

    public function test_should_read_from_string() {
        $this->assertEquals('n', f\prop(2, 'cinnamon'));
        $this->assertNull(f\prop(20, 'nutmeg'));
    }

    public function test_should_read_from_object() {
        $obj = new stdClass();
        $obj->answer = 42;

        $this->assertEquals(42, f\prop('answer', $obj));
        $this->assertNull(f\prop('question', $obj));
    }

    public function test_should_read_from_traversable() {
        $spiceIterator = new MockSpiceTraverser();
        $this->assertEquals(
            'nutmeg',
            f\prop(0, $spiceIterator)
        );
    }

    public function test_should_be_curried() {
        $this->assertTrue(is_callable(f\prop('foo')));
        $getRed = f\prop('red');
        $colors = array(
            'red' => '#FF0000',
            'green' => '#00FF00',
            'blue' => '#0000FF'
        );
        $this->assertEquals(
            '#FF0000',
            $getRed($colors)
        );
    }

    /**
     * @param  mixed  $result
     * @param  string $prop
     * @param  object $obj
     * @return void
     * @dataProvider magicDataProvider
     */
    public function test_should_read_magic_prop($result, $prop, $obj) {
        $this->assertEquals(
            $result,
            f\prop($prop, $obj)
        );
    }

    public function magicDataProvider() {
        $obj = new class {
            protected $_data = [
                'bar' => '12345'
            ];
            public function __get($prop) {
                return f\prop($prop, $this->_data);
            }
            public function __isset($prop) {
                return isset($this->_data[$prop]);
            }
        };

        $arrayAccessObj = new class implements ArrayAccess {
            protected $_data = [];
            public function offsetExists($offset) {
                return isset($this->_data[$offset]);
            }
            public function offsetGet($offset) {
                throw new Exception('Don\'t call get when offset is not set');
            }
            public function offsetSet($offset, $value) {
            }
            public function offsetUnset($offset) {
            }
        };

        $carbonInstance = Carbon::parse('2012-9-5 23:26:11.123789');
        return array(
            array(null, 'foo', $obj),
            array('12345', 'bar', $obj),
            array(2012, 'year', $carbonInstance),
            array(249, 'dayOfYear', $carbonInstance),
            array(null, 'bla', $arrayAccessObj)
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\prop));
    }
}
