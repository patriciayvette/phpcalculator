<?php

namespace Jakmall\Recruitment\Calculator;

use PDO;
use PDOException;

class Connection 
{
    protected CONST SQLITE_PATH ='./storage/calculator.sqlite';
    private $pdo;

    public function __construct()
    {
        if($this->pdo === null){
            try{
                $this->pdo = new PDO("sqlite:".static::SQLITE_PATH);
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