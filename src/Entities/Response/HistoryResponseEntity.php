<?php

namespace Jakmall\Recruitment\Calculator\Entities\Response;

class HistoryResponseEntity implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $command;
    
    /**
     * @var string
     */
    private $operation;
    
    /**
     * @var array
     */
    private $input;

    /**
     * @var string
     */
    private $result;

    /**
     * @var string
     */
    private $time;

    /**
     * Get the value of id
     *
     * @return  string
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  string  $id
     *
     * @return  self
     */ 
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of command
     *
     * @return  string
     */ 
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set the value of command
     *
     * @param  string  $command
     *
     * @return  self
     */ 
    public function setCommand(string $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get the value of operation
     *
     * @return  string
     */ 
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set the value of operation
     *
     * @param  string  $operation
     *
     * @return  self
     */ 
    public function setOperation(string $operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get the value of input
     *
     * @return  array
     */ 
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set the value of input
     *
     * @param  array  $input
     *
     * @return  self
     */ 
    public function setInput(array $input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get the value of result
     *
     * @return  string
     */ 
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set the value of result
     *
     * @param  string  $result
     *
     * @return  self
     */ 
    public function setResult(string $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get the value of time
     *
     * @return  string
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @param  string  $time
     *
     * @return  self
     */ 
    public function setTime(string $time)
    {
        $this->time = $time;

        return $this;
    }

    public function __construct($id,$command,$operation,$input,$result,$time)
    {
        $this->id = $id;
        $this->command = $command;
        $this->operation=$operation;
        $this->input = $input;
        $this->result = $result;
        $this->time = $time;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}