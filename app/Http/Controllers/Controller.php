<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

abstract class Controller
{
    protected $input;
	protected $data;

	public function __construct(Request $request)
	{
//		print_r($request->all());exit;
		$this->input = $request->except(['_token']);
		$this->data = $request->except(['_token']);
	}
}
