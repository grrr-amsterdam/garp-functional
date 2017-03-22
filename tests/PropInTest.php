<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PropInTest extends TestCase {

    public function test_should_get_nested_props_from_assoc() {
        $miles = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis',
            'albums' => array(
                array('name' => 'Bitches Brew'),
                array('name' => 'Kind of Blue'),
                array('name' => 'Big Fun'),
                array('name' => 'Miles Ahead')
            )
        );
        $this->assertNull(f\prop_in(array(), $miles));
        $this->assertEquals(
            'Big Fun',
            f\prop_in(array('albums', 2, 'name'), $miles)
        );
        $this->assertNull(
            f\prop_in(array('address', 'street'), $miles)
        );
        $this->assertNull(
            f\prop_in(array('albums', 12, 'name'), $miles)
        );
    }

    public function test_should_get_nested_props_from_object() {
        $foo = new stdClass();
        $foo->bar = new stdClass();
        $foo->bar->baz = array('X', 'Y', 'Z');
        $this->assertNull(
            f\prop_in(array('lem'), $foo)
        );
        $this->assertEquals(
            'Y',
            f\prop_in(array('bar', 'baz', 1), $foo)
        );
    }

    public function test_should_be_curried() {
        $getAuthorName = f\prop_in(array('author', 'name', 'first'));
        $this->assertTrue(is_callable($getAuthorName));

        $book = array(
            'title' => 'Lorem ipsum',
            'author' => array(
                'name' => array(
                    'first' => 'Alice',
                    'last' => 'Bobson'
                )
            )
        );

        $this->assertEquals(
            'Alice',
            $getAuthorName($book)
        );
    }

}
