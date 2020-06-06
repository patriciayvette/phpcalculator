<?php

namespace Jakmall\Recruitment\Calculator;

use PDO;
use PDOException;

class Connection 
{
    protected $databasePath;
    private $pdo;

    public function __construct()
    {
        $rootPath = dirname(__DIR__, 1);
        $config = include($rootPath.'/config/database.php');
        $this->databasePath = $rootPath.'/'.$config['database'];
        if($this->pdo === null){
            try{
                $this->pdo = new PDO("sqlite:".$this->databasePath);
            }catch(PDOException $e){
                die ($e->getMessage());
            }
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}