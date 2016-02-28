<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\Test;

use Exception;

class TableFieldNotFoundException extends Exception {

	public function reportUnknownTableField($message)
	{
		return new static($message);
	}

}