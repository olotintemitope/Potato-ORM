<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;


class NoRecordDeletionException {

	public static  function  noRecordUpdateException($message)
	{
		return new static($message);
	}

}