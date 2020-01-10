<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class IndexByTest extends TestCase {

    public function test_should_index_by_index() {
        $musicians = array(
            array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
            array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
            array('name' => 'Thelonious Monk', 'instrument' => 'piano')
        );
        $fixture = array(
            'trumpet' => array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            'saxophone' => array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            'piano' => array('name' => 'Thelonious Monk', 'instrument' => 'piano')
        );
        $this->assertEquals(
            $fixture,
            f\index_by('instrument', $musicians)
        );
    }

    public function test_should_index_using_function() {
        $strings = array('a', 'as', 'asd', 'aa', 'asdf', 'qwer');
        $fixture = array(
            1 => 'a',
            2 => 'aa',
            3 => 'asd',
            4 => 'qwer'
        );
        $this->assertEquals(
            $fixture,
            f\index_by('strlen', $strings)
        );
    }

    public function test_should_be_curried() {
        $indexByInstrument = f\index_by('instrument');
        $this->assertTrue(is_callable($indexByInstrument));
        $musicians = array(
            array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
            array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
            array('name' => 'Thelonious Monk', 'instrument' => 'piano')
        );
        $fixture = array(
            'trumpet' => array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
            'saxophone' => array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
            'piano' => array('name' => 'Thelonious Monk', 'instrument' => 'piano')
        );
        $this->assertEquals($fixture, $indexByInstrument($musicians));
    }

    public function test_should_throw_when_index_is_unusable() {
        $this->expectException(InvalidArgumentException::class);
        $users = array(
            array('name' => 'Alice', 'is_admin' => false),
            array('name' => 'Bob', 'is_admin' => true)
        );
        f\index_by(
            'is_admin', $users
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\index_by));
    }
}
