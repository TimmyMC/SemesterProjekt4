<?php

class OEEController extends Controller
{
    public function index()
    {
        $productionData = $this->model('ProductionData')->getProductionData();
        $currentBatchID = $productionData['CurrentBatchID'];
        echo json_encode($this->model('OEE')->getOEEData($currentBatchID));
    }
}
