<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorController;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorHistoryController;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class PowCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    protected const COMMAND_VERB = 'exponent';
    protected const COMMAND_OPERATOR = 'pow';
    protected const OPERATOR = '^';

    public function __construct()
    {
        $this->signature = sprintf(
            '%s {base : The base number} {exp : The exponent number}',
            static::COMMAND_OPERATOR
        );
        $this->description = sprintf('%s the given Numbers', ucfirst(static::COMMAND_VERB));
        parent::__construct();
    }

    public function handle(CommandHistoryManagerInterface $CommandInterface): void
    {
        $base = $this->argument('base');
        $exp = $this->argument('exp');
        $numbers = array($base,$exp);
        $calculatorEntity = CalculatorController::getCalulatorResult(
            $numbers,
            static::COMMAND_VERB,
            static::OPERATOR
        );
        CalculatorHistoryController::logCalculatorHistory($CommandInterface,$calculatorEntity);
        $this->comment($calculatorEntity->getOutput());
    }
}
