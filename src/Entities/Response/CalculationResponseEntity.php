<?php

namespace Jakmall\Recruitment\Calculator\Entities\Response;

class CalculationResponseEntity implements \JsonSerializable
{
    /**
     * @var string
     */
    public $command;
    /**
     * @var string
     */
    public $operation;
    /**
     * @var string
     */
    public $result;

    public function setCommand($command){
        $this->command = $command;
    }

    public function setOperation($operation){
        $this->operation = $operation;
    }

    public function setResult($result){
        $this->result = $result;
    }

    public function getCommand(){
        return $this->command;
    }

    public function getOperation(){
        return $this->operation;
    }

    public function getResult(){
        return $this->result;
    }
    
    public function __construct($command,$operation,$result)
    {
        $this->command = $command;
        $this->operation = $operation;
        $this->result = $result;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}