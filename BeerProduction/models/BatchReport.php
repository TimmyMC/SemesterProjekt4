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
        $data = $batchReport_data;
        $Batch_id = $data->BatchID;
        $Product_type = $data->ProductType;
        $Batch_size = $data->BatchSize;
        $Acceptable_products = $data->AcceptableProducts;
        $Defect_products = $data->DefectProducts;
        $Production_speed = $data->ActualMachineSpeed;

        $sql = "INSERT INTO Batch_reports
                (Batch_id, Product_type, Batch_size, Acceptable_products, Defect_products, Production_speed)
                VALUES
                (:Batch_id, :Product_type, :Batch_size, :Acceptable_products, :Defect_products, :Production_speed)";
                /*           
                ON CONFLICT (batch_id) 
                DO 
                        UPDATE
                SET Product_type = excluded.Product_type,
                Batch_size = excluded.Batch_size,
                Acceptable_products = excluded.Acceptable_products,
                Defect_products = excluded.Defect_products,
                Production_speed = excluded.:Production_speed"; 
                */

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':Batch_id', $Batch_id);
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
