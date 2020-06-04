<?php

namespace Jakmall\Recruitment\Calculator\Entities;

class CommandEntity
{
    /**
     * @var string
     */
    private $signature;

    /**
     * @var string
     */
    private $description; 

    /**
     * @param string $commandVerb
     * @param string $commandPassiveVerb
     * 
     */
    public function __construct($commandVerb, $commandPassiveVerb)
    {
        $this->signature = sprintf(
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $commandPassiveVerb
        );
        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}