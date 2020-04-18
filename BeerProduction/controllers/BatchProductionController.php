<?php

class BatchProductionController extends Controller
{
    public function index($param)
    {
        $this->view('BatchProduction/BatchProductionView');

        echo '<h2>Test Index</h2>';
    }

    public function produceBatch()
    {
        $parameters = array(
            'batchID' => $_POST['batchID'],
            'batchProductType' => $_POST['batchProductType'],
            'batchSpeed' => $_POST['batchSpeed'],
            'batchSize' => $_POST['batchSize']
        );

        $this->model('BatchProductionModel')->produceBatch($parameters);

        echo '<h2>Data Sent</h2>';
    }
}
