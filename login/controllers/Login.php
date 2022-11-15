<?php

use core\Forms\Forms;
use interfaces\Data\Processdata;
use resources\Loginresources\Loginresources;

class Login extends Loginresources implements Processdata{

	public function create()
	{
		if(Forms::isPost()){

			$fields = json_decode(file_get_contents("php://input"));

			$email = Forms::sanitize($fields->email);

			$telephone = Forms::sanitize($fields->telephone);

			$password = Forms::sanitize($fields->password);

			return $this->createPost($email,$telephone,$password);

		}else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid request.']);}
	}

	public function updates()
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

	public function item($item){
		echo json_encode(['status'=>'ok','response'=>'Yes am working','data'=>$item]);
	}
}
