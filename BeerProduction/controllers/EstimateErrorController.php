<?php

class EstimateErrorController extends Controller
{
    public function index()
    {
        //initial page data
        $productType = 0; //pilsner
        $viewbag['machineSpeed'] = 400;
        $viewbag['estimatedError'] = $this->model('EstimateError')->estimateErrorFunction($productType, $viewbag['machineSpeed']);
        $viewbag['maxSpeed'] = 600;
        $this->view('EstimateError/EstimateError', $viewbag);
    }

    public function getMaxSpeed($productType)
    {
        if ($this->get()) {
            echo $this->model('EstimateError')->getMaxSpeed($productType);
        }
    }


    public function estimateErrorFunction($productType, $machineSpeed)
    {
        if ($this->get()) {
            echo $this->model('EstimateError')->estimateErrorFunction($productType, $machineSpeed);
        }
    }
}
