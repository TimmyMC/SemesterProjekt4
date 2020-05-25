<?php

class OEE extends Database
{
    public function getOEEData($currentBatchIDData)
    {
        $currentBatchID = $currentBatchIDData;
        $dataPilsner = $this->calculateTotalOEE($this->getOEEDatafromDB(0), 600, $currentBatchID);
        $dataWheat = $this->calculateTotalOEE($this->getOEEDatafromDB(1), 300, $currentBatchID);
        $dataIpa = $this->calculateTotalOEE($this->getOEEDatafromDB(2), 150, $currentBatchID);
        $dataStout = $this->calculateTotalOEE($this->getOEEDatafromDB(3), 200, $currentBatchID);
        $dataAle = $this->calculateTotalOEE($this->getOEEDatafromDB(4), 100, $currentBatchID);
        $dataAlcoholFree = $this->calculateTotalOEE($this->getOEEDatafromDB(5), 125, $currentBatchID);

        $OEEData = array(
            'Pilsner' => round(($dataPilsner) * 100, 2),
            'Wheat' => round(($dataWheat) * 100, 2),
            'Ipa' => round(($dataIpa) * 100, 2),
            'Stout' => round(($dataStout) * 100, 2),
            'Ale' => round(($dataAle) * 100, 2),
            'AlcoholFree' => round(($dataAlcoholFree) * 100, 2)
        );

        return $OEEData;
    }

    private function getOEEDatafromDB($productType)
    {
        $sql = "SELECT batch_id, batch_size, produced_products, defect_products, production_speed FROM batch_report WHERE product_type=:product_type;";

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':product_type', $productType);

        //Execute the statement.
        $stmt->execute();



        if ($stmt->rowcount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else
            $result[] = array(
                'batch_id' => 0,
                'batch_size' => 0,
                'produced_products' => 0,
                'defect_products' => 0,
                'production_speed' => 0
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

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = array(
                'batch_id' => $data['batch_id'],
                'deactivated_state' => $data['deactivated_state'],
                'clearing_state' => $data['clearing_state'],
                'stopped_state' => $data['stopped_state'],
                'starting_state' => $data['starting_state'],
                'idle_state' => $data['idle_state'],
                'suspended_state' => $data['suspended_state'],
                'execute_state' => $data['execute_state'],
                'stopped_state' => $data['stopped_state'],
                'aborting_state' => $data['aborting_state'],
                'aborted_state' => $data['aborted_state'],
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

            $acceptableProducts = $batchReport['produced_products'];

            if ($acceptableProducts == 0) {
                $OEE = 0;
                $unusedBatchReportsCount++;
            }
            //key batch id is equal to current batch ID
            elseif ($batchReport['batch_id'] == $currentBatchID) {
                $OEE = 0;
                $unusedBatchReportsCount++;
            } else {
                $batchID = $batchReport['batch_id'];
                $stateLogData = $this->getStateLogData($batchID);

                foreach ($stateLogData as $stateLog) {
                    //calculate runtime from start time and end time NOT AVAILABLE
                    $plannedProductionTime = array_sum($stateLog) - $batchReport['batch_id'];

                    //calculate downtime from statelogs NOT AVAILABLE
                    $downtime = $plannedProductionTime - $stateLog['execute_state'];
                    $runtime = $stateLog['execute_state'];

                    //Calcualate Quality
                    $quality = $this->CalculateQuality($batchReport['produced_products'], $batchReport['defect_products']);
                    //Calculate Availability
                    $availability = $this->CalculateAvailability($plannedProductionTime, $downtime);
                    //Calculate Performance
                    $totalProducts = $batchReport['produced_products'];
                    $performance = $this->CalculatePerformance($MaxProductionSpeed, $totalProducts, $runtime);

                    //Finally Calculate OEE
                    $OEE = $this->CalculateOEE($quality, $availability, $performance);
                }
            }
            array_push($OEEList, $OEE);
        }

        if (count($OEEList) == 0) {
            $averageOEE = 0;
        } elseif ((count($OEEList) - $unusedBatchReportsCount) == 0) {
            $averageOEE = 0;
        } else {
            $averageOEE = array_sum($OEEList) / (count($OEEList) - $unusedBatchReportsCount);
        }
        return $averageOEE;
    }

    private function calculateOEE($quality, $availability, $performance)
    {
        $OEE = $quality * $availability * $performance;

        return $OEE;
    }

    private function calculateQuality($produced_products, $defectProducts)
    {
        $acceptableProducts = $produced_products - $defectProducts;
        $quality = $acceptableProducts / $produced_products;

        return $quality;
    }

    private function calculateAvailability($plannedProductionTime, $downtime)
    {
        $availability = ($plannedProductionTime - $downtime) / $plannedProductionTime;

        return $availability;
    }

    private function calculatePerformance($MaxProductionSpeed, $totalProducts, $runtime)
    {
        $IdealCycleTime =  60 / $MaxProductionSpeed;

        $performance = ($IdealCycleTime * $totalProducts) / $runtime;

        return $performance;
    }
}
