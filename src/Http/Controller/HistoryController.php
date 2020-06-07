<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Jakmall\Recruitment\Calculator\Entities\Response\HistoryResponseEntity;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorHistoryController;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class HistoryController extends Controller
{
    protected const DATA_DRIVER = 'database';
    private $commandInterface;

    public function __construct(CommandHistoryManagerInterface $commandInterface)
    {
        $this->commandInterface = $commandInterface;
    }

    public function index()
    {
        $arrCommand = array();
        $data = CalculatorHistoryController::historyList($this->commandInterface,$arrCommand,static::DATA_DRIVER);
        if(empty($data)){
            $response = 'History is empty';
        }else{
            foreach ($data as $key => $row) {
                preg_match_all('!\d+(?:\.\d+)?!', $row['description'], $numbers);
                $response[] = 
                    new HistoryResponseEntity($row['id'],
                                              $row['command'],
                                              $row['description'],
                                              $numbers[0],
                                              $row['result'],
                                              $row['time']
                    );
            } 
        }       
        return new JsonResponse($response);
    }

    public function show($historyId)
    {
        $data = CalculatorHistoryController::getHistoryById($this->commandInterface,$historyId);
        if(empty($data)){
            $response = 'History is empty';
        }else{
            preg_match_all('!\d+(?:\.\d+)?!', $data[0]['description'], $numbers);
            $response = 
                    new HistoryResponseEntity($data[0]['id'],
                                              $data[0]['command'],
                                              $data[0]['description'],
                                              $numbers[0],
                                              $data[0]['result'],
                                              $data[0]['time']
                    );
        }
        return new JsonResponse($response);
    }

    public function remove($historyId)
    {
        CalculatorHistoryController::clearHistoryById($this->commandInterface,$historyId);
        return new JsonResponse(null,'204');
    }
}
