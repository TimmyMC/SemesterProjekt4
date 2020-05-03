<?php

class EstimateErrorController extends Controller
{
    public function index()
    {
        // initial data
        $viewbag['maxSpeed'] = 600;
        $this->view('EstimateError/EstimateError', $viewbag);
    }

    //TODO data is hardcoded...
    public function getMaxSpeed($productType)
    {
        if ($this->get()) {
            switch ($productType) {
                case 0:
                    echo 600;
                    break;
                case 1:
                    echo 300;
                    break;
                case 2:
                    echo 150;
                    break;
                case 3:
                    echo 200;
                    break;
                case 4:
                    echo 100;
                    break;
                case 5:
                    echo 125;
                    break;
            }
        }
    }


    public function estimateErrorFunction($productType, $machineSpeed)
    {
        if ($this->get()) {
            $estimatedError = 0;
            switch ($productType) {
                case 0:
                    $estimatedError = 0.113 * exp(0.0103 * $machineSpeed) . " ";
                    break;
                case 1:
                    $estimatedError = 0.336 * $machineSpeed - 1.01;
                    break;
                case 2:
                    $estimatedError = 35.1 - 1.35 * $machineSpeed + 0.0122 * $machineSpeed ** 2;
                    break;
                case 3:
                    $estimatedError = 43 + 0.124 * $machineSpeed - 0.0014 * $machineSpeed ** 2;
                    break;
                case 4:
                    $estimatedError = 1.29 - 0.0706 * $machineSpeed + 0.00419 * $machineSpeed ** 2;
                    break;
                case 5:
                    $estimatedError = 0.402 * $machineSpeed + 9.07;
                    break;
            }
            if ($estimatedError < 0) {
                $estimatedError =  0;
            } else if ($estimatedError > 100) {
                $estimatedError = 100;
            }
            echo $estimatedError . "%";
        }
    }
}
