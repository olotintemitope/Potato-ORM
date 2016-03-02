<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use PDO;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\TableFieldUndefinedException;
use Laztopaz\potatoORM\EmptyArrayException;
use Laztopaz\potatoORM\NoRecordDeletionException;
use Laztopaz\potatoORM\NoRecordInsertionException;
use Laztopaz\potatoORM\NoRecordUpdateException;

class DatabaseHandler {

    private $tableFields;
    private $dbHelperInstance;
    private $dbConnection;
    private $model;
    
    /**
     * This is a constructor; a default method  that will be called automatically during class instantiation
     */
    public function __construct($modelClassName, $dbConn = Null) 
    {

        if (is_null($dbConn)) {
            $this->dbConnection = new DatabaseConnection();

        } else {
            $this->dbConnection = $dbConn;

        }
        
        $this->model = $modelClassName;
     }
     
    /**
     * This method create a record and store it in a table row
     * @params associative array, string tablename
     * @return boolean true or false
     */
    public function create($associative1DArray, $tableName, $dbConn = Null) 
    {
        $tableFields = $this->getColumnNames($this->model, $this->dbConnection);

        $unexpectedFields = self::checkIfMagicSetterContainsIsSameAsClassModel($tableFields, $associative1DArray);
      
      if (count($unexpectedFields) > 0) {
          throw TableFieldUndefinedException::reportUnknownTableField($unexpectedFields,"needs to be created as a table field");
      }

      unset($associative1DArray[0]);

      if (is_null($dbConn)) {
          $dbConn = $this->dbConnection;

      }

      return $this->insertRecord($dbConn, $tableName, $associative1DArray);

    }
    
    /**
     * This method runs the insertion query
     * @param  $dbConn           
     * @param  $tableName          
     * @param  $associative1DArray 
     * @return boolean true         
     */
    private function  insertRecord($dbConn, $tableName, $associative1DArray) 
    {
        $insertQuery = 'INSERT INTO '.$tableName;

        $TableValues = implode(',',array_keys($associative1DArray));

        foreach ($associative1DArray as $field => $value) {
            $FormValues[] = "'".trim(addslashes($value))."'";
        }

        $splittedTableValues = implode(',', $FormValues);

        $insertQuery.= ' ('.$TableValues.')';
        $insertQuery.= ' VALUES ('.$splittedTableValues.')';

        $executeQuery = $dbConn->exec($insertQuery);

        if ($executeQuery) {
            return true;
        }

        return false;

        throw NoRecordInsertionException::checkNoRecordAddedException("Record not inserted successfully");
      }

    /**
     * This method updates any table by supplying 3 parameter
     * @params: $updateParams, $tableName, $associative1DArray
     * @return boolean true or false
     */
    public function update(array $updateParams, $tableName, $associative1DArray, $dbConn = null)
    {
        $sql = "";

        if (is_null($dbConn)) {
            $dbConn = $this->dbConnection;
        }

        $updateSql = "UPDATE `$tableName` SET ";

        unset($associative1DArray['id']);

        $unexpectedFields = self::checkIfMagicSetterContainsIsSameAsClassModel($this->getColumnNames($this->model, $this->dbConnection), $associative1DArray);

        if (count($unexpectedFields) > 0) {
            throw TableFieldUndefinedException::reportUnknownTableField($unexpectedFields, "needs to be created as a table field");
        }

        foreach ($associative1DArray as $field => $value) {
            $sql .= "`$field` = '$value'".",";
        }

        $updateSql .= $this->prepareUpdateQuery($sql);

        foreach ($updateParams as $key => $val) {
            $updateSql .= " WHERE $key = $val";
        }

        $stmt = $dbConn->prepare($updateSql);

        $boolResponse = $stmt->execute();

        if ($boolResponse) {
            return true;
        }

        return false;

        throw NoRecordUpdateException::checkNoRecordUpdateException("Record not updated successfully");
    }
    
  /**
   * This method retrieves record from a table
   * @params int id, string tableName
   * @return array
   */
   public static function read($id, $tableName, $dbConn = null)
   {
       $tableData = [];

       if (is_null($dbConn)) {
           $dbConn = new DatabaseConnection();
       }

       $sql = $id ? 'SELECT * FROM '.$tableName.' WHERE id = '.$id : 'SELECT * FROM '.$tableName;

       try {
           $stmt = $dbConn->prepare($sql);
           $stmt->bindValue(':table', $tableName);
           $stmt->bindValue(':id', $id);
           $stmt->execute();

       } catch (PDOException $e) {
        return  $e->getMessage();

       }

       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

       foreach ($results as $result) {
           array_push($tableData, $result);
       }

       return $tableData;

   }
   
  /**
   * This method deletes a record  from a table row
   * @params int id, string tableName
   * @return boolean true or false
   */
  public static function delete($id, $tableName, $dbConn = null)
  {
      if (is_null($dbConn)) {
          $dbConn = new DatabaseConnection();
      }

      $sql = 'DELETE FROM '.$tableName.' WHERE id = '.$id;

      $boolResponse = $dbConn->exec($sql);

      if ($boolResponse) {
        return true;

      }

      throw NoRecordDeletionException::checkNoRecordDeleteException("Record not deleted successfully");
  }
  
  /**
   * This method checks if the magic setters array is the same as the table columns
   * @param array $tableColumn
   * @param array $userSetterArray
   * @return array $unexpectedFields
   */
  public static function checkIfMagicSetterContainsIsSameAsClassModel(array $tableColumn, array $userSetterArray)
  {
      $unexpectedFields = [];

      foreach ($userSetterArray as $key => $val) {
          if (!in_array($key,$tableColumn)) {
              $unexpectedFields[] = $key;
          }
      }

      return $unexpectedFields;

  }
  
  /**
   * This method returns sql query
   * @param $sql
   * @return string
   */
  public function prepareUpdateQuery($sql)
  {
      $splittedQuery = explode(",",$sql);

      array_pop($splittedQuery);

      $mergeData = implode(",",$splittedQuery);

      return $mergeData;

  }
  
  /**
   * @param array $params
   * @param $tableName
   * @param $dbConn
   * @return bool
   * @throws EmptyArrayException
   */
  public function findAndWhere($params, $tableName, $dbConn = null)
  {
      if (is_null($dbConn)) {
          $dbConn = $this->dbConnection;
      }

      if (is_array($params) && !empty($params)) {
          $sql = "SELECT * FROM ".$tableName;

          foreach ($params as $key => $val) {
              $sql .= " WHERE `$key` = '$val'";
          }

          $statement = $dbConn->prepare($sql);
          $statement->execute();

          $returnedRowNumbers = $statement->rowCount();
          
          return $returnedRowNumbers ? true : false;
      }

      throw EmptyArrayException::checkEmptyArrayException("Array Expected: parameter passed to this function is not an array");
  }
  
  /**
   * This method returns column fields of a particular table
   * @param $table
   * @param $conn
   * @return array
   */
 public function getColumnNames($table, $dbConn = null) 
 {
     $tableFields = [];
     
     if (is_null($dbConn)) {
         $dbConn = $this->dbConnection;
     }

     $sql = "SHOW COLUMNS FROM ".$table;
     
     $stmt = $dbConn->prepare($sql);
     $stmt->bindValue(':table', $table, PDO::PARAM_STR);
     $stmt->execute();

     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
     foreach ($results as $result) {
         array_push($tableFields, $result['Field']);
     }

     return $tableFields;
     
   }

}
