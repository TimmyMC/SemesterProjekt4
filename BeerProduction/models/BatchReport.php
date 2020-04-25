<?php

class BatchReport extends Database
{
    public function getBatchReportFromAPI()
    {
        $api_url = 'http://localhost:8001/batchReport';

        $json_data = file_get_contents($api_url);

        $batchReport_data = json_decode($json_data);

        return $batchReport_data;
    }

    public function saveBatchReportToDB($batchReport_data)
    {
        $save_attempt = false;

        $data = $batchReport_data; //Use this data to extract all parameters
        //Extract parameters here
        //id
        //type
        //size
        //accept
        //defect
        //speed

        $sql = "INSERT INTO Batch_reports
                (Batch_id, Product_type, Batch_size, Acceptable_products, Defect_products, Production_speed)
                VALUES
                (:Batch_id, :Product_type, :Batch_size, :Acceptable_products, :Defect_products, :Production_speed)
                ON DUPLICATE KEY UPDATE
                Product_type = :Product_type,
                Batch_size = :Batch_size,
                Acceptable_products = :Acceptable_products,
                Defect_products = :Defect_products,
                Production_speed = :Production_speed";

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':Product_type', $Product_type);
        $stmt->bindValue(':Batch_size', $Batch_size);
        $stmt->bindValue(':Acceptable_products', $Acceptable_products);
        $stmt->bindValue(':Defect_products', $Defect_products);
        $stmt->bindValue(':Production_speed', $Production_speed);

        //Execute the statement and insert the new user account.
        $result = $stmt->execute();
        
        if ($result) {
            $register_attempt = true;
            return $save_attempt;
        } else {
            //If there was a problem with the INSERT query, alert the user and redirect back to registration page.
            return $save_attempt;
        }
    }
}
