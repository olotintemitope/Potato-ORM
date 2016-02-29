<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Exception;

class NoRecordUpdateException extends  Exception {
	
    public static function checkNoRecordUpdateException($message)
    {
    	return new static($message);
    }

}
