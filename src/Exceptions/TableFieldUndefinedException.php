<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Exception;

class TableFieldUndefinedException extends Exception {

	public static function fieldsNotDefinedException($fieldsNotDefined,$message)
	{
		$splittedArray = implode(",",$fieldsNotDefined);

		return new static ($splittedArray."  ".$message );
	}

}