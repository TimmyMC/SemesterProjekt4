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
        $viewbag['AcceptableProducts'] = $this->batchReportData->ProducedProducts - $this->batchReportData->DefectProducts;
        $viewbag['DefectProducts'] = $this->batchReportData->DefectProducts;

        $this->view('BatchReport/BatchReport', $viewbag);
    }

    public function saveBatchReport()
    {
        $this->batchReportData = $this->model('BatchReport')->getBatchReportFromAPI();
        $this->model('BatchReport')->saveBatchReportToDB($this->batchReportData);
    }
    public function update()
    {
        $this->batchReportData = $this->model('ProductionData')->getProductionData();
        $this->model('BatchReport')->updateBatchReportToDB($this->batchReportData);
        echo 'batch report updated';
    }
}