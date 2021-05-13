<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

class Mk1Calculator implements CalculatorInterface
{
    const SUPPORTED_MODEL = 'mk1';

    private $algorithm;

    public function __construct()
    {
        $this->algorithm = new DPAlgorithm([1]);
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedModel(): string
    {
        return self::SUPPORTED_MODEL;
    }

    /**
     * {@inheritdoc}
     */
    public function getChange(int $amount): ?Change
    {
        return $this->algorithm->getChange($amount);
    }
}
