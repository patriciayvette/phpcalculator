<?php

namespace Jakmall\Recruitment\Calculator\History\Service;

use PDO;
use Exception;
use Jakmall\Recruitment\Calculator\Connection;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Repositories\CommandHistoryRepository;

class CalculatorHistoryService implements CommandHistoryManagerInterface
{
    
    protected $commandHistoryRepository;
    public function __construct()
    {
        $this->commandHistoryRepository = new CommandHistoryRepository();      
        $this->commandHistoryRepository->createHistoryTable();
    }

    /**
     * Returns array of command history.
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->commandHistoryRepository->getDbHistory();
    }

    public function findHistoryWithFilter($commands): array
    {
        return $this->commandHistoryRepository->getDbHistoryWithFilter($commands);
    }
    
    public function log($command): bool
    {
        return $this->commandHistoryRepository->insertDbHistory($command->getCommand(), 
                                      $command->getDescription(), 
                                      $command->getResult(), 
                                      $command->getOutput());
    }

    public function clearAll():bool
    {
        return $this->commandHistoryRepository->deleteDbHistory();
    }    
}