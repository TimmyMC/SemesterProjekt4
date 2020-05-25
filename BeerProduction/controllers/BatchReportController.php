<?php

class BatchReportController extends Controller
{
    public function index()
    {
        $this->view('BatchReport/BatchReport');
    }

    public function updateBatchReport()
    {
        $batchReportData = $_SESSION['productionData'];
        if (!empty($_SESSION['productionData'])) { // checks for api/machine connection
            $this->model('BatchReport')->updateBatchReportToDB($batchReportData);
        }
    }

    public function updateLogs()
    {
        if (!empty($_SESSION['productionData'])) { // checks for api/machine connection
            $this->model('BatchReport')->insertEnvironmentalLog($_SESSION['productionData']);
        }
        $this->model('BatchReport')->updateStateLog($_SESSION['productionData']);   //always want to save a state log, it saves to deactivated state when there is no connection.
    }

    public function getBatchReports()
    {
        $batchReportData = $this->model('BatchReport')->getBatchReportListFromDB();
        foreach ($batchReportData as &$batchReport) {
            $batchID = $batchReport['batch_id'];
            $batchReport['stateLog'] = $this->model('BatchReport')->getStateLogFromDB($batchID);
            $batchReport['environmentalLog'] = $this->model('BatchReport')->getEnvironmentalLogFromDB($batchID);
        }
        echo json_encode($batchReportData);
    }
}
