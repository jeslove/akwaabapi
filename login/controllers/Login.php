<?php

use core\Forms\Forms;
use interfaces\Data\Processdata;
use resources\Loginresources\Loginresources;

class Login extends Loginresources implements Processdata{

	public function create()
	{
		if(Forms::isPost()){

			$fields = json_decode(file_get_contents("php://input"));

			$email = Forms::get($fields->email);

			$telephone = Forms::get($fields->telephone);

			$password = Forms::get($fields->password);

			$username = Forms::get($fields->username);

			if(!empty($email) && !empty($telephone) && !empty($username) && !empty($password)){

				return $this->createPost($email,$telephone,$password,$username);
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid Input request.']);}

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
