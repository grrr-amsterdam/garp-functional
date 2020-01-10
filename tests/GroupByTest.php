<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class GroupByTest extends TestCase {

    public function test_should_group_by_index() {
        $musicians = array(
            array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
            array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
            array('name' => 'Thelonious Monk', 'instrument' => 'piano')
        );
        $fixture = array(
            'trumpet' => array(
                array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
                array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            ),
            'saxophone' => array(
                array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            ),
            'piano' => array(
                array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
                array('name' => 'Thelonious Monk', 'instrument' => 'piano')
            )
        );
        $this->assertEquals(
            $fixture,
            f\group_by('instrument', $musicians)
        );
    }

    public function test_should_group_using_function() {
        $strings = array('a', 'as', 'asd', 'aa', 'asdf', 'qwer');
        $fixture = array(
            1 => array('a'),
            2 => array('as', 'aa'),
            3 => array('asd'),
            4 => array('asdf', 'qwer')
        );
        $this->assertEquals(
            $fixture,
            f\group_by('strlen', $strings)
        );
    }

    public function test_should_be_curried() {
        $groupByInstrument = f\group_by('instrument');
        $this->assertTrue(is_callable($groupByInstrument));
        $musicians = array(
            array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
            array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
            array('name' => 'Thelonious Monk', 'instrument' => 'piano')
        );
        $fixture = array(
            'trumpet' => array(
                array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
                array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            ),
            'saxophone' => array(
                array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            ),
            'piano' => array(
                array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
                array('name' => 'Thelonious Monk', 'instrument' => 'piano')
            )
        );
        $this->assertEquals($fixture, $groupByInstrument($musicians));
    }

    public function test_should_throw_when_index_is_unusable() {
        $this->expectException(InvalidArgumentException::class);
        $users = array(
            array('name' => 'Alice', 'is_admin' => false),
            array('name' => 'Bob', 'is_admin' => true)
        );
        f\group_by(
            'is_admin', $users
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\group_by));
    }
}
