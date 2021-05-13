<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

/**
 * Calculate the optimum change using dynamic programming
 * since the coin changing problem has both optimal substructure and overlapping subproblems
 * this implementation is inspired from https://www.codesdope.com/course/algorithms-coin-change/
 */
class DPAlgorithm
{
    /** avoid breaking memory for very big amounts */
    const MAX_AMOUNT = 100000;

    /** available set of coins/bills for this model */
    private $availableCoins = [];

    public function __construct(array $availableCoins)
    {
        $this->availableCoins = $availableCoins;
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        // amount must be greater than 0
        // and must be greater than or equal to the smallest coin available
        if ($amount <= 0
            || $amount < min($this->availableCoins)
            || $amount > self::MAX_AMOUNT) {
            return null;
        }

        $nbDenominations = count($this->availableCoins);

        // build a new set by inserting a "0" coin in the list
        $setOfCoins = array_merge([0], $this->availableCoins);

        $subValues = $this->buildSubValues($amount, $setOfCoins, $nbDenominations);

        return $this->buildChange($amount, $setOfCoins, $subValues);
    }

    /**
     * map the first coin needed to each int value between 1 and amount (subValues)
     */
    private function buildSubValues(int $amount, array $setOfCoins, int $nbDenominations): array
    {
        $minNbCoins = [];
        // for 0 value no coins needed
        $minNbCoins[0] = 0;

        $subValues = [];
        $subValues[0] = 0;

        // store the minimum number of coins needed and the first selectedCoinIndex for each subValue
        for ($subValue = 1; $subValue <= $amount; $subValue++) {
            $minimum = PHP_INT_MAX;
            $selectedCoinIndex = 0;

            for ($coinIndex = 1; $coinIndex <= $nbDenominations; $coinIndex++) {
                if ($subValue >= $setOfCoins[$coinIndex]
                    && (1 + $minNbCoins[$subValue - $setOfCoins[$coinIndex]]) < $minimum) {
                    $minimum = 1 + $minNbCoins[$subValue - $setOfCoins[$coinIndex]];
                    $selectedCoinIndex = $coinIndex;
                }
            }
            $minNbCoins[$subValue] = $minimum;
            $subValues[$subValue] = $selectedCoinIndex;
        }

        return $subValues;
    }

    /**
     * use subValues array to pick each coin of the optimum solution and build the change object
     */
    private function buildChange(int $amount, array $setOfCoins, array $subValues): ?Change
    {
        $change = new Change();

        $remainingAmount = $amount;
        while ($remainingAmount > 0) {
            $coinValue = $setOfCoins[$subValues[$remainingAmount]];
            switch ($coinValue) {
                case 10:
                    $change->bill10++;
                    break;
                case 5:
                    $change->bill5++;
                    break;
                case 2:
                    $change->coin2++;
                    break;
                case 1:
                    $change->coin1++;
                    break;
                default:
                    // in case the last coin needed is not available in the set, impossible to make change
                    return null;
            }
            $remainingAmount -= $coinValue;
        }

        return $change;
    }
}
