<?php

namespace Jakmall\Recruitment\Calculator\Commands\History;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorHistoryController;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class clearHistoryCommand extends Command
{
     /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    protected const COMMAND_SIGNATURE = 'history:clear';
    protected const COMMAND_DESCRIPTION = 'Clear saved history';

    public function __construct()
    {
        $this->signature = static::COMMAND_SIGNATURE;
        $this->description = static::COMMAND_DESCRIPTION;
        parent::__construct();
    }

    public function handle(CommandHistoryManagerInterface $CommandInterface): void
    {
        CalculatorHistoryController::clearHistory($CommandInterface);
        $this->comment('History cleared!');
    }
}