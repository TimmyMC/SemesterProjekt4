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

   private $errorMaxSpeed;
   

   protected function setUp(): void
   {
      $this->estimateError = new EstimateError();

      $this->productType = [
         "Pilsner" => 0,
         "Wheat" => 1,
         "Ipa" => 2,
         "Stout" => 3,
         "Ale" => 4,
         "AlcoholFree" => 5
      ];

      $this->productTypeSpeed = [
         "Pilsner" => 600,
         "Wheat" => 300,
         "Ipa" => 150,
         "Stout" => 200,
         "Ale" => 100,
         "AlcoholFree" => 125
      ];

      $this->errorMaxSpeed = [
         "Pilsner" => "54.578091067865 %",
         "Wheat" => '99.79%',
         "Ipa" => '100%',
         "Stout" => '11.8%',
         "Ale" => '36.13%',
         "AlcoholFree" => '59.32%'
      ];
   }



   public function testGetMaxSpeed()
   {

      $this->assertEquals(
         $this->estimateError->getMaxSpeed(
            $this->productType["Pilsner"]
         ),
         $this->productTypeSpeed["Pilsner"]
      );

      $this->assertEquals(
         $this->estimateError->getMaxSpeed(
            $this->productType["Wheat"]
         ),
         $this->productTypeSpeed["Wheat"]
      );

      $this->assertEquals(
         $this->estimateError->getMaxSpeed(
            $this->productType["Ipa"]
         ),
         $this->productTypeSpeed["Ipa"]
      );

      $this->assertEquals(
         $this->estimateError->getMaxSpeed(
            $this->productType["Stout"]
         ),
         $this->productTypeSpeed["Stout"]
      );

      $this->assertEquals(
         $this->estimateError->getMaxSpeed(
            $this->productType["Ale"]
         ),
         $this->productTypeSpeed["Ale"]
      );

      $this->assertEquals(
         $this->estimateError->getMaxSpeed(
            $this->productType["AlcoholFree"]
         ),
         $this->productTypeSpeed["AlcoholFree"]
      );
   }

   public function testEstimateErrorFunction()
   {

      $this->assertEquals(
         $this->estimateError->estimateErrorFunction(
            $this->productType["Pilsner"],
            $this->productTypeSpeed["Pilsner"]
         ),
         $this->errorMaxSpeed["Pilsner"]
      );

      $this->assertEquals(
         $this->estimateError->estimateErrorFunction(
            $this->productType["Wheat"],
            $this->productTypeSpeed["Wheat"]
         ),
         $this->errorMaxSpeed["Wheat"]
      );

      $this->assertEquals(
         $this->estimateError->estimateErrorFunction(
            $this->productType["Ipa"],
            $this->productTypeSpeed["Ipa"]
         ),
         $this->errorMaxSpeed["Ipa"]
      );

      $this->assertEquals(
         $this->estimateError->estimateErrorFunction(
            $this->productType["Stout"],
            $this->productTypeSpeed["Stout"]
         ),
         $this->errorMaxSpeed["Stout"]
      );

      $this->assertEquals(
         $this->estimateError->estimateErrorFunction(
            $this->productType["Ale"],
            $this->productTypeSpeed["Ale"]
         ),
         $this->errorMaxSpeed["Ale"]
      );

      $this->assertEquals(
         $this->estimateError->estimateErrorFunction(
            $this->productType["AlcoholFree"],
            $this->productTypeSpeed["AlcoholFree"]
         ),
         $this->errorMaxSpeed["AlcoholFree"]
      );
   }
}
