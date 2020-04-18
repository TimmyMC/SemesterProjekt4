<?php

    class BatchProductionModel
    {
        private $apiURL;
        
        public function __construct()
        {
            $apiURL = "http://localhost:8001";
        }


        public function produceBatch($parameters)
        {
            $batchID = $parameters['batchID'];
            $batchProductType = $parameters['batchProductType'];
            $batchSpeed = $parameters['batchSpeed'];
            $batchSize = $parameters['batchSize'];




            $url = $apiURL . "/BatchParameters" . "/" . $batchProductType . "/" . $batchSpeed . "/" . $batchSize . "/" . $batchID;

            $client = curl_init($url);
            
            $options = array(
                'http' => array(
                    'method' => 'POST'
                )
                );
            
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
        }
    }
