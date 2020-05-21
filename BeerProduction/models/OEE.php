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
        $this->dataPilsner=$this->calculateTotalOEE($this->getOEEDatafromDB(0), 600, $currentBatchID);
        $this->dataWheat=$this->calculateTotalOEE($this->getOEEDatafromDB(1), 300, $currentBatchID);
        $this->dataIpa=$this->calculateTotalOEE($this->getOEEDatafromDB(2), 150, $currentBatchID);
        $this->dataStout=$this->calculateTotalOEE($this->getOEEDatafromDB(3), 200, $currentBatchID);
        $this->dataAle=$this->calculateTotalOEE($this->getOEEDatafromDB(4), 100, $currentBatchID);
        $this->dataAlcoholFree=$this->calculateTotalOEE($this->getOEEDatafromDB(5), 125, $currentBatchID);
        
        $OEEData= array(
            'Pilsner' => $this->dataPilsner,
            'Wheat' => $this->dataWheat,
            'Ipa' => $this->dataIpa,
            'Stout' => $this->dataStout,
            'Ale' => $this->dataAle,
            'AlcoholFree' => $this->dataAlcoholFree
        );
       
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

        if ($stmt->rowcount()> 0) {
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result = array();
                $result[]= array(
                'batch_id'=>$data['batch_id'],
                'batch_size' => $data['batch_size'],
                'acceptable_products'=>$data['acceptable_products'],
                'defect_products'=>$data['defect_products'],
                'production_speed'=>$data['production_speed']
            );
            }
        }
        $result[]= array(
            'batch_id'=>0,
            'batch_size' =>0,
            'acceptable_products'=>0,
            'defect_products'=>0,
            'production_speed'=>0
        );

        return $result;
    }

    private function getStateLogData($batchID)
    {
        $result = array();
        // state_logs?
        $sql = "SELECT * FROM state_log WHERE batch_id=:batchID";

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':batchID', $batchID);

        //Execute the statement.
        $stmt->execute();

        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[]= array(
                'batch_id'=>$data['batch_id'],
                'deactivated_state' => $data['deactivated_state'],
                'clearing_state' => $data['clearing_state'],
                'stopped_state' => $data['stopped_state'],
                'starting_state' => $data['starting_state'],
                'idle_state' => $data['idle_state'],
                'suspended_state' => $data['suspended_state'],
                'execute_state' => $data['execute_state'],
                'stopped_state' => $data['stopped_state'],
                'aborting_state' => $data['aborting_state'],
                'abort_state' => $data['abort_state'],
                'holding_state' => $data['holding_state'],
                'held_state' => $data['held_state'],
                'resetting_state' => $data['resetting_state'],
                'completing_state' => $data['completing_state'],
                'completed_state' => $data['completed_state'],
                'deactive_state' => $data['deactive_state'],
                'activating_state' => $data['activating_state']
              
            );
        }

        return $result;
    }

    private function calculateTotalOEE($data, $MaxProductionSpeed, $currentBatchID)
    {
        $OEEList = array();
        $unusedBatchReportsCount = 0;
        $OEE = 0;
        foreach ($data as $batchReport) {
            $OEE;
            $acceptableProducts =$batchReport['acceptable_products'];
            
            if ($acceptableProducts == 0) {
                $OEE = 0;
                $unusedBatchReportsCount++;
            }
            //key batch id is equal to current batch ID
            elseif ($batchReport['batch_id']==$currentBatchID) {
                $OEE = 0;
                $unusedBatchReportsCount++;
            } else {
                
                
                
                /////////////////////////////////////////////////////////////////////
                $batchID = $batchReport['batch_id'];
                $stateLogData = $this->getStateLogData($batchID);
                
                foreach ($stateLogData as $stateLog) {
                    //calculate runtime from start time and end time NOT AVAILABLE
                    $plannedProductionTime = array_sum($stateLog)-$batchReport['batch_id'];
                
                    //calculate downtime from statelogs NOT AVAILABLE
                    $downtime = $plannedProductionTime-$stateLog['execute_state'];
                    $runtime = $stateLog['execute_state'];
                    /////////////////////////////////////////////////////////////////////





                    //Calcualate Quality
                    $quality = $this->CalculateQuality($batchReport['acceptable_products'], $batchReport[ 'defect_products']);
                    //Calculate Availability
                    $availability = $this->CalculateAvailability($plannedProductionTime, $downtime);
                    //Calculate Performance
                    $totalProducts=$batchReport['acceptable_products']+$batchReport[ 'defect_products'];
                    $performance = $this->CalculatePerformance($MaxProductionSpeed, $totalProducts, $runtime);

                    //Finally Calculate OEE
                    $OEE = $this->CalculateOEE($quality, $availability, $performance);
                }
            }
            array_push($OEEList, $OEE);
        }
        
        
        
        if (count($OEEList)==0) {
            $averageOEE = 0;
        } elseif ((count($OEEList)-$unusedBatchReportsCount)==0) {
            $averageOEE = 0;
        } else {
            $averageOEE = array_sum($OEEList) / (count($OEEList)-$unusedBatchReportsCount);
        }
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
