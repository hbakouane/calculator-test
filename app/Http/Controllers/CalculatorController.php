<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    /**
     * Numbers to execute an operation
     */
    protected int $firstNumber;
    protected int $secondNumber;

    /**
     * Execute the calculation and output the response
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(Request $request)
    {
        // Extract the necessary information to proceed with
        [$firstNumber, $operation, $secondNumber] = $this->extractData($request->get('input'));

        [$this->firstNumber, $this->secondNumber] = [$firstNumber, $secondNumber];

        // Decide which operation to execute
        switch ($operation) {
            case '+' :
                $output = $this->executeAddition();
                break;
            case '–':
                $output = $this->executeDeduction();
                break;
            case 'x':
                $output = $this->executeMultiplication();
                break;
            default:
                $output = 0.00;
        }

        return response()->json([
            'log' => [
                'first_number' => $firstNumber,
                'second_number' => $secondNumber,
                'operation' => $operation
            ],
            'output' => $output
        ]);
    }

    /**
     * Extract data from the coming request
     *
     * @param string $input
     * @return array
     */
    public function extractData(string $input)
    {
        $data = explode(' ', $input);

        return [intval($data[0]), $data[1], intval($data[2])];
    }

    /**
     * Execute the addition operation
     *
     * @return int
     */
    public function executeAddition()
    {
        return $this->firstNumber + $this->secondNumber;
    }

    /**
     * Execute the deduction operation
     *
     * @return int
     */
    public function executeDeduction()
    {
        return $this->firstNumber - $this->secondNumber;
    }

    /**
     * Execute the multiplication operation
     *
     * @return float|int
     */
    public function executeMultiplication()
    {
        return $this->firstNumber * $this->secondNumber;
    }
}
