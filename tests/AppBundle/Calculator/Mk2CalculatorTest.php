<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Model\Change;
use AppBundle\Calculator\Mk2Calculator;
use PHPUnit\Framework\TestCase;

class Mk2CalculatorTest extends TestCase
{
    /**
     * @var CalculatorInterface
     */
    private $calculator;

    protected function setUp()
    {
        $this->calculator = new Mk2Calculator();
    }

    public function testGetSupportedModel()
    {
        $this->assertEquals('mk2', $this->calculator->getSupportedModel());
    }

    public function testGetChangeEasy()
    {
        $change = $this->calculator->getChange(2);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->coin2);
    }

    public function testGetChangeImpossible()
    {
        $change = $this->calculator->getChange(1);
        $this->assertNull($change);
    }
}