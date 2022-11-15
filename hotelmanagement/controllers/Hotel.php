<?php

use interfaces\Data\Processdata;

class Hotel implements Processdata{

	public function create()
	{
		echo json_encode(['status'=>'ok','response'=>'Yes Hotel class is working']);
	}

	public function update()
	{
		echo json_encode(['status'=>'ok','response'=>'Yes Hotel class update is working']);
	}

	public function view()
	{
		
	}

	public function show()
	{
		
	}

	public function edit()
	{
		
	}

	public function patch()
	{
		
	}

	public function delete()
	{
		
	}
}