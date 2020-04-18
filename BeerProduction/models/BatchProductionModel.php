<?php

class BatchProductionModel
{
    public $apiURL;

    public function __construct()
    {
        $this->apiURL = "http://localhost:8001";
    }


    public function produceBatch($parameters)
    {
        $batchID = $parameters['batchID'];
        $batchProductType = $parameters['batchProductType'];
        $batchSpeed = $parameters['batchSpeed'];
        $batchSize = $parameters['batchSize'];




        $url = $this->apiURL . "/BatchParameters" . "/" . $batchProductType . "/" . $batchSpeed . "/" . $batchSize . "/" . $batchID;

        $options = array(
            'http' => array(
                'method' => 'POST'
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
    }
}