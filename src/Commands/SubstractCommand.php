<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorController;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorHistoryController;
use Jakmall\Recruitment\Calculator\Entities\CommandEntity;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class SubstractCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    protected const COMMAND_VERB = 'substract';
    protected const COMMAND_PASSIVE_VERB = 'subtstracted';
    protected const OPERATOR = '-';

    public function __construct()
    {
        $CommandEntity = new CommandEntity(static::COMMAND_VERB,static::COMMAND_PASSIVE_VERB);
        $this->signature = $CommandEntity->getSignature();
        $this->description = $CommandEntity->getDescription();
        parent::__construct();
    }

    public function handle(CommandHistoryManagerInterface $CommandInterface): void
    {
        $numbers = $this->getInput();
        $calculatorEntity = CalculatorController::getCalulatorResult(
            $numbers,
            static::COMMAND_VERB,
            static::OPERATOR
        );
        CalculatorHistoryController::logCalculatorHistory($CommandInterface,$calculatorEntity);
        $this->comment($calculatorEntity->getOutput());
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }
}
