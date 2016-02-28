<?php
/**
 * Created by PhpStorm.
 * User: andela
 * Date: 2/28/16
 * Time: 7:12 PM
 */

namespace Laztopaz\potatoORM\Test;

use Exception;

class TableFieldNotFoundException extends Exception {

	public function reportUnknownTableField($message)
	{
		return new static($message);
	}

}