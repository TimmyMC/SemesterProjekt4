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

    public function updateBatchReportToDB($data)
    {
        $Batch_id = $data->CurrentBatchID;
        $Produced_products = $data->ProducedProducts;
        $Defect_products = $data->DefectProducts;



        $sql = "UPDATE Batch_reports
                SET Produced_products = :Produced_products,
                Defect_products = :Defect_products
                WHERE Batch_id = :Batch_id";

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':Batch_id', $Batch_id);
        $stmt->bindValue(':Produced_products', $Produced_products);
        $stmt->bindValue(':Defect_products', $Defect_products);

        //Execute the statement and insert the new user account.
        $stmt->execute();
        return;
    }

    private function createStateLog($id)
    {
        $sql = "INSERT INTO state_log
        (Batch_id, Deactivated_state, Clearing_state, Stopped_state, Starting_state, Idle_state, Suspended_state, Execute_state, Stopping_state, Aborting_state, Abort_state, Holding_state, Held_state, Resetting_state, Completing_state, Completed_state, Deactive_state, Activating_state)
        VALUES
        (:Batch_id,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':Batch_id', $id);

        $stmt->execute();
        return;
    }
    
    public function saveBatchReportToDB($data)
    {
        $Product_type = $data['batchProductType'];
        $Batch_size = $data['batchSize'];
        $Produced_products = 0;
        $Defect_products = 0;
        $Production_speed = $data['batchSpeed'];
        $sql = "INSERT INTO Batch_reports
                (Product_type, Batch_size, Produced_products, Defect_products, Production_speed, start_time)
                SELECT
                :Product_type, :Batch_size, :Produced_products, :Defect_products, :Production_speed, now();";


        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':Product_type', $Product_type);
        $stmt->bindValue(':Batch_size', $Batch_size);
        $stmt->bindValue(':Produced_products', $Produced_products);
        $stmt->bindValue(':Defect_products', $Defect_products);
        $stmt->bindValue(':Production_speed', $Production_speed);

        $stmt->execute();
        $batchID = $this->conn->lastInsertId();
        print_r($batchID);
        $this->createStateLog($batchID);
        return $batchID;
    }

    public function insertEnvironmentalLog($data)
    {
        $humidity = $data->Humidity;
        $temperature = $data->Temperature;
        $vibration = $data->Vibration;

        $sql = "INSERT INTO Environmental_log
                (Batch_id, Temperature, Humidity, vibration, log_time)
                Values((SELECT MAX(Batch_id) FROM Batch_reports), :Temperature, :Humidity, :Vibration, now());";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':Humidity', $humidity);
        $stmt->bindValue(':Temperature', $temperature);
        $stmt->bindValue(':Vibration', $vibration);


        $stmt->execute();
        return;
    }

    public function updateStateLog($data)
    {
        $state = $this->findState($data->CurrentState);

        $sql = "UPDATE State_log
        SET $state = $state + 0.5
        WHERE Batch_id = (SELECT MAX(Batch_id) FROM Batch_reports);";

        $stmt = $this->conn->prepare($sql);

        //$stmt->bindValue(':currentState', $state);

        $stmt->execute();
        return;
    }

    private function findState($state)
    {
        switch ($state) {
            case 0:
                return "Deactivated_state";
            case 1:
                return "Clearing_state";
            case 2:
                return "Stopped_state";
            case 3:
                return "Startint_state";
            case 4:
                return "Idle_state";
            case 5:
                return "Suspended_state";
            case 6:
                return "Execute_state";
            case 7:
                return "Stopping_state";
            case 8:
                return "Aborting_state";
            case 9:
                return "Aborted_state";
            case 10:
                return "Holding_state";
            case 11:
                return "Held_state";
            case 15:
                return "Resetting_state";
            case 16:
                return "Completing_state";
            case 17:
                return "Completed_state";
            case 18:
                return "Deactivating_state";
            case 19:
                return "Activating_state";
            default:
                break;
        }
    }
}
