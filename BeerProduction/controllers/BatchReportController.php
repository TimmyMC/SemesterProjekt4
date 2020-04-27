<?php

class BatchReportController extends Controller
{
    private $batchReportData;
    public function __construct()
    {
        $this->batchReportData = $this->model('BatchReport')->getBatchReportFromAPI();
    }
    public function index()
    {
        $viewbag['BatchID'] = $this->batchReportData->BatchID;
        $viewbag['BatchSize'] = $this->batchReportData->BatchSize;
        $viewbag['ProductType'] = $this->batchReportData->ProductType;
        $viewbag['ActualMachineSpeed'] = $this->batchReportData->ActualMachineSpeed;
        $viewbag['ProducedProducts'] = $this->batchReportData->ProducedProducts;
        $viewbag['AcceptableProducts'] = $this->batchReportData->AcceptableProducts;
        $viewbag['DefectProducts'] = $this->batchReportData->DefectProducts;

        $this->view('BatchReport/BatchReport', $viewbag);
    }

    public function save()
    {
        $success = $this->model('BatchReport')->saveBatchReportToDB($this->batchReportData);
        echo 'batch report saved';
    }
}