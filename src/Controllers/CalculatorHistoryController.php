<?php

namespace Jakmall\Recruitment\Calculator\Controllers;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class CalculatorHistoryController
{
    public static function historyList(CommandHistoryManagerInterface $CommandInterface,$arrCommands,$driver)
    {
        if(empty($arrCommands)){
            return $CommandInterface->findAll($driver);
        }else{
            return $CommandInterface->findHistoryWithFilter($arrCommands,$driver);
        }
    }

    public static function clearHistory(CommandHistoryManagerInterface $CommandInterface)
    {
        return $CommandInterface->clearAll();
    }

    public static function logCalculatorHistory($CommandInterface,$CalculatorHistoryEntity) : bool
    {
        return $CommandInterface->log($CalculatorHistoryEntity);
    }

    public static function getHistoryById($CommandInterface,$historyId)
    {
        return $CommandInterface->getHistoryById($historyId);
    }

    public static function clearHistoryById($CommandInterface,$historyId)
    {
        return $CommandInterface->clearHistoryById($historyId);
    }
}