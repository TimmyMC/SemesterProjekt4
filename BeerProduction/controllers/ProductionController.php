<?php

class ProductionController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $productionData = $this->model('ProductionData')->getProductionData();
        $viewbag['AcceptableProducts'] = $productionData->ProducedProducts - $productionData->DefectProducts;
        $viewbag['ActualMachineSpeed'] = $productionData->ActualMachineSpeed;
        $viewbag['Barley'] = $productionData->Barley;
        $viewbag['BatchID'] = $productionData->CurrentBatchID;
        $viewbag['BatchSize'] = $productionData->BatchSize;
        $viewbag['CurrentState'] = $productionData->CurrentState;
        $viewbag['DefectProducts'] = $productionData->DefectProducts;
        $viewbag['Hops'] = $productionData->Hops;
        $viewbag['Humidity'] = $productionData->Humidity;
        $viewbag['MaintainenceMeter'] = $productionData->MaintainenceMeter;
        $viewbag['Malt'] = $productionData->Malt;
        $viewbag['ProducedProducts'] = $productionData->ProducedProducts;
        $viewbag['Temperature'] = $productionData->Temperature;
        $viewbag['Vibration'] = $productionData->Vibration;
        $viewbag['Wheat'] = $productionData->Wheat;
        $viewbag['Yeast'] = $productionData->Yeast;

        //initial page data
        $productType = 0; //pilsner
        $viewbag['machineSpeed'] = 400;
        $viewbag['estimatedError'] = $this->model('EstimateError')->estimateErrorFunction($productType, $viewbag['machineSpeed']);
        $viewbag['maxSpeed'] = 600;


        $this->view('home/production', $viewbag);

        // $this->view('BatchProduction/BatchProductionView');

        // $this->view('EstimateError/EstimateError', $viewbag);
    }

    public function getProductionData()
    {
        $_SESSION['productionData'] = $this->model('ProductionData')->getProductionData();
        echo json_encode($_SESSION['productionData']);
    }

    public function logUpdate()
    {
        $this->model('BatchReport')->insertEnvironmentalLog($_SESSION['productionData']);
        $this->model('BatchReport')->updateStateLog($_SESSION['productionData']);
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
}
