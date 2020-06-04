<?php

namespace Jakmall\Recruitment\Calculator\Controllers;

class CalculatorController
{
    static function generateCalculationDescription(array $numbers, string $operator): string
    {
        $glue = sprintf(' %s ',  $operator);
        return implode($glue, $numbers);
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