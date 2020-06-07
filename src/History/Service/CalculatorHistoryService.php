<?php

namespace Jakmall\Recruitment\Calculator\History\Service;

use Exception;
use Jakmall\Recruitment\Calculator\Entities\EntitiesBuilder\CalculatorEntityBuilder;
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
            $id = $this->commandHistoryRepository->insertDbHistory(
                $command->getCommand(), 
                $command->getDescription(), 
                $command->getResult(), 
                $command->getOutput()
            );
            $this->writeHistoryFile($command,$id);
            return true;
        }catch(Exception $e){
            return false;
        }
        
    }

    public function getHistoryById($historyId) : array
    {
        return $this->commandHistoryRepository->getDbHistoryById($historyId);
    }

    public function clearAll():bool
    {
        try{
            if(file_exists($this->filePath)){
                unlink($this->filePath);
            }
            $this->commandHistoryRepository->deleteDbHistory();
            return true;
        }catch(Exception $e){
            return false;
        }
    } 
    
    public function clearHistoryById($historyId):bool
    {
        try{
            $this->clearFileHistory($historyId);
            $this->commandHistoryRepository->deleteDbHistoryById($historyId);
            return true;
        }catch(Exception $e){
            return $this->clearFileHistory($historyId);
        }
    }   

    public function fileHistoryToArray():array
    {
        $rowData = [];
        if(file_exists($this->filePath)){
            $file = @fopen($this->filePath, 'r');
            $data = explode("\r\n", fread($file, filesize($this->filePath)));
            for ($i=0; $i<count($data)-1; $i++) {
                $rowItem = explode("|", $data[$i]);
                $rowData[] = [
                    'id' => $rowItem[0],
                    'command' => $rowItem[1],
                    'description' => $rowItem[2],
                    'result' => $rowItem[3],
                    'output' => $rowItem[4],
                    'time' => $rowItem[5]
                ];
            }
        }
        
        return $rowData;
    }

    public function getFileHistory():array
    {
        return $this->fileHistoryToArray();
    }

    public function getFileHistoryWithFilter($commands):array
    {
        $arr_collection = collect($this->fileHistoryToArray());
        $filteredArr = $arr_collection->whereIn('command', $commands);
        return $filteredArr->toArray();
    }

    public function clearFileHistory($historyId)
    {
        $file = collect($this-> getFileHistory());
        $filteredFile = $file->where('id', $historyId);
        
        if($filteredFile->count() > 0){
            unlink($this->filePath);
            $filteredFile = $file->whereNotIn('id', $historyId);
            foreach($filteredFile as $data){
                $this->writeHistoryFile((new CalculatorEntityBuilder())
                                        ->setCommand($data['command'])
                                        ->setDescription($data['description'])
                                        ->setResult($data['result'])
                                        ->setOutput($data['output'])
                                        ->Build(),
                                        $data['id']
                                    );
            }
        }  
    }

    public function writeHistoryFile($command,$id)
    {
        $txt = sprintf("%s|%s|%s|%s|%s|%s.\r\n", 
                            $id,
                            $command->getCommand(), 
                            $command->getDescription(),
                            $command->getResult(),
                            $command->getOutput(),
                            date('Y-m-d H:i:s')
                    );
        file_put_contents($this->filePath, $txt, FILE_APPEND);
    }
}