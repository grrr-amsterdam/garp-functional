<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PartialTest extends TestCase {

    public function test_should_produce_partially_applied_function() {
        $this->assertTrue(
            is_callable(f\partial('explode', '_'))
        );

        $sayHello = function ($to, $from, $message) {
            return "Hello {$to}, {$from} says '{$message}'";
        };
        $sayHelloToJohn = f\partial($sayHello, 'John');
        $expected = 'Hello John, Hank says \'How\'s it going?\'';
        $this->assertEquals($expected, $sayHelloToJohn('Hank', 'How\'s it going?'));

        $hankGreetsJohn = f\partial($sayHello, 'John', 'Hank');
        $expected = 'Hello John, Hank says \'How\'s it going?\'';
        $this->assertEquals($expected, $hankGreetsJohn('How\'s it going?'));

        $hankGreetsJohnComplete = f\partial($sayHello, 'John', 'Hank', 'Hi there!');
        $expected = 'Hello John, Hank says \'Hi there!\'';
        $this->assertEquals($expected, $hankGreetsJohnComplete());

        $helloCopy = f\partial($sayHello);
        $expected = 'Hello John, Hank says \'Hi there!\'';
        $this->assertEquals($expected, $helloCopy('John', 'Hank', 'Hi there!'));
    }

    public function test_should_be_able_to_curry_native_functions() {
        $musicians = array('Miles Davis', 'John Coltrane', 'Herbie Hancock');
        $fixture = array(
            array('Miles', 'Davis'), array('John', 'Coltrane'), array('Herbie', 'Hancock')
        );
        $splitOnSpace = f\partial('explode', ' ');
        $this->assertEquals(
            $fixture,
            f\map($splitOnSpace, $musicians)
        );
    }

}
