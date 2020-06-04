<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorController;

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

    public function handle(): void
    {
        $base = $this->argument('base');
        $exp = $this->argument('exp');
        $description = CalculatorController::generateCalculationDescription(array($base,$exp),static::OPERATOR);
        $result = pow($base,$exp);

        $this->comment(sprintf('%s = %s', $description, $result));
    }
}
