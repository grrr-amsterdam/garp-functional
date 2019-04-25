<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockMusician;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class CallTest extends TestCase {

    public function test_should_call_methods() {
        $miles = new MockMusician('Miles', 'Davis');
        $this->assertEquals(
            'Miles Davis',
            f\call('getName', array(), $miles)
        );

        $john = new MockMusician('John', 'Coltrane');
        $this->assertEquals(
            'John Coltrane',
            f\call('getName', array(), $john)
        );
    }

    public function test_should_pass_arguments() {
        $miles = new MockMusician('Miles', 'Davis');
        f\call('setName', array('John', 'Coltrane'), $miles);
        $this->assertEquals(
            'John Coltrane',
            $miles->getName()
        );
    }

    public function test_should_be_curried() {
        $getName = f\call('getName');
        $musicians = array(
            new MockMusician('Miles', 'Davis'),
            new MockMusician('John', 'Coltrane'),
            new MockMusician('Herbie', 'Hancock')
        );
        $this->assertEquals(
            array('Miles Davis', 'John Coltrane', 'Herbie Hancock'),
            array_map($getName, $musicians)
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\call));
    }
}
