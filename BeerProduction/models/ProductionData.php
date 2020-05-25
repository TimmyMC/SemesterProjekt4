<?php

class ProductionData
{

    //https://tutorialsclass.com/learn/php/php-rest-api/php-rest-api-file_get_contents
    public function getProductionData()
    {
        $api_url = 'http://localhost:8001/data';
        $json_data = @file_get_contents($api_url);
        if ($json_data === false) { //return null on connection failure
            return null;
        } else {
            $production_data = json_decode($json_data, true);
            return $production_data;
        }
    }
}
