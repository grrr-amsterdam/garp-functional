<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SortByMapTest extends TestCase {

    public function test_should_sort_associative_array_by_map(): void {
        $person = [
            'dob' => new DateTime('1985-02-11'),
            'nationality' => 'Nl',
            'name' => 'Harmen'
        ];
        $this->assertSame(
            ['name', 'nationality', 'dob'],
            array_keys(f\sort_by_map(['name', 'nationality', 'dob'], $person))
        );
        $this->assertSame(
            ['dob', 'name', 'nationality'],
            array_keys(f\sort_by_map(['dob', 'name', 'nationality'], $person))
        );
    }

    public function test_should_sort_numeric_array_by_map(): void {
        $colors = ['yellow', 'orange', 'violet', 'blue', 'green', 'red', 'indigo'];
        $roygbiv = ['red', 'orange', 'yellow', 'green', 'blue', 'indigo', 'violet'];
        $this->assertSame(
            $roygbiv,
            f\sort_by_map($roygbiv, $colors)
        );
    }

    public function test_missing_keys_should_be_placed_at_the_end(): void {
        $person = [
            'dob' => new DateTime('1985-02-11'),
            'nationality' => 'Nl',
            'name' => 'Harmen'
        ];
        $this->assertSame(
            ['dob', 'name', 'nationality'],
            array_keys(f\sort_by_map(['dob', 'name',], $person))
        );

        $colors = ['yellow', 'orange', 'violet', 'blue', 'green', 'red', 'indigo'];
        $royg = ['red', 'orange', 'yellow', 'green'];
        $this->assertSame(
            ['red', 'orange', 'yellow', 'green', 'violet', 'blue', 'indigo'],
            f\sort_by_map($royg, $colors)
        );
    }

    public function test_should_not_care_about_unknown_keys(): void {
        $person = [
            'dob' => new DateTime('1985-02-11'),
            'nationality' => 'Nl',
            'name' => 'Harmen'
        ];
        $this->assertSame(
            ['dob', 'name', 'nationality'],
            array_keys(f\sort_by_map(['dob', 'favorite_color', 'name', 'favorite_food'], $person))
        );

        $colors = ['yellow', 'orange', 'violet'];
        $roygbiv = ['red', 'orange', 'yellow', 'green', 'blue', 'indigo', 'violet'];
        $this->assertSame(
            ['orange', 'yellow', 'violet'],
            f\sort_by_map($roygbiv, $colors)
        );
    }

    public function test_should_be_curried(): void {
        $this->assertTrue(is_callable(f\sort_by_map(['foo', 'bar'])));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\sort_by_map));
    }
}
