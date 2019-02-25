<?php
declare(strict_types=1);

namespace Garp\Functional\Types\Traits;

use Garp\Functional\Types\TypeClasses\Monoid;
use PHPUnit\Framework\TestCase;

/**
 * Use this trait in a PHPUnit testcase to ensure your Semigroup implementation obeys the
 * Semigroup laws.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
trait TestsMonoidLaws {

    public function assertObeysMonoidLaws(Monoid $m) {
        if (!$this instanceof TestCase) {
            throw new \RunTimeException(
                __TRAIT__ . ' should be used in the context of a PHPUnit TestCase'
            );
        }

        $empty = get_class($m) . '::empty';
        $this->assertEquals(
            $m,
            $m->concat($empty()),
            'Does not satisfy law of right identity'
        );
        $this->assertEquals(
            $m,
            $empty()->concat($m),
            'Does not satisfy law of left identity'
        );
    }

}
