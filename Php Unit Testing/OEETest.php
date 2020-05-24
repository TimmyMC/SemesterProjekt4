<?php
class OEE
{
    public function calculateOEE($quality, $availability, $performance)
    {
        $OEE = $quality * $availability * $performance;
        return $OEE;
    }

    public function calculateQuality($produced_products, $defectProducts)
    {
        $acceptableProducts = $produced_products - $defectProducts;
        $quality = $acceptableProducts / $produced_products;

        return $quality;
    }

    public function calculateAvailability($plannedProductionTime, $downtime)
    {
        $availability = ($plannedProductionTime - $downtime) / $plannedProductionTime;

        return $availability;
    }

    public function calculatePerformance($MaxProductionSpeed, $totalProducts, $runtime)
    {
        $IdealCycleTime =  60 / $MaxProductionSpeed;

        $performance = ($IdealCycleTime * $totalProducts) / $runtime;

        return $performance;
    }
}

class OEETest extends PHPUnit\Framework\TestCase
{
    private $oee;

    protected function setUp(): void
    {
        $this->oee = new OEE();
    }

    public function testCalculateOEE()
    {
        //require '../BeerProduction/Models/OEE.php';
        //$oee = new OEE();

        $this->assertEquals(0.45, $this->oee->calculateOEE(1, 0.9, 0.5));
    }

    public function testAvailability()
    {

        $this->assertEquals(0.5, $this->oee->calculateAvailability(10, 5));
    }

    public function testQuality()
    {
        $this->assertEquals(0.5, $this->oee->calculateQuality(10, 5));
    }

    public function testPerformance()
    {
        $this->assertEquals(1, $this->oee->calculatePerformance(60, 10, 10));
    }
}