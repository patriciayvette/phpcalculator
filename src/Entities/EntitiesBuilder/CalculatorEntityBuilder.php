<?php

namespace Jakmall\Recruitment\Calculator\Entities\EntitiesBuilder;

use Jakmall\Recruitment\Calculator\Entities\CalculatorEntity;

class CalculatorEntityBuilder
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
        return $this;
    }

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    public function setResult($result){
        $this->result = $result;
        return $this;
    }

    public function setOutput($output){
        $this->output = $output;
        return $this;
    }

    public function Build():CalculatorEntity
    {
        return new CalculatorEntity(
                    $this->command,
                    $this->description,
                    $this->result,
                    $this->output
        );
    }
}