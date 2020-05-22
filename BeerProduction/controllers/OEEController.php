<?php

class OEEController extends Controller
{

    public function __construct()
    {
    }
    
    public function index()
    {
        //$productionData = $this->model('ProductionData')->getProductionData();
        //$currentBatchID = $productionData->BatchID;
        $currentBatchID = 123;
        $viewbag = $this->model('OEE')->getOEEData($currentBatchID);
        //$OEEData = 0;
        $this->view('BatchReport/OEE', $viewbag);
    }
}
