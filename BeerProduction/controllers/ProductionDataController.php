<?php

class ProductionDataController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        $productionData = $this->model('ProductionData')->getProductionData();
        $viewbag['AcceptableProducts'] = $productionData->AcceptableProducts;
        $viewbag['ActualMachineSpeed'] = $productionData->ActualMachineSpeed;
        $viewbag['Barley'] = $productionData->Barley;
        $viewbag['BatchID'] = $productionData->BatchID;
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

        $this->view('home/productionData', $viewbag);
    }

    public function getProductionData()
    {
        $productionData = $this->model('ProductionData')->getProductionData();
        $this->model('BatchReport')->insertEnvironmentalLog($productionData);
        $this->model('BatchReport')->updateStateLog($productionData);
        echo json_encode($productionData);
    }
}