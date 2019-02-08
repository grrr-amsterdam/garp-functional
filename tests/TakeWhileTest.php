<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TakeWhileTest extends TestCase {

    public function test_should_take_from_array() {
        $diary = array(
            array('month' => 1, 'day' => 1, 'entry' => 'Lorem ipsum'),
            array('month' => 1, 'day' => 14, 'entry' => 'Lorem ipsum'),
            array('month' => 2, 'day' => 27, 'entry' => 'Lorem ipsum'),
            array('month' => 3, 'day' => 1, 'entry' => 'Lorem ipsum'),
            array('month' => 3, 'day' => 5, 'entry' => 'Lorem ipsum'),
            array('month' => 4, 'day' => 2, 'entry' => 'Lorem ipsum')
        );
        $janFebEntries = f\take_while(f\compose(f\lte(2), f\prop('month')), $diary);
        $this->assertEquals(
            array(
                array('month' => 1, 'day' => 1, 'entry' => 'Lorem ipsum'),
                array('month' => 1, 'day' => 14, 'entry' => 'Lorem ipsum'),
                array('month' => 2, 'day' => 27, 'entry' => 'Lorem ipsum'),
            ),
            $janFebEntries
        );

        $notLoremIpsum = f\take_while(f\not(f\prop_equals('entry', 'Lorem ipsum')), $diary);
        $this->assertEquals(
            array(),
            $notLoremIpsum
        );
    }

    public function test_should_take_from_iterable_object() {
        $spiceTraverser = new MockSpiceTraverser();
        $this->assertEquals(
            array('nutmeg', 'cinnamon', 'clove'),
            f\take_while('is_string', $spiceTraverser)
        );
    }

    public function test_should_take_from_string() {
        $isVowel = f\partial_right('in_array', array('a', 'e', 'o', 'i', 'u', 'y'));
        $gibberish = 'aeuibejkwe';
        $this->assertEquals(
            array('a', 'e', 'u', 'i'),
            f\take_while($isVowel, $gibberish)
        );
    }

    public function test_should_be_curried() {
        $takeFirstBigNumbers = f\take_while(f\gt(100));
        $this->assertTrue(is_callable($takeFirstBigNumbers));
        $this->assertEquals(
            array(),
            $takeFirstBigNumbers(array(4, 500, 20, 400, 194))
        );
        $this->assertEquals(
            array(500),
            $takeFirstBigNumbers(array(500, 20, 400, 194))
        );
    }

}
