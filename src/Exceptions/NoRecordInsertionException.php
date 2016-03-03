<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\PotatoORM    ;

use Exception;

class NoRecordInsertionException extends Exception {

    public static function create($mesaage)
    {
        return new static($mesaage);
        
    }
}
