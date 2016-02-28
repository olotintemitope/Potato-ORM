<?php
/**
 * Created by PhpStorm.
 * User: andela
 * Date: 2/28/16
 * Time: 2:26 AM
 */

namespace Laztopaz\potatoORM\Test;

use Laztopaz\potatoORM\DatabaseConnection;
use Laztopaz\potatoORM\DatabaseHandler;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\EmptyArrayException;

class ExceptionTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Laztopaz\potatoORM\EmptyArrayException
	 */
	public function testEmptyArrayOnFindAndWhere()
	{
		$dbHandler = new DatabaseHandler("users",Null);

		$dbHandler->findAndWhere([], "users", Null);

	}

}