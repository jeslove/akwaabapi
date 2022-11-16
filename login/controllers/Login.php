<?php

use core\Forms\Forms;
use interfaces\Data\Processdata;
use resources\Loginresources\Loginresources;

class Login extends Loginresources implements Processdata{

	public function create()
	{
		if(Forms::isPost()){

			$fields = json_decode(file_get_contents("php://input"));

			$email = filter_var($fields->email,FILTER_VALIDATE_EMAIL);

			$telephone = filter_var($fields->telephone,FILTER_DEFAULT);

			$password = filter_var($fields->password,FILTER_DEFAULT);

			$username = filter_var($fields->username,FILTER_DEFAULT);

			if(!empty($email) && !empty($telephone) && !empty($username) && !empty($password)){

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					
					echo json_encode(['status'=>'error','response'=>"Invalid email format."]);
					exit;
				}

				if (!preg_match("/^[a-zA-Z-' ]*$/",$username)) {

					echo json_encode(['status'=>'error','response'=>"Only letters and white space allowed."]);
					exit;
				}

				if(!filter_var($telephone, FILTER_SANITIZE_NUMBER_INT)){

					echo json_encode(['status'=>'error','response'=>"Invalid phone number format."]);
					exit;
				}

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
