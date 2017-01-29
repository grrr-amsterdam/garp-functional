<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class LensTest extends TestCase {

    public function test_should_create_lens() {
        $this->assertTrue(f\lens(f\prop('x'), f\prop_set('x')) instanceof Garp\Functional\Lens);
    }

    public function test_lens_over() {
        $user = array(
            'first_name' => 'Alice',
            'last_name' => 'Bobson',
            'addresses' => array(
                array('street' => 'Willow Lane', 'number' => 50),
                array('street' => '5th Avenue', 'number' => 1000)
            )
        );

        $lens = f\lens(f\prop('first_name'), f\prop_set('first_name'));
        $this->assertEquals(
            array(
                'first_name' => 'ALICE',
                'last_name' => 'Bobson',
                'addresses' => array(
                    array('street' => 'Willow Lane', 'number' => 50),
                    array('street' => '5th Avenue', 'number' => 1000)
                )
            ),
            f\over($lens, 'strtoupper', $user)
        );

        // Make sure a copy was made
        $this->assertEquals(
            array(
                'first_name' => 'Alice',
                'last_name' => 'Bobson',
                'addresses' => array(
                    array('street' => 'Willow Lane', 'number' => 50),
                    array('street' => '5th Avenue', 'number' => 1000)
                )
            ),
            $user
        );

        $addressLens = f\lens(f\prop('addresses'), f\prop_set('addresses'));
        $this->assertEquals(
            array(
                array('street' => 'Willow Lane', 'number' => 50),
                array('street' => '5th Avenue', 'number' => 1000)
            ),
            f\view($addressLens, $user)
        );
    }

    public function test_wonderful_in_combination_with_when() {
        $users = array(
            array(
                'first_name' => 'Alice',
                'last_name' => 'Bobson',
                'role' => 'regular',
                'addresses' => array(
                    array('street' => 'Willow Lane', 'number' => 50),
                    array('street' => '5th Avenue', 'number' => 1000)
                )
            ),
            array(
                'first_name' => 'John',
                'last_name' => 'Jackson',
                'role' => 'admin',
                'addresses' => array(
                    array('street' => 'Slappy Drive', 'number' => 5),
                )
            )
        );

        $lens = f\lens(f\prop('first_name'), f\prop_set('first_name'));
        $prefixedUsers = f\map(
            f\when(
                f\prop_equals('role', 'admin'),
                f\over($lens, f\concat('Administrator ')),
                'Garp\Functional\Id'
            ),
            $users
        );
        $this->assertEquals(
            array(
                array(
                    'first_name' => 'Alice',
                    'last_name' => 'Bobson',
                    'role' => 'regular',
                    'addresses' => array(
                        array('street' => 'Willow Lane', 'number' => 50),
                        array('street' => '5th Avenue', 'number' => 1000)
                    )
                ),
                array(
                    'first_name' => 'Administrator John',
                    'last_name' => 'Jackson',
                    'role' => 'admin',
                    'addresses' => array(
                        array('street' => 'Slappy Drive', 'number' => 5),
                    )
                )
            ),
            $prefixedUsers
        );

    }

}
