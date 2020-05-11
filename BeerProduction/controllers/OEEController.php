<?php

class OEEController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        $OEEData = $this->model('OEE')->getOEEData();
        $this->view('BatchReport/OEE', $OEEData);
    }
}
