<?php
namespace Garp\Functional\Tests\Helpers;

/**
 * Little mock object to test behavior with __invoke().
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class CallableObject {

    protected $_num;

    /**
     * Class constructor
     *
     * @param int $n
     * @return void
     */
    public function __construct($n) {
        $this->_num = $n;
    }

    /**
     * Doubles the given integer
     *
     * @return int
     */
    public function __invoke() {
        return $this->_num * 2;
    }

}

