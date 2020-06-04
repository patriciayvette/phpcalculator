<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

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

    public function __construct()
    {
        $commandVerb = $this->getCommandVerb();

        $this->signature = sprintf(
            '%s {base : The base number} {exp : The exponent number}',
            $this->getCommandOperation()
        );
        $this->description = sprintf('%s the given Numbers', ucfirst($commandVerb));
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'exponent';
    }

    protected function getCommandOperation(): string
    {
        return 'pow';
    }

    public function handle(): void
    {
        $base = $this->getInput('base');
        $exp = $this->getInput('exp');
        $description = $this->generateCalculationDescription($base, $exp);
        $result = $this->calculateAll($base,$exp);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInput(string $arg): string
    {
        return $this->argument($arg);
    }

    protected function generateCalculationDescription($base, $exp): string
    {
        $operator = $this->getOperator();
        return sprintf('%s %s %s', $base, $operator, $exp);
    }

    protected function getOperator(): string
    {
        return '^';
    }

    /**
     * @param float|int $base
     * @param float|int $exp
     * 
     * @return float|int
     */
    protected function calculateAll($base, $exp)
    {
        return pow($base,$exp);
    }
}
