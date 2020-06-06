<?php

namespace Jakmall\Recruitment\Calculator\History\Service;

use Exception;
use Jakmall\Recruitment\Calculator\Repositories\CommandHistoryRepository;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class CalculatorHistoryService implements CommandHistoryManagerInterface
{
    
    protected $commandHistoryRepository;
    protected $filePath;
    protected const FILE_DRIVER = 'file';
    public function __construct()
    {
        $rootPath = dirname(__DIR__, 3);
        $config = include($rootPath.'/config/app.php');
        $this->filePath = $rootPath.'/'.$config['calculator_file_path'];
        $this->commandHistoryRepository = new CommandHistoryRepository();      
        $this->commandHistoryRepository->createHistoryTable();
    }

    /**
     * Returns array of command history.
     *
     * @return array
     */
    public function findAll($driver): array
    {
        if($driver == static::FILE_DRIVER){
            return $this->getFileHistory();
        }else{
            return $this->commandHistoryRepository->getDbHistory();
        }
    }

    public function findHistoryWithFilter($commands,$driver): array
    {
        if($driver == static::FILE_DRIVER){
            return $this->getFileHistoryWithFilter($commands);
        }else{
            return $this->commandHistoryRepository->getDbHistoryWithFilter($commands);
        }
    }
    
    public function log($command): bool
    {
        try{
            $this->writeHistoryFile($command);
            $this->commandHistoryRepository->insertDbHistory(
                $command->getCommand(), 
                $command->getDescription(), 
                $command->getResult(), 
                $command->getOutput()
            );
            return true;
        }catch(Exception $e){
            return false;
        }
        
    }

    public function clearAll():bool
    {
        try{
            unlink($this->filePath);
            $this->commandHistoryRepository->deleteDbHistory();
            return true;
        }catch(Exception $e){
            return false;
        }
    }    

    public function fileHistoryToArray():array
    {
        $file = @fopen($this->filePath, 'r');
        $data = explode("\r\n", fread($file, filesize($this->filePath)));
        $rowData = [];
        for ($i=0; $i<count($data)-1; $i++) {
            $rowItem = explode("|", $data[$i]);
            $rowData[] = [
                'command' => $rowItem[0],
                'description' => $rowItem[1],
                'result' => $rowItem[2],
                'output' => $rowItem[3],
                'time' => $rowItem[4]
            ];
        }
        return $rowData;
    }

    public function getFileHistory():array
    {
        return $this->fileHistoryToArray();
    }

    public function getFileHistoryWithFilter($commands):array
    {
        $arr = $this->fileHistoryToArray();
        $filteredArr = array_filter($arr, function ($var) use ($commands) {
            return ($var['command'] == $commands[0]);
        });
        return $filteredArr;
    }

    public function writeHistoryFile($command)
    {
        $txt = sprintf("%s|%s|%s|%s|%s.\r\n", $command->getCommand(), 
                            $command->getDescription(),
                            $command->getResult(),
                            $command->getOutput(),
                            date('Y-m-d H:i:s')
                    );
        file_put_contents($this->filePath, $txt, FILE_APPEND);
    }
}