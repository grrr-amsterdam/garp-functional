<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ContainsTest extends TestCase {

    public function test_should_return_string_match_when_given_strings(): void {
        $this->assertTrue(
            f\contains('hello', 'hello world')
        );
        $this->assertTrue(
            f\contains('a', 'ananas')
        );
        $this->assertFalse(
            f\contains('b', 'ananas')
        );
    }

    public function test_should_use_in_array_when_given_array(): void {
        $this->assertTrue(
            f\contains('hello', array('hello', 'world'))
        );
        $obj = new stdClass();
        $this->assertTrue(
            f\contains($obj, array($obj))
        );
        $this->assertTrue(
            f\contains(12, array(12, 13, 14, 14, 13, 12))
        );
        $this->assertFalse(
            f\contains(40, array(12, 13, 14, 14, 13, 12))
        );
        $this->assertFalse(
            f\contains('hello', array())
        );
    }

    public function test_should_work_with_traversables(): void {
        $spiceTraverser = new MockSpiceTraverser();
        $this->assertTrue(
            f\contains('cinnamon', $spiceTraverser)
        );
        $this->assertFalse(
            f\contains("piment d'espelette", $spiceTraverser)
        );
    }

    /**
     * @param  mixed $invalidCollection
     *
     * @dataProvider invalidCollections
     */
    public function test_will_throw_on_invalid_collection($invalidCollection): void {
        $this->expectException(InvalidArgumentException::class);
        f\contains('x', $invalidCollection);
    }

    public function test_should_be_curried(): void {
        $containsHello = f\contains('hello');
        $this->assertTrue(is_callable($containsHello));
        $this->assertTrue($containsHello(array('hello', 'world')));
    }

    public static function invalidCollections(): array {
        return array(
            array(100),
            array(new stdClass()),
            array(true),
            array(false)
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\contains));
    }
}
