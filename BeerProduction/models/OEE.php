<?php

class ProductionData
{
    private $batchSize;
    private $acceptableProducts;
    private $defectProducts;
    private $productionSpeed;
    private $totalProducts;
    private $runtime;

    private $dataPilsner;
    private $dataWheat;
    private $dataIpa;
    private $dataStout;
    private $dataAle;
    private $dataAlcoholFree;

    public function getOEEData()
    {

        $this->dataPilsner=calculateTotalOEE(getOEEDatafromDB(1),600);
        $this->dataWheat=calculateTotalOEE(getOEEDatafromDB(2),300);
        $this->dataIpa=calculateTotalOEE(getOEEDatafromDB(3),150);
        $this->dataStout=calculateTotalOEE(getOEEDatafromDB(4),200);
        $this->dataAle=calculateTotalOEE(getOEEDatafromDB(5),100);
        $this->dataAlcoholFree=calculateTotalOEE(getOEEDatafromDB(6),125);
        
        $OEEData = array(
            'Pilsner'=>$this->dataPilsner,
            'Wheat'=>$this->dataWheat,
            'Ipa'=>$this->dataIpa,
            'Stout'=>$this->dataStout,
            'Ale'=>$this->dataAle,
            'AlcoholFree'=>$this->dataAlcoholFree
    );
        return $OEEData;
    }


    private function getOEEDatafromDB($productType)
    {
        $sql = "SELECT batch_size, acceptable_products, defect_products, production_speed FROM batch_reports WHERE product_type=:product_type";

        // Mangler Availability = runtime / Planned production time. (runtime = plannedProductionTime - downTime)"
        // Mangler Performance = (IdealCycleTime x totalCount) / run time. 

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':product_type', $this->productType);

        //Execute the statement.
        $stmt->execute();

        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
        
    }

    private function calculateTotalOEE($data, $MaxProductionSpeed)
    {

        $OEEList = array();
        foreach ($data as $key => $value) {
            $OEE;
            if ($key['ProducedProducts'] == 0) {
                $OEE = 0;
            } else {
                //Calcualate Quality
                $quality = CalculateQuality($key['Acceptable_products'],$key[ 'Defect_products']);
                //Calculate Availability
                $runtime;//calculate runtime from start time and end time NOT AVAILABLE
                $downtime;//calculate downtime from statelogs NOT AVAILABLE
                $availability = CalculateAvailability($runtime, $downtime);
                //Calculate Performance
                $totalProducts=$key['Acceptable_products']+$key[ 'Defect_products'];
                $performance = CalculatePerformance($MaxProductionSpeed, $totalProducts, $runtime);

                //Finally Calculate OEE
                $OEE = CalculateOEE($quality, $availability, $performance);
            }
            array_push($OEEList, $OEE);
        }

        $averageOEE = array_sum($OEEList) / count($OEEList);
        return $averageOEE;
    }

    private function calculateOEE($quality, $availability, $performance)
    {

        $OEE = $quality * $availability * $performance;
        return $OEE;
    }

    private function calculateQuality($acceptableProducts, $defectProducts)
    {
        $producedProducts = $acceptableProducts + $defectProducts;
        $quality = $acceptableProducts / $producedProducts;

        return $quality;
    }

    private function calculateAvailability($runtime, $downtime)
    {
        $availability = ($runtime - $downtime)/ $runtime;

        return $availability;

    }

    private function calculatePerformance($MaxProductionSpeed, $totalProducts, $runtime)
    {

        $IdealCycleTime =  60/$MaxProductionSpeed;

        $performance = ($IdealCycleTime * $totalProducts) / $runtime;

        return $performance;
    }
}
