<?php

namespace Jakmall\Recruitment\Calculator\Commands\History;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorHistoryController;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class ListHistoryCommand extends Command
{
     /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    protected const COMMAND_SIGNATURE = 'history:list 
                                        {commands?* : Filter the history by commands}
                                        {--d|driver=database : Driver for storage connection}';
    protected const COMMAND_DESCRIPTION = 'Show calculator history';

    public function __construct()
    {
        $this->signature = static::COMMAND_SIGNATURE;
        $this->description = static::COMMAND_DESCRIPTION;
        parent::__construct();
    }

    public function handle(CommandHistoryManagerInterface $CommandInterface): void
    {
        $driver = $this->input->getOption('driver');
        $commands = $this->argument('commands') ?? array();
        $arr = CalculatorHistoryController::historyList($CommandInterface,$commands,$driver);
        
        if(empty($arr)){
            $this->comment('History is empty.');
        }else{
            $this->comment($this->printHistory($arr));
        }
    }

    private function printHistory($data)
    {
        $tableData = [];
        foreach ($data as $key => $row) {
            $tableData[] = [
                'No' => $row['RowNo'],
                'Command' => ucfirst($row['command']),
                'Description' => $row['description'],
                'Result' => $row['result'],
                'Output' => $row['output'],
                'Time' => $row['time']
            ];
        }
        $tableHeader = ['No', 'Command', 'Description', 'Result', 'Output', 'Time'];
        $this->table($tableHeader, $tableData);
    }
}