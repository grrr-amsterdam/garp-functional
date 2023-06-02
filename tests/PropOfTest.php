<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PropOfTest extends TestCase {

    public function test_should_read_from_indexed(): void {
        $spices = array('nutmeg', 'cinnamon', 'clove');
        $this->assertEquals('nutmeg', f\prop_of($spices, 0));
        $this->assertEquals('clove', f\prop_of($spices, 2));
    }

    public function test_should_read_from_assoc(): void {
        $colors = array(
            'red' => '#FF0000',
            'green' => '#00FF00',
            'blue' => '#0000FF'
        );
        $this->assertEquals('#00FF00', f\prop_of($colors, 'green'));
        $this->assertNull(f\prop_of($colors, 'yellow'));
    }

    public function test_should_read_from_string(): void {
        $this->assertEquals('n', f\prop_of('cinnamon', 2));
        $this->assertNull(f\prop_of('nutmeg', 20));
    }

    public function test_should_read_from_object(): void {
        $obj = new stdClass();
        $obj->answer = 42;

        $this->assertEquals(42, f\prop_of($obj, 'answer'));
        $this->assertNull(f\prop_of($obj, 'question'));
    }

    public function test_should_read_from_traversable(): void {
        $spiceIterator = new MockSpiceTraverser();
        $this->assertEquals(
            'nutmeg',
            f\prop_of($spiceIterator, 0)
        );
    }

    public function test_should_be_curried(): void {
        $this->assertTrue(is_callable(f\prop_of('foo')));
        $colors = array(
            'red' => '#FF0000',
            'green' => '#00FF00',
            'blue' => '#0000FF'
        );
        $getFromColors = f\prop_of($colors);
        $this->assertEquals(
            '#FF0000',
            $getFromColors('red')
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\prop_of));
    }
}
