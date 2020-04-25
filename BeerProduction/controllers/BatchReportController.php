<?php

class BatchReportController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        $batchReportData = $this->model('BatchReport')->getBatchReportFromAPI();
        $viewbag['BatchID'] = $batchReportData->BatchID;
        $viewbag['BatchSize'] = $batchReportData->BatchSize;
        $viewbag['ActualMachineSpeed'] = $batchReportData->ActualMachineSpeed;
        $viewbag['ProducedProducts'] = $batchReportData->ProducedProducts;
        $viewbag['AcceptableProducts'] = $batchReportData->AcceptableProducts;
        $viewbag['DefectProducts'] = $batchReportData->DefectProducts;
        
        $this->view('BatchReport/BatchReport', $viewbag);
    }

    public function save($batchReportData){
        $success = $this->model('BatchReport')->saveBatchReportToDB($batchReportData);

    }
}
