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
        $url = 'http://localhost:8001';
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));

        $options = array(
            'http' => array(
                'method' => 'POST'
            )
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
          ]);

        $response = curl_exec($curl);

        curl_close($curl);

        echo $response . PHP_EOL;
    }
}
