<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Laztopaz\potatoORM\InterfaceBaseClass;
use Laztopaz\potatoORM\BaseClass;
use Laztopaz\potatoORM\User;

class BaseClassController extends BaseClass implements InterfaceBaseClass
{

	public function  __construct()
	{

	}

	/**
	 * This method gets all record from database table
	 * @params void
	 * @return boolean true or false;
	 */
	public static function getAll()
	{

	}

	/**
	 * This method create or update record in a database table
	 * @params void
	 * @return boolean true or false;
	 */
	public function save()
	{

	}

	/**
	 * This method delete a row from the table by the row id
	 * @params int id
	 * @return boolean true or false
	 */
	public static function destroy($id)
	{

	}


	/**
	 * This method find a record by id
	 * @params int id
	 * @return int  rowid
	 */
	public static function find($id)
	{

	}

}