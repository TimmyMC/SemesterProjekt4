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
        $data = $batchReport_data;
        $Batch_id = $data->BatchID;
        $Product_type = $data->ProductType;
        $Batch_size = $data->BatchSize;
        $Acceptable_products = $data->AcceptableProducts;
        $Defect_products = $data->DefectProducts;
        $Production_speed = $data->ActualMachineSpeed;

        $sql = "UPDATE Batch_reports
                SET Product_type = :Product_type,
                Batch_size = :Batch_size,
                Acceptable_products = :Acceptable_products,
                Defect_products = :Defect_products,
                Production_speed = :Production_speed
                WHERE Batch_id = :Batch_id;";

        $sql2 = "INSERT INTO Batch_reports
                (Batch_id, Product_type, Batch_size, Acceptable_products, Defect_products, Production_speed)
                SELECT
                :Batch_id, :Product_type, :Batch_size, :Acceptable_products, :Defect_products, :Production_speed
                WHERE NOT EXISTS (SELECT 1 FROM Batch_reports WHERE Batch_id=:Batch_id);";


        $stmt = $this->conn->prepare($sql);
        $stmt2 = $this->conn->prepare($sql2);

        //Bind our variables.
        $stmt->bindValue(':Batch_id', $Batch_id);
        $stmt->bindValue(':Product_type', $Product_type);
        $stmt->bindValue(':Batch_size', $Batch_size);
        $stmt->bindValue(':Acceptable_products', $Acceptable_products);
        $stmt->bindValue(':Defect_products', $Defect_products);
        $stmt->bindValue(':Production_speed', $Production_speed);
        $stmt2->bindValue(':Batch_id', $Batch_id);
        $stmt2->bindValue(':Product_type', $Product_type);
        $stmt2->bindValue(':Batch_size', $Batch_size);
        $stmt2->bindValue(':Acceptable_products', $Acceptable_products);
        $stmt2->bindValue(':Defect_products', $Defect_products);
        $stmt2->bindValue(':Production_speed', $Production_speed);

        //Execute the statement and insert the new user account.
        $stmt->execute();
        $stmt2->execute();
        return;
    }
}
