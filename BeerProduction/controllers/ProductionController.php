<?php

class ProductionController extends Controller
{
    public function index()
    {
        //initial page data
        $productType = 0; //pilsner
        $viewbag['machineSpeed'] = 400;
        $viewbag['estimatedError'] = $this->model('EstimateError')->estimateErrorFunction($productType, $viewbag['machineSpeed']);
        $viewbag['maxSpeed'] = 600;

        $this->view('home/production', $viewbag);
    }

    public function getProductionData()
    {
        $guiProductionData = $this->model('ProductionData')->getProductionData();
        $_SESSION['productionData'] = $guiProductionData;
        $guiProductionData['CurrentState'] = $this->model('BatchReport')->findState($guiProductionData['CurrentState']);
        echo json_encode($guiProductionData);
    }

    public function produceBatch()
    {
        if ($this->post()) {
            $parameters = array(
                'batchProductType' => $_POST['batchProductType'],
                'batchSpeed' => $_POST['batchSpeed'],
                'batchSize' => $_POST['batchSize']
            );

            $latestBatchID = $this->model('BatchReport')->saveBatchReportToDB($parameters);
            $parameters['batchID'] = $latestBatchID;
            $this->model('BatchProductionModel')->produceBatch($parameters);

            return $latestBatchID;
        }
    }

    public function getMaxSpeed($productType)
    {
        if ($this->get()) {
            echo $this->model('EstimateError')->getMaxSpeed($productType);
        }
    }

    public function estimateErrorFunction($productType, $machineSpeed)
    {
        if ($this->get()) {
            echo $this->model('EstimateError')->estimateErrorFunction($productType, $machineSpeed);
        }
    }

    public function getOptimalSpeed($productType)
    {
        if ($this->get()) {
            echo $this->model('EstimateError')->getOptimalSpeed($productType);
        }
    }

    public function stopBatch()
    {
        $this->model('BatchProductionModel')->stopBatch();
    }

    public function abortBatch()
    {
        $this->model('BatchProductionModel')->abortBatch();
    }
}
