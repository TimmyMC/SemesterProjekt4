<?php

class OEE extends Database
{
    private $currentBatchID;

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

    public function getOEEData($currentBatchIDData)
    {
        $currentBatchID = $currentBatchIDData;
        $this->dataPilsner=$this->calculateTotalOEE($this->getOEEDatafromDB(1), 600);
        $this->dataWheat=$this->calculateTotalOEE($this->getOEEDatafromDB(2), 300);
        $this->dataIpa=$this->calculateTotalOEE($this->getOEEDatafromDB(3), 150);
        $this->dataStout=$this->calculateTotalOEE($this->getOEEDatafromDB(4), 200);
        $this->dataAle=$this->calculateTotalOEE($this->getOEEDatafromDB(5), 100);
        $this->dataAlcoholFree=$this->calculateTotalOEE($this->getOEEDatafromDB(6), 125);
        
        $OEEData['Pilsner'] = $this->dataPilsner;
        $OEEData['Wheat'] = $this->dataWheat;
        $OEEData['Ipa'] = $this->dataIpa;
        $OEEData['Stout'] = $this->dataStout;
        $OEEData['Ale'] = $this->dataAle;
        $OEEData['AlcoholFree'] = $this->dataAlcoholFree;
       
        return $OEEData;
    }

    

    private function getOEEDatafromDB($productType)
    {
        $sql = "SELECT batch_id, batch_size, acceptable_products, defect_products, production_speed FROM batch_reports WHERE product_type=:product_type;";

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':product_type', $productType);

        //Execute the statement.
        $stmt->execute();

        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    private function getStateLogData($batchID)
    {
        // state_logs?
        $sql = "SELECT * FROM state_log WHERE batch_id=:batchID";

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':batchID', $batchID);

        //Execute the statement.
        $stmt->execute();

        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    private function calculateTotalOEE($data, $MaxProductionSpeed)
    {
        $OEEList = array();
        $unusedBatchReportsCount = 0;
        foreach ($data as $key => $value) {
            $OEE;
            if ($key['acceptable_products'] == 0) {
                $OEE = 0;
                $unusedBatchReportsCount++;
            }
            //key batch id is equal to current batch ID
            elseif ($key['batch_id']==$currentBatchID) {
                $OEE = 0;
                $unusedBatchReportsCount++;
            } else {
                
                
                
                /////////////////////////////////////////////////////////////////////
                $batchID = $key['batch_id'];
                $stateLogData = getStateLogData($batchID);
                
                //calculate runtime from start time and end time NOT AVAILABLE
                $plannedProductionTime = array_sum($stateLogData)-$key['batch_id'];
                
                //calculate downtime from statelogs NOT AVAILABLE
                $downtime = $plannedProductionTime-$stateLogData['execute_state'];
                $runtime = $stateLogData['execute_state'];
                /////////////////////////////////////////////////////////////////////





                //Calcualate Quality
                $quality = CalculateQuality($key['acceptable_products'], $key[ 'defect_products']);
                //Calculate Availability
                $availability = CalculateAvailability($plannedProductionTime, $downtime);
                //Calculate Performance
                $totalProducts=$key['acceptable_products']+$key[ 'defect_products'];
                $performance = CalculatePerformance($MaxProductionSpeed, $totalProducts, $runtime);

                //Finally Calculate OEE
                $OEE = CalculateOEE($quality, $availability, $performance);
            }
            array_push($OEEList, $OEE);
        }

        if (count($OEEList)==0) {
            $averageOEE = 0;
        } else {
            $averageOEE = array_sum($OEEList) / (count($OEEList)-$unusedBatchReportsCount);
            return $averageOEE;
        }
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

    private function calculateAvailability($plannedProductionTime, $downtime)
    {
        $availability = ($plannedProductionTime - $downtime)/ $plannedProductionTime;

        return $availability;
    }

    private function calculatePerformance($MaxProductionSpeed, $totalProducts, $runtime)
    {
        $IdealCycleTime =  60/$MaxProductionSpeed;

        $performance = ($IdealCycleTime * $totalProducts) / $runtime;

        return $performance;
    }
}
