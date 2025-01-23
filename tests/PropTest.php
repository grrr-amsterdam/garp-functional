<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PropTest extends TestCase {

    public function test_should_read_from_indexed(): void {
        $spices = array('nutmeg', 'cinnamon', 'clove');
        $this->assertEquals('nutmeg', f\prop(0, $spices));
    }

    public function test_should_read_from_assoc(): void {
        $colors = array(
            'red' => '#FF0000',
            'green' => '#00FF00',
            'blue' => '#0000FF'
        );
        $this->assertEquals('#00FF00', f\prop('green', $colors));
        $this->assertNull(f\prop('yellow', $colors));
    }

    public function test_should_read_from_string(): void {
        $this->assertEquals('n', f\prop(2, 'cinnamon'));
        $this->assertNull(f\prop(20, 'nutmeg'));
    }

    public function test_should_read_from_object(): void {
        $obj = new stdClass();
        $obj->answer = 42;

        $this->assertEquals(42, f\prop('answer', $obj));
        $this->assertNull(f\prop('question', $obj));
    }

    public function test_should_read_from_traversable(): void {
        $spiceIterator = new MockSpiceTraverser();
        $this->assertEquals(
            'nutmeg',
            f\prop(0, $spiceIterator)
        );
    }

    public function test_should_be_curried(): void {
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

    public static function magicDataProvider(): array {
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
            public function offsetExists($offset): bool
            {
                return isset($this->_data[$offset]);
            }
            #[\ReturnTypeWillChange]
            public function offsetGet($offset) {
                throw new Exception('Don\'t call get when offset is not set');
            }
            public function offsetSet($offset, $value): void {
            }
            public function offsetUnset($offset): void {
            }
        };

        return array(
            array(null, 'foo', $obj),
            array('12345', 'bar', $obj),
            array(null, 'bla', $arrayAccessObj)
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\prop));
    }
}
