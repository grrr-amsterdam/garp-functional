<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\Product;
use Garp\Functional\Types\Traits\{TestsSemigroupLaws, TestsMonoidLaws};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ProductTest extends TestCase {

    use TestsSemigroupLaws;
    use TestsMonoidLaws;

    public function test_semigroup_laws() {
        $this->assertObeysSemigroupLaws(
            new Product(540),
            new Product(19),
            new Product(-5)
        );
    }

    public function test_monoid_laws() {
        $this->assertObeysMonoidLaws(new Product(42));
    }

    public function test_multiplication() {
        $sums = $this->_productProvider();
        $this->assertTrue(
            f\every(
                function ($args) {
                    return (new Product($args[2]))->equals(
                        (new Product($args[0]))->concat(new Product($args[1]))
                    );
                },
                $sums
            )
        );
    }

    private function _productProvider(): array {
        return f\repeat(
            100,
            function () {
                $a = rand(0, 1000);
                $b = rand(0, 1000);
                $product = $a * $b;
                return [$a, $b, $product];
            }
        )();
    }

}


