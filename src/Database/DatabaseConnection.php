<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class DatabaseConnection extends PDO
{
    private $databaseName;
    private $databaseHost;
    private $databaseDriver;
    private $databaseUsername;
    private $databasePassword;

    public function __construct()
    {
        $this->loadEnv(); // load the environment variables

        $this->databaseName = getenv('databaseName');
        $this->databaseHost = getenv('databaseHost');
        $this->databaseDriver = getenv('databaseDriver');
        $this->databaseUsername = getenv('databaseUsername');
        $this->databasePassword = getenv('databasePassword');

        try {
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
            ];

            parent::__construct($this->getDatabaseDriver(), $this->databaseUsername, $this->databasePassword, $options);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

     /**
      * This method determines the driver to be used for appropriate database server.
      *
      * @params void
      *
      * @return string dsn
      */
     public function getDatabaseDriver()
     {
         $dsn = '';

         switch ($this->databaseDriver) {
            case 'mysql':
                $dsn = 'mysql:host='.$this->databaseHost.';dbname='.$this->databaseName; // Set DSN
                break;
            case 'sqlite':
                $dsn = 'sqlite:host='.$this->databaseHost.';dbname='.$this->databaseName;
                break;
            case 'pgsql':
                $dsn = 'pgsqlsql:host='.$this->databaseHost.';dbname='.$this->databaseName;
                break;
            default:
                $dsn = 'mysql:host='.$this->databaseHost.';dbname='.$this->databaseName;
                break;
        }

         return $dsn;
     }

     /**
      * Load Dotenv to grant getenv() access to environment variables in .env file.
      */
     public function loadEnv()
     {
         if (!getenv('APP_ENV')) {
             $dotenv = new Dotenv(__DIR__.'/../../');
             $dotenv->load();
         }
     }
}
