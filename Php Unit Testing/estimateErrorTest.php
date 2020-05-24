<?php


class EstimateError
{
    public function getMaxSpeed($productType)
    {
        switch ($productType) {
            case 0:
                return 600;
                break;
            case 1:
                return 300;
                break;
            case 2:
                return 150;
                break;
            case 3:
                return 200;
                break;
            case 4:
                return 100;
                break;
            case 5:
                return 125;
                break;
        }
    }

    public function estimateErrorFunction($productType, $machineSpeed)
    {
        $estimatedError = 0;
        switch ($productType) {
            case 0:
                $estimatedError = 0.113 * exp(0.0103 * $machineSpeed) . " ";
                break;
            case 1:
                $estimatedError = 0.336 * $machineSpeed - 1.01;
                break;
            case 2:
                $estimatedError = 35.1 - 1.35 * $machineSpeed + 0.0122 * $machineSpeed ** 2;
                break;
            case 3:
                $estimatedError = 43 + 0.124 * $machineSpeed - 0.0014 * $machineSpeed ** 2;
                break;
            case 4:
                $estimatedError = 1.29 - 0.0706 * $machineSpeed + 0.00419 * $machineSpeed ** 2;
                break;
            case 5:
                $estimatedError = 0.402 * $machineSpeed + 9.07;
                break;
        }
        if ($estimatedError < 0) {
            $estimatedError =  0;
        } else if ($estimatedError > 100) {
            $estimatedError = 100;
        }
        return $estimatedError . "%";
    }
}



class estimateErrorTest extends PHPUnit\Framework\TestCase
{
   private $estimateError;

   private $productType;
   private $productTypeSpeed;

   protected function setUp():void{
      $this->estimateError = new EstimateError();

      $this->productType = [
         "Pilsner"=>0,
         "Wheat"=>1,
         "Ipa"=>2,
         "Stoud"=>3,
         "Ale"=>4,
         "AlcoholFree"=>5
      ];

      $this->productTypeSpeed = [
         "Pilsner"=>600,
         "Wheat"=>300,
         "Ipa"=>150,
         "Stoud"=>200,
         "Ale"=>100,
         "AlcoholFree"=>125
      ];
   }

   

   public function testGetMaxSpeed(){
      
      

      $pilsner = array(0, 600);
      $wheat = array(1, 300);
      $ipa = array(2, 150);
      $stout = array(3, 200);
      $ale = array(4, 100);
      $alcoholFree = array(5, 125);

      
      $this->assertEquals($this->estimateError->getMaxSpeed($pilsner[0]), $pilsner[1]);
      $this->assertEquals($this->estimateError->getMaxSpeed($wheat[0]), $wheat[1]);
      $this->assertEquals($this->estimateError->getMaxSpeed($ipa[0]), $ipa[1]);
      $this->assertEquals($this->estimateError->getMaxSpeed($stout[0]), $stout[1]);
      $this->assertEquals($this->estimateError->getMaxSpeed($ale[0]), $ale[1]);
      $this->assertEquals($this->estimateError->getMaxSpeed($alcoholFree[0]), $alcoholFree[1]);


   }

   public function testEstimateErrorFunction(){
      

      $pilsner = array(0, 600);
      $wheat = array(1, 300);
      $ipa = array(2, 150);
      $stout = array(3, 200);
      $ale = array(4, 100);
      $alcoholFree = array(5, 125);
   }
}
?>