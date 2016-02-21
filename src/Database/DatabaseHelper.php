<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class DatabaseHelper extends \PDO
{
	protected static $databaseName;
	protected static $databaseHost;
	protected static $databaseDriver;
	protected $databasePort;
	protected static $databaseUsername;
	protected static $databasePassword;
	protected $databaseHandle;

	/**
	 * This is a constructor; a default method  that will be called automatically during class instantiation
	 */
	public function __construct()
	{
		self::loadEnv(); // load the environment variables

		self::$databaseName     =  getenv('databaseName');
		self::$databaseHost     =  getenv('databaseHost');
		self::$databaseDriver   =  getenv('databaseDriver');
		$this->databasePort     =  getenv('databasePort');
		self::$databaseUsername =  getenv('databaseUsername');
		self::$databasePassword =  getenv('databasePassword');

	}

	/**
	 * This method connects the specified database chosen by the user
	 * @params void
	 * @return boolean true or false
	 */
	public static function connect()
	{
		try {
			$options = array (

				PDO::ATTR_PERSISTENT    => true,

				PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
			);
			$databaseHandle = new PDO(self::getDatabaseDriver(), self::$databaseUsername, self::$databasePassword, $options);

		} catch(PDOException $e){

			return $e->getMessage();
		}

		return $databaseHandle;
	}

	/**
	 * This method determines the driver to be used for appropriate database server
	 * @params void
	 * @return string dsn
	 */
	public static function getDatabaseDriver()
	{
		$dsn = "";

		switch (self::$databaseDriver)
		{
			case 'mysql':

				// Set DSN
				$dsn = 'mysql:host='.    self::$databaseHost. ';dbname='. self::$databaseName;
				break;
			case 'sqlite':

				// Set DSN
				$dsn = 'sqlite:host='.   self::$databaseHost. ';dbname='. self::$databaseName;
				break;
			case 'pgsql':

				// Set DSN
				$dsn = 'pgsqlsql:host='. self::$databaseHost. ';dbname='. self::$databaseName;
				break;
			default:
				// Set DSN
				$dsn = 'mysql:host='.    self::$databaseHost. ';dbname='. self::$databaseName;
		}
		return $dsn;
	}

	/**
	 * This method creates a particular table
	 * @param tableName
	 * $return boolean true or false
	 */

	public function createTable($tableName)
	{
		try {

			$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(';

			$sql.= ' id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 100 ), gender VARCHAR( 10 ), alias VARCHAR( 150 ) NOT NULL, class VARCHAR( 150 ), stack VARCHAR( 50 ) )';

			$boolResponse = $this->databaseHandle->exec($sql);

			return $boolResponse;

		} catch (PDOException $e) {

			echo $e->getMessage();
		}
	}

	/**
	 * This method returns column fields of a particular table
	 * @param $table
	 * @return array
	 */
	public function getColumnNames($table){

		$tableFields = array();

		$sql = "SHOW COLUMNS FROM ".$table;

		try {

			$stmt = self::connect()->prepare($sql);
			$stmt->bindValue(':table', $table, PDO::PARAM_STR);
			$stmt->execute();

			while ($fieldName = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$tableFields[] = $fieldName['Field'];
			}
			return $tableFields;

		} catch (PDOException $e) {

			trigger_error('Could not connect to MySQL database. ' . $e->getMessage() , E_USER_ERROR);
		}
	}

	/**
	 * Load Dotenv to grant getenv() access to environment variables in .env file
	 */
	protected function loadEnv()
	{
		if (!getenv("APP_ENV"))
		{
			$dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
			$dotenv->load();
		}
	}

}