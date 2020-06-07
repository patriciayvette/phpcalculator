<?php

namespace Jakmall\Recruitment\Calculator\Controllers;

use Jakmall\Recruitment\Calculator\Entities\CalculatorEntity;
use Jakmall\Recruitment\Calculator\Entities\EntitiesBuilder\CalculatorEntityBuilder;

class CalculatorController
{
    private static $operators = array (
                                "add" => "+",
                                "substract" => "-",
                                "multiply" => "*",
                                "divide" => "/",
                                "pow" => "^"
                            ); 
    static function generateCalculationDescription(array $numbers, string $operator): string
    {
        $glue = sprintf(' %s ',  $operator);
        return implode($glue, $numbers);
    }

    static function getCalulatorResult($numbers,$command): CalculatorEntity
    {
        if($command == 'pow' & count($numbers) > 2){
            $numbers = array($numbers[0],$numbers[1]);
        }
        $description = self::generateCalculationDescription($numbers,self::$operators[$command]);
        $result = self::getCalculationResult($numbers,self::$operators[$command]);
        $output = self::getConsoleOutput($description,$result);

        $calculatorEntity = (new CalculatorEntityBuilder())
        ->setCommand($command)
        ->setDescription($description)
        ->setResult($result)
        ->setOutput($output)
        ->Build();

        return $calculatorEntity;
    }

    static function getConsoleOutput($description, $result) : string
    {
        return sprintf('%s = %s', $description, $result);
    }

    static function getCalculationResult($numbers,$operator)
    {
        if($operator != self::$operators['pow']){
            return self::calculateAll($numbers,$operator);
        }else{
            return pow($numbers[0],$numbers[1]);
        }
    }

    /**
     * @param array $numbers
     * @param string $operator
     *
     * @return float|int
     */
    static function calculateAll(array $numbers,string $operator)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }
        return self::calculate(self::calculateAll($numbers, $operator), $number, $operator);
    }

     /**
     * @param int|float $number1
     * @param int|float $number2
     * @param string $operator
     *
     * @return int|float
     */
    static function calculate($number1, $number2, $operator)
    {
        if($operator == '+'){
            return $number1 + $number2;
        } elseif($operator == '-'){
            return $number1 - $number2;
        } elseif($operator == '*'){
            return $number1 * $number2;
        } elseif($operator == '/'){
            return $number1 / $number2;
        }
    }
}