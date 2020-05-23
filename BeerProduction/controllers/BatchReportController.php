<?php

class BatchReportController extends Controller
{
    public function index()
    {
        $this->view('BatchReport/BatchReport');
    }

    public function saveBatchReport()
    {
        $batchReportData = $this->model('BatchReport')->getBatchReportFromAPI();
        $this->model('BatchReport')->saveBatchReportToDB($this->batchReportData);
    }

    public function update()
    {
        $batchReportData = $this->model('ProductionData')->getProductionData();
        $this->model('BatchReport')->updateBatchReportToDB($this->batchReportData);
        echo 'batch report updated';
    }

    public function getBatchReports()
    {
        $batchReportData = $this->model('BatchReport')->getBatchReportListFromDB();
        echo json_encode($batchReportData);
    }

    public function getStateLog($batchID)
    {
        if ($this->get()) {
            $stateLogData = $this->model('BatchReport')->getStateLogFromDB($batchID);

            //$stateLogData = array("Something");
            echo json_encode($stateLogData);
        }
    }

    public function getEnvironmentalLog($batchID)
    {
        if ($this->get()) {
            $environmentalLogData = $this->model('BatchReport')->getEnvironmentalLogFromDB($batchID);

            //$stateLogData = array("Something");
            echo json_encode($environmentalLogData);
        }
    }
}
