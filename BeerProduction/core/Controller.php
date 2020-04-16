<?php
class Controller
{

	public function model($model)
	{
		require_once '../BeerProduction/models/' . $model . '.php';
		return new $model();
	}

	public function view($view, $viewbag = [])
	{
		require_once '../BeerProduction/views/' . $view . '.php';
	}

	public function post()
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

	public function get()
	{
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}
}
