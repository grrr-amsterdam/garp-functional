<?php
namespace Garp\Functional\Tests\Helpers;

/**
 * Little mock object to test call().
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MockMusician {
    /**
     * @var string
     */
    private $_first;

    /**
     * @var string
     */
    private $_last;

    public function __construct($first, $last) {
        $this->_first = $first;
        $this->_last = $last;
    }

    public function getName(): string {
        return $this->_first . ' ' . $this->_last;
    }

    public function setName($first, $last): void {
        $this->_first = $first;
        $this->_last = $last;
    }

    public function __toString() {
        return $this->_first . ' ' . $this->_last;
    }
}
