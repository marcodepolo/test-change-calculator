<?php

declare(strict_types=1);

namespace AppBundle\Registry;

use AppBundle\Calculator\CalculatorInterface;

class CalculatorRegistry implements CalculatorRegistryInterface
{
    private $calculators;

    /** calculators are injected automatically (see config/services.yml) */
    public function __construct(iterable $calculators)
    {
        $this->calculators = $calculators;
    }

    /**
     * @param string $model Indicates the model of automaton
     *
     * @return CalculatorInterface|null The calculator, or null if no CalculatorInterface supports that model
     */
    public function getCalculatorFor(string $model): ?CalculatorInterface
    {
        //return the first calculator that can handle this model
        foreach ($this->calculators as $calculator) {
            if ($calculator->getSupportedModel() === $model) {
                return $calculator;
            }
        }

        return null;
    }
}
