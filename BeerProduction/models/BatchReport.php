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

    public function updateBatchReportToDB($batchReport_data)
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

        $stmt = $this->conn->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':Batch_id', $Batch_id);
        $stmt->bindValue(':Product_type', $Product_type);
        $stmt->bindValue(':Batch_size', $Batch_size);
        $stmt->bindValue(':Acceptable_products', $Acceptable_products);
        $stmt->bindValue(':Defect_products', $Defect_products);
        $stmt->bindValue(':Production_speed', $Production_speed);

        //Execute the statement and insert the new user account.
        $stmt->execute();
        return;
    }
    public function saveBatchReportToDB($data)
    {
        $Batch_id = $data['batchID'];
        $Product_type = $data['batchProductType'];
        $Batch_size = $data['batchSize'];
        $Acceptable_products = 0;
        $Defect_products = 0;
        $Production_speed = $data['batchSpeed'];

        $sql = "INSERT INTO Batch_reports
                (Batch_id, Product_type, Batch_size, Acceptable_products, Defect_products, Production_speed)
                SELECT
                :Batch_id, :Product_type, :Batch_size, :Acceptable_products, :Defect_products, :Production_speed
                WHERE NOT EXISTS (SELECT 1 FROM Batch_reports WHERE Batch_id=:Batch_id);";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':Batch_id', $Batch_id);
        $stmt->bindValue(':Product_type', $Product_type);
        $stmt->bindValue(':Batch_size', $Batch_size);
        $stmt->bindValue(':Acceptable_products', $Acceptable_products);
        $stmt->bindValue(':Defect_products', $Defect_products);
        $stmt->bindValue(':Production_speed', $Production_speed);

        $stmt->execute();
        return;
    }

    public function insertEnvironmentalLog($data)
    {
        $humidity = $data->humidity;
        $temperature = $data->temperature;
        $vibration = $data->vibration;

        $sql = "INSERT INTO Environmental_log
                (Batch_id, Temperature, Humidity, vibration, log_time)
                Values((SELECT MAX(Batch_id FROM Batch_reports), :temperature, :humidity, :vibration, now());";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':humidity', $humidity);
        $stmt->bindValue(':temperature', $temperature);
        $stmt->bindValue(':vibration', $vibration);


        $stmt->execute();
        return;
    }

    public function updateStateLog($data)
    {
        $state = $this->findState($data->StateCurrent);

        $sql = "UPDATE State_log
        SET :currentState = :currentState + 0.5
        WHERE Batch_id = (SELECT MAX(Batch_id) FROM Batch_reports);";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':currentState', $state);

        $stmt->execute();
        return;
    }

    private function findState($state)
    {
        switch ($state) {
            case 0:
                return "Deactivated_state";
                break;
            case 1:
                return "Clearing_state";
                break;
            case 2:
                return "Stopped_state";
                break;
            case 3:
                echo "Startint_state";
                break;
            case 4:
                return "Idle_state";
                break;
            case 5:
                return "Suspended_state";
                break;
            case 6:
                return "Execute_state";
                break;
            case 7:
                return "Stopping_state";
                break;
            case 8:
                return "Aborting_state";
                break;
            case 9:
                return "Aborted_state";
                break;
            case 10:
                return "Holding_state";
                break;
            case 11:
                return "Held_state";
                break;
            case 15:
                return "Resetting_state";
                break;
            case 16:
                return "Completing_state";
                break;
            case 17:
                return "Complete_state";
                break;
            case 18:
                return "Deactivating_state";
                break;
            case 19:
                return "Activating_state";
                break;
            default:
                echo "shite";
        }
    }
}