<?php

declare(strict_types=1);

namespace AppBundle\Registry;

use AppBundle\Calculator\CalculatorInterface;

interface CalculatorRegistryInterface
{
    /**
     * @param string $model Indicates the model of automaton
     *
     * @return CalculatorInterface|null The calculator, or null if no CalculatorInterface supports that model
     */
    public function getCalculatorFor(string $model): ?CalculatorInterface;
}
