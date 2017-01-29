<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class Lens {
    protected $_getter;
    protected $_setter;

    public function __construct($getter, $setter) {
        $this->_getter = $getter;
        $this->_setter = $setter;
    }

    public function getScope($object) {
        $getter = $this->_getter;
        return $getter($object);
    }

    public function update($updated, $object) {
        $copy = $object;
        $setter = $this->_setter;
        return $setter($updated, $copy);
    }

}

/**
 * Creates a lens object.
 *
 * @param callable $getter Function which gets the scope.
 * @param callable $setter Function which merges the scope back.
 * @return Lens
 */
function lens($getter, $setter) {
    return new Lens($getter, $setter);
}

function view($lens, $object = null) {
    $lensApplication = function ($object) use ($lens) {
        return $lens->getScope($object);
    };
    return is_null($object) ? $lensApplication : $lensApplication($object);
}

function over(Lens $lens, $fn, $object = null) {
    $lensApplication = function ($object) use ($lens, $fn) {
        $focus = $lens->getScope($object);
        return $lens->update($fn($focus), $object);
    };
    return is_null($object) ? $lensApplication : $lensApplication($object);
}
