<?php

namespace Jakmall\Recruitment\Calculator\Repositories;

use Exception;
use Jakmall\Recruitment\Calculator\Connection;

class CommandHistoryRepository
{
    protected $pdo;
    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
        $this->createHistoryTable();
    }

    public function createHistoryTable() : void
    {
        $query = 
            'CREATE TABLE IF NOT EXISTS calculator_history (
                id INTEGER PRIMARY KEY,
                command TEXT NOT NULL,
                description TEXT NOT NULL,
                result  TEXT NOT NULL,
                output TEXT NOT NULL,
                time TEXT NOT NULL
             )';
        try{
            $this->pdo->exec($query);
        }catch(Exception $e){
            die("Execute create query error, cause: ". print_r($this->pdo->errorInfo(),true) );
        }
    }

    public function getDbHistory() : array
    {
        $data = array();
        $query = 
            'SELECT ROW_NUMBER() OVER( ORDER BY id ) RowNo,
                    command,
                    description,
                    result,
                    output,
                    time
             FROM   calculator_history';
        $res = $this->pdo->query($query);
        if(!$res){
            die("Execute select query error, cause: ". print_r($this->pdo->errorInfo(),true) );
        }else{
            while ($rows = $res->fetch()) {
                $data[] = $rows;
            }
        }
        return $data;
    }

    public function getDbHistoryWithFilter(array $commands) : array
    {
        $data = array();
        $command = implode("','", $commands);
        $query = 
            "SELECT ROW_NUMBER() OVER( ORDER BY id ) RowNo,
                    command,
                    description,
                    result,
                    output,
                    time
             FROM   calculator_history
             WHERE  command IN ('$command')";
        $queryParam = $this->pdo->prepare($query);
        try{
            $queryParam->execute();
            while ($rows = $queryParam->fetch()) {
                $data[] = $rows;
            }
        }catch(Exception $e){
            die("Execute select query error, cause: ". print_r($this->pdo->errorInfo(),true) );
        }
        return $data;
    }

    public function insertDbHistory($command, $description, $result, $output) : bool
    {
        $query = 'INSERT INTO calculator_history
                            (command,
                             description,
                             result,
                             output,
                             time
                )
                  VALUES    (:command,
                             :description,
                             :result,
                             :output,
                             :time
                )';
        $queryParam = $this->pdo->prepare($query);
        $queryParam->bindValue(':command', $command);
        $queryParam->bindValue(':description', $description);
        $queryParam->bindValue(':result', $result);
        $queryParam->bindValue(':output', $output);
        $queryParam->bindValue(':time', date('Y-m-d H:i:s'));
        try{
            $res = $queryParam->execute();
        }catch(Exception $e){
            die("Execute insert query error, cause: ". print_r($this->pdo->errorInfo(),true) );
        }
        return $res;
    }
    
    public function deleteDbHistory() : bool
    {
        $query = 'DELETE FROM calculator_history';
        try{
            $res = $this->pdo->exec($query);
        }catch(Exception $e){
            die("Execute insert query error, cause: ". print_r($this->pdo->errorInfo(),true) );
        }
        return $res;
    }
}