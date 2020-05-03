<?php

class ProductionData
{
    public function getOEEData()
    {
        $OEEDatafromDB = getOEEDatafromDB();
        $OEEData = calculateTotalOEE($OEEDatafromDB);

        return $OEEData;
    }


    private function getOEEDatafromDB()
    {
        $batchSize = "";
        $productType = "";
        $acceptableProducts = "";
        $defectProducts = "";
        $productionSpeed = "";
        $totalProducts = $acceptableProducts + $defectProducts;
        $runtime="";

        $result = array();

        $sql = "SELECT batch_size, product_type, acceptable_products, defect_products, production_speed FROM batch_reports";

        // Mangler Availability = runtime / Planned production time. (runtime = plannedProductionTime - downTime)"
        // Mangler Performance = (IdealCycleTime x totalCount) / run time. 

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':batch_size', $batchSize);
        $stmt->bindValue(':product_type', $productType);
        $stmt->bindValue(':acceptable_products', $acceptableProducts);
        $stmt->bindValue(':defect_products', $defectProducts);
        $stmt->bindValue(':production_speed', $productionSpeed);

        //Execute the statement.
        $stmt->execute();

        while ($OEEData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = array(
                'data1' => $OEEData['data1'],

            );
            return $result;
        }
    }

    private function calculateTotalOEE($data)
    {

        $OEEList = array();
        foreach ($data as $key => $value) {
            $OEE;
            if ($key['ProducedProducts'] == 0) {
                $OEE = 0;
            } else {
                //Calcualate Quality
                $quality = CalculateQuality($acceptableProducts, $defectProducts);
                //Calculate Availability
                $availability = CalculateAvailability(b);
                //Calculate Performance
                $performance = CalculatePerformance($productionSpeed, $totalProducts, $runtime);


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
    }

    private function calculateAvailability($data)
    {
        //availability = (runtime - downtime)/ runtime
    }

    private function calculatePerformance($productionSpeed, $totalProducts, $runtime)
    {

        $IdealCycleTime =  $productionSpeed/ 60;

        $Performance = ($IdealCycleTime * $totalProducts) / $runtime;
    }
}
