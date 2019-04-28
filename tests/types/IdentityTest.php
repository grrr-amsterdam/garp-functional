<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\Identity;
use Garp\Functional\Types\Traits\TestsFunctorLaws;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class IdentityTest extends TestCase {

    use TestsFunctorLaws;

    public function test_functor_laws() {
        $this->assertObeysFunctorLaws(
            new Identity('foo'),
            'strtoupper',
            'str_split'
        );
    }

}
