<?php

class ProductionData
{

    public function getProductionData()
    {

        $api_url = 'http://localhost:8001/data';

        // Read JSON file
        $json_data = file_get_contents($api_url);

        $production_data = json_decode($json_data);

        return $production_data;

//https://tutorialsclass.com/learn/php/php-rest-api/php-rest-api-file_get_contents
    }
}
