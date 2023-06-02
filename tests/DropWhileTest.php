<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class DropWhileTest extends TestCase {

    public function test_should_drop_from_array(): void {
        $diary = array(
            array('month' => 1, 'day' => 1, 'entry' => 'Lorem ipsum'),
            array('month' => 1, 'day' => 14, 'entry' => 'Lorem ipsum'),
            array('month' => 2, 'day' => 27, 'entry' => 'Lorem ipsum'),
            array('month' => 3, 'day' => 1, 'entry' => 'Lorem ipsum'),
            array('month' => 3, 'day' => 5, 'entry' => 'Lorem ipsum'),
            array('month' => 4, 'day' => 2, 'entry' => 'Lorem ipsum')
        );
        $janFebEntries = f\drop_while(f\compose(f\lte(2), f\prop('month')), $diary);
        $this->assertEquals(
            array(
                array('month' => 3, 'day' => 1, 'entry' => 'Lorem ipsum'),
                array('month' => 3, 'day' => 5, 'entry' => 'Lorem ipsum'),
                array('month' => 4, 'day' => 2, 'entry' => 'Lorem ipsum')
            ),
            $janFebEntries
        );

        $notLoremIpsum = f\drop_while(f\not(f\prop_equals('entry', 'Lorem ipsum')), $diary);
        $this->assertEquals(
            array(
                array('month' => 1, 'day' => 1, 'entry' => 'Lorem ipsum'),
                array('month' => 1, 'day' => 14, 'entry' => 'Lorem ipsum'),
                array('month' => 2, 'day' => 27, 'entry' => 'Lorem ipsum'),
                array('month' => 3, 'day' => 1, 'entry' => 'Lorem ipsum'),
                array('month' => 3, 'day' => 5, 'entry' => 'Lorem ipsum'),
                array('month' => 4, 'day' => 2, 'entry' => 'Lorem ipsum')
            ),
            $notLoremIpsum
        );

        $numbers = array(-1, -30, 5, 932, -2, 13);
        $this->assertEquals(
            array(5, 932, -2, 13),
            f\drop_while(f\lt(0), $numbers)
        );
    }

    public function test_should_drop_from_iterable_object(): void {
        $spiceTraverser = new MockSpiceTraverser();
        $this->assertEquals(
            array(),
            f\drop_while('is_string', $spiceTraverser)
        );

        $spices = new ArrayIterator(array('Clove', 'Cumin', 'Nutmeg', 'Saffron', 'Cinnamon'));
        $startsWithC = f\prop_equals(0, 'C');
        $this->assertEquals(
            array('Nutmeg', 'Saffron', 'Cinnamon'),
            f\drop_while($startsWithC, $spices)
        );
    }

    public function test_should_drop_from_string(): void {
        $isVowel = f\partial_right('in_array', array('a', 'e', 'o', 'i', 'u', 'y'));
        $gibberish = 'aeuibejkwe';
        $this->assertEquals(
            array('b', 'e', 'j', 'k', 'w', 'e'),
            f\drop_while($isVowel, $gibberish)
        );
    }

    public function test_should_be_curried(): void {
        $dropFirstBigNumbers = f\drop_while(f\gt(100));
        $this->assertTrue(is_callable($dropFirstBigNumbers));
        $this->assertEquals(
            array(20, 400, 194),
            $dropFirstBigNumbers(array(500, 20, 400, 194))
        );
        $this->assertEquals(
            array(20, 400, 194),
            $dropFirstBigNumbers(array(20, 400, 194))
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\drop_while));
    }
}
