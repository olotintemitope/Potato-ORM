<?php
/**
 * Created by PhpStorm.
 * User: andela
 * Date: 2/22/16
 * Time: 9:38 PM
 */

namespace Laztopaz\potatoORM;

use Exception;

class NullArgumentPassedToFunction  extends  Exception{

	public static function ckeckNullArgumentPassedToFunction($message)
	{
		return new static ($message);
	}

}