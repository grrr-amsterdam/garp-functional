<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class FindTest extends TestCase {

    public function test_should_find_from_numeric_array() {
        $spices = array('nutmeg', 'clove', 'cinnamon');
        $this->assertEquals(
            'clove',
            f\find(
                f\equals('clove'),
                $spices
            )
        );
        $this->assertNull(
            f\find(f\equals('cumin'), $spices)
        );
    }

    public function test_should_find_from_assoc_array() {
        $colors = array(
            'red' => '#FF0000',
            'green' => '#00FF00',
            'blue' => '#0000FF'
        );
        $this->assertEquals(
            '#FF0000',
            f\find('Garp\Functional\id', $colors)
        );
    }

    public function test_should_find_from_iterable_object() {
        $spiceTraverser = new MockSpiceTraverser();
        $this->assertEquals(
            'clove',
            f\find(f\equals('clove'), $spiceTraverser)
        );
    }

    public function test_should_be_curried() {
        $findSaxPlayer = f\find(f\prop_equals('instrument', 'saxophone'));
        $this->assertTrue(is_callable($findSaxPlayer));
        $musicians = array(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet')
        );
        $this->assertEquals(
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            $findSaxPlayer($musicians)
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\find));
    }
}
