<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

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

}
