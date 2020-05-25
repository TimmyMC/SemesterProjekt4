<?php

class EstimateError
{
    public function getMaxSpeed($productType)
    {
        switch ($productType) {
            case 0:
                return 600;
                break;
            case 1:
                return 300;
                break;
            case 2:
                return 150;
                break;
            case 3:
                return 200;
                break;
            case 4:
                return 100;
                break;
            case 5:
                return 125;
                break;
        }
    }

    public function estimateErrorFunction($productType, $machineSpeed)
    {
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
        return round($estimatedError, 2) . "%";
    }

    public function getOptimalSpeed($productType)
    {
        $optimalSpeed = 0;
        switch ($productType) {
            case 0:
                $optimalSpeed = 460;
                break;
            case 1:
                $optimalSpeed = 150;
                break;
            case 2:
                $optimalSpeed = 105;
                break;
            case 3:
                $optimalSpeed = 200;
                break;
            case 4:
                $optimalSpeed = 90;
                break;
            case 5:
                $optimalSpeed = 112;
                break;
        }
        return json_encode(array(
            "optimalSpeed" => $optimalSpeed,
            "estimatedError" => $this->estimateErrorFunction($productType, $optimalSpeed)
        ));
    }
}
