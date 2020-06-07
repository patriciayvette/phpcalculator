<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorHistoryController;
use Jakmall\Recruitment\Calculator\Entities\Response\CalculationResponseEntity;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Controllers\CalculatorController as CalculatorBaseController;

class CalculatorController extends Controller
{
    private $commandInterface;

    public function __construct(CommandHistoryManagerInterface $commandInterface)
    {
        $this->commandInterface = $commandInterface;
    }

    public function calculate($action)
    {
        $jsonRequestBody = file_get_contents('php://input');
        $input = json_decode($jsonRequestBody, TRUE);
        $result = CalculatorBaseController::getCalulatorResult($input['input'],$action);
        CalculatorHistoryController::logCalculatorHistory($this->commandInterface,$result);
        $response = new CalculationResponseEntity($result->getCommand(),
                                                  $result->getDescription(),
                                                  $result->getResult());
        return new JsonResponse($response->jsonSerialize());
    }
}
