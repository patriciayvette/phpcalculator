<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorController;
use Jakmall\Recruitment\Calculator\Entities\CommandEntity;

class AddCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    protected const COMMAND_VERB = 'add';
    protected const COMMAND_PASSIVE_VERB = 'added';
    protected const OPERATOR = '+';
    
    public function __construct()
    {
        $CommandEntity = new CommandEntity(static::COMMAND_VERB,static::COMMAND_PASSIVE_VERB);
        $this->signature = $CommandEntity->getSignature();
        $this->description = $CommandEntity->getDescription();
        parent::__construct();
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = CalculatorController::generateCalculationDescription($numbers,static::OPERATOR);
        $result = CalculatorController::calculateAll($numbers,static::OPERATOR);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }
}
