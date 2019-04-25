<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class FindIndexTest extends TestCase {

    public function test_should_find_from_numeric_array() {
        $spices = array('nutmeg', 'clove', 'cinnamon');
        $this->assertEquals(
            1,
            f\find_index(
                f\equals('clove'),
                $spices
            )
        );
        $this->assertNull(
            f\find_index(f\equals('cumin'), $spices)
        );
    }

    public function test_should_find_from_assoc_array() {
        $colors = array(
            'red' => '#FF0000',
            'green' => '#00FF00',
            'blue' => '#0000FF'
        );
        $this->assertEquals(
            'red',
            f\find_index('Garp\Functional\id', $colors)
        );
        $this->assertEquals(
            'blue',
            f\find_index(f\equals('#0000FF'), $colors)
        );
    }

    public function test_should_find_from_iterable_object() {
        $spiceTraverser = new MockSpiceTraverser();
        $this->assertEquals(
            2,
            f\find_index(f\equals('clove'), $spiceTraverser)
        );
        $this->assertNull(
            f\find_index(f\equals('cumin'), $spiceTraverser)
        );
    }

    public function test_should_be_curried() {
        $findSaxPlayer = f\find_index(f\prop_equals('instrument', 'saxophone'));
        $this->assertTrue(is_callable($findSaxPlayer));
        $musicians = array(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet')
        );
        $this->assertEquals(
            1,
            $findSaxPlayer($musicians)
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\find_index));
    }
}
