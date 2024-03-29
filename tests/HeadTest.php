<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class HeadTest extends TestCase {

    public function test_should_grab_head_of_arrays(): void {
        $spices = array('nutmeg', 'clove', 'cinnamon');
        $this->assertEquals(
            'nutmeg',
            f\head($spices)
        );
    }

    public function test_should_grab_head_of_strings(): void {
        $miles = 'Miles';
        $this->assertEquals(
            'M',
            f\head($miles)
        );
    }

    public function test_should_grab_head_from_traversable(): void {
        $spiceIterator = new MockSpiceTraverser();
        $this->assertEquals(
            'nutmeg',
            f\head($spiceIterator)
        );
    }

    public function test_should_get_null_from_empty_collection(): void {
        $this->assertNull(f\head(array()));
    }

    public function test_should_get_empty_string_from_empty_string(): void {
        $this->assertEquals(
            '',
            f\head('')
        );
    }

    public function test_should_get_null_on_unusable_input(): void {
        $this->assertNull(f\head(12345));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\head));
    }

    public function test_should_grab_head_of_assoc_arrays(): void {
        $spices = [
          'cauliflower' => 'nutmeg',
          'stew' => 'clove',
          'cake' => 'cinnamon'
        ];

        $this->assertEquals(
            'nutmeg',
            f\head($spices)
        );

        // The old array stays the same
        $this->assertEquals(
            [
              'cauliflower' => 'nutmeg',
              'stew' => 'clove',
              'cake' => 'cinnamon'
            ],
            $spices
        );
    }
}
