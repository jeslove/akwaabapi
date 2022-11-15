<?php

use interfaces\Data\Processdata;

class Setup implements Processdata{

	public function create()
	{
		echo json_encode(['status'=>'ok','response'=>'Yes Setup working']);
	}

	public function update()
	{
		
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