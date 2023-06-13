<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class AutocurryTest extends TestCase {

    public function test_should_keep_on_curryin(): void {
        $foo = function ($a, $b, $c, $d) {
            return $a . $b . $c . $d;
        };

        $curried = f\autocurry($foo, 4);
        $this->assertTrue(is_callable($curried));
        $this->assertTrue(is_callable($curried('a')));
        $this->assertTrue(is_callable($curried('a', 'b')));
        $this->assertTrue(is_callable($curried('a')('b')));
        $this->assertTrue(is_callable($curried('a')('b', 'c')));
        $this->assertTrue(is_callable($curried('a', 'b')('c')));
        $this->assertTrue(is_callable($curried('a', 'b', 'c')));
        $this->assertSame('abcd', $curried('a', 'b', 'c', 'd'));
        $this->assertSame('abcd', $curried('a')('b', 'c', 'd'));
        $this->assertSame('abcd', $curried('a', 'b')('c', 'd'));
        $this->assertSame('abcd', $curried('a', 'b', 'c')('d'));

    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\autocurry));
    }
}
