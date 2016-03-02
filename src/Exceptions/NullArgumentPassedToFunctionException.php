<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Exception;

class NullArgumentPassedToFunction extends Exception {

    public static function checkNullArgumentPassedToFunction($message)
    {
        return new static ($message);

    }

}
