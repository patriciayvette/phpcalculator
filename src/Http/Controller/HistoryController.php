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

    public function index(CommandHistoryManagerInterface $CommandInterface)
    {
        $arrCommand = array();
        $data = CalculatorHistoryController::historyList($CommandInterface,$arrCommand,static::DATA_DRIVER);
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

    public function show()
    {
        //dd('create show history by id here');
    }

    public function remove()
    {
        // todo: modify codes to remove history
        //dd('create remove history logic here');
    }
}
