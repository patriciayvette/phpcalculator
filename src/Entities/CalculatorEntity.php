<?php

namespace Jakmall\Recruitment\Calculator\Entities;

class CalculatorEntity
{
    /**
     * @var string
     */
    private $command;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $result;
    /**
     * @var string
     */
    private $output;

    public function setCommand($command){
        $this->command = $command;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function setResult($result){
        $this->result = $result;
    }

    public function setOutput($output){
        $this->output = $output;
    }

    public function getCommand(){
        return $this->command;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getResult(){
        return $this->result;
    }
    
    public function getOutput(){
        return $this->output;
    }
    
    public function __construct($command,$description,$result,$output)
    {
        $this->command = $command;
        $this->description = $description;
        $this->result = $result;
        $this->output = $output;
    }
}