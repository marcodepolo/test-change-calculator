<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Model\Change;
use AppBundle\Calculator\Mk1Calculator;
use PHPUnit\Framework\TestCase;

class Mk1CalculatorTest extends TestCase
{
    /**
     * @var CalculatorInterface
     */
    private $calculator;

    protected function setUp()
    {
        $this->calculator = new Mk1Calculator();
    }

    public function testGetSupportedModel()
    {
        $this->assertEquals('mk1', $this->calculator->getSupportedModel());
    }

    public function testGetChangeEasy()
    {
        $change = $this->calculator->getChange(2);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(2, $change->coin1);
    }
}