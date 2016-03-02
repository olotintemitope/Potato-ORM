<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Laztopaz\potatoORM\TableNotCreatedException;

class DatabaseHelper {
  
    public $dbConn;
    
    /**
     * This is a constructor; a default method  that will be called automatically during class instantiation
     */
    public function __construct($dbConnect)
    {
        $this->dbConn = $dbConnect;

    }
    
    /**
     * This method creates a particular table
     * @param tableName
     * $return boolean true or false
     */
    public function createTable($tableName, $conn = NULL)
    {
        if (is_null($conn)) {
            $conn = $this->dbConn;
        }

        $sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(';
        $sql.= ' id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 100 ), gender VARCHAR( 10 ), alias VARCHAR( 150 ) NOT NULL, class VARCHAR( 150 ), stack VARCHAR( 50 ) )';

        return $conn->exec($sql);

        throw TableNotCreatedException::checkTableNotCreatedException("Check your database connection");
   }
  
}
