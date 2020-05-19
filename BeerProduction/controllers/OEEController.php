<?php

class OEEController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        $productionData = $this->model('ProductionData')->getProductionData();
        $currentBatchID = $productionData->BatchID;
        $OEEData = $this->model('OEE')->getOEEData($currentBatchID);
        $this->view('BatchReport/OEE', $OEEData);
    }
}
