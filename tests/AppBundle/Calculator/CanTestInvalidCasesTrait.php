<?php
namespace Tests\AppBundle\Calculator;

Trait CanTestInvalidCasesTrait
{
    public function testGetChange0()
    {
        $change = $this->calculator->getChange(0);
        $this->assertNull($change);
    }

    public function testGetChangeNegative()
    {
        $change = $this->calculator->getChange(-1);
        $this->assertNull($change);
    }

    public function testGetChangeHuge()
    {
        $change = $this->calculator->getChange(10000000);
        $this->assertNull($change);
    }    

}