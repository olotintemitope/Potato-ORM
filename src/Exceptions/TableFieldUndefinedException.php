<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Exception;

class TableFieldUndefinedException extends Exception {

	public static function reportUnknownTableField($unExpectedFields, $message)
	{
		$fields = implode(", ",$unExpectedFields);

		//var_dump($fields);

		return new static($fields." ".$message);
	}

}