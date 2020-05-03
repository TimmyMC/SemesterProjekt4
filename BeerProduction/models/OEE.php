<?php

class ProductionData
{

    public function getOEEData()
    {
        $OEEDatafromDB = getOEEDatafromDB();
        $OEEData = calculateTotalOEE($OEEDatafromDB);

        return $OEEData;
    }

    
    private function getOEEDatafromDB(){
        $result = array();
        
        $sql = "";

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':XX', $XX);
       

        //Execute the statement.
        $stmt->execute();
        
        while ($OEEData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[]= array(
                'data1'=>$OEEData['data1'],
                
            );
            return $result;
        }
    }

    private function calculateTotalOEE($data){

        $OEEList = array();
        foreach ($data as $key => $value)
            {
                $OEE;
                if ( $key['ProducedProducts']== 0)
                {
                    $OEE = 0;
                }
                else
                {
                    //Calcualate Quality
                    $quality = CalculateQuality(b);
                    //Calculate Availability
                    $availability = CalculateAvailability(b);
                    //Calculate Performance
                    $performance = CalculatePerformance(b);
                    

                    //Finally Calculate OEE
                    $OEE = CalculateOEE($quality, $availability, $performance);
                }
                array_push($OEEList, $OEE);
            }
            
            $averageOEE = array_sum($OEEList)/count($OEEList);
            return $averageOEE;
            
            
    }

    

    private function calculateOEE($quality, $availability, $performance){

        $OEE = $quality * $availability * $performance;
        return $OEE;

    }

    private function calculateQuality($data){

        //quality = acceptableProducts / producedProducts
    }

    private function calculateAvailability($data){
        //availability = (runtime - downtime)/ runtime
    }

    private function calculatePerformance($data){
        
        //IdealCycleTime = 60 / productMaxSpeed

        //Performance = (IdealCycleTime * producedProducts) / runtime
    }
}
