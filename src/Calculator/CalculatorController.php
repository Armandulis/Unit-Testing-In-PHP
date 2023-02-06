<?php


namespace App\Calculator;

use App\Models\ScientificCalculator;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class CalculatorController
 * @package App\Calculator
 */
class CalculatorController
{
    /**
     * CalculatorController constructor.
     * @param ScientificCalculator $scientificCalculator
     */
    public function __construct(private ScientificCalculator $scientificCalculator)
    {
    }

    /**
     * DivideInput divides two provided numbers and returns the result
     * @param int $inputOne
     * @param int $inputTwo
     * @return int
     * @throws \Exception
     */
    public function divideInput(int $inputOne, int $inputTwo): int
    {
        // Make sure input two is not 0
        if ($inputTwo === 0) {

            // If it is, throw exception
            throw new \Exception('Cannot divide from 0');
        }

        $result = $inputOne / $inputTwo;

        $filesystem = new Filesystem();
        // Save to a local file
        if ($filesystem->exists('calculator-answers')) {
            $filesystem->appendToFile('calculator-answers', $result);
        } else {
            // If file calculator-answers doesn't exists, save it to a new file called 'answers'
          $filesystem->appendToFile('answers', $result);
        }

        // Return the division result
        return $result;
    }

    /**
     * Saves the square root result under provided subject
     * @param string $subject
     * @param int $number
     * @param array $multiplications
     * @return array<bool>
     */
    public function saveMultiplicationSequence(string $subject, int $number, array $multiplications): array
    {
        $result = 1;
        $savedResult = [];
        // Multiply number with multiplications array and save it
        foreach ($multiplications as $multiplication) {
            $result = $result * $multiplication;
            $savedResult[] = $this->scientificCalculator->saveSubject($subject, $result);
        }

        return $savedResult;
    }

    /**
     * Saves the calculation if provided inputs are medium size (between 3 and 10)
     * Returns false if the result was not saved
     * @param string $subject
     * @param int $inputOne
     * @param int $inputTwo
     * @return bool
     */
    public function saveMediumResultSubject(string $subject, int $inputOne, int $inputTwo): bool
    {
        // If input is higher than 10 or lower than 4, don't save it, because it's not medium
        if (($inputOne > 10 && $inputTwo > 10) || ($inputOne <= 4 && $inputTwo <= 4)) {
            return false;
        }

        // Make the calculation
        $result = $this->scientificCalculator->calculateSize($inputOne, $inputTwo);

        // Save the result
        return $this->scientificCalculator->saveSubject($subject, $result);
    }

    /**
     * Calculates the multiplication of the input and constants under the given scope
     * @param string $scope
     * @param int $input
     * @return int
     */
    public function calculateMultiplicationWithConstants(string $scope, int $input): int
    {
        // Get the constants
        $constants = ScientificCalculator::getConstants($scope);
        $result = $input;

        // Do the calculations and return the result
        foreach ($constants as $constant) {
            $result *= $constant;
        }

        return $result;
    }

    /**
     * @param string $subject
     * @param int $number
     * @return string|null
     */
    public function savesSquareResultAsJson( string $subject, int $number): ?string
    {
        $result = $number * $number;
        $json = '{"result": "' . $result . '"}';

        try {
           $this->scientificCalculator->saveSubjectJson( $subject, $json);
        }
        catch ( \Exception $e ){
            return null;
        }

        return $json;
    }
}
