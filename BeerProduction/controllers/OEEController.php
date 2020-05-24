<?php

class OEEController extends Controller
{
    public function index()
    {
        $productionData = $_SESSION['productionData'];
        $currentBatchID = $productionData['BatchID'];
        echo json_encode($this->model('OEE')->getOEEData($currentBatchID));
    }
}
