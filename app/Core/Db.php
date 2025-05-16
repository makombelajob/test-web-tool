<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    // Instance unique de la classe
    private static $instance;

    private const DBHOST = 'database';
    private const DBNAME = 'mvc_blog';
    private const DBUSER = 'admin';
    private const DBPASS = 'admin7791';

    public function __construct()
    {
        $dsn = 'mysql:dbname=' . self::DBNAME  . ';host=' . self::DBHOST;

        try{
            parent::__construct($dsn, self::DBUSER, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}