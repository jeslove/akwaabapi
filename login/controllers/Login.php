<?php

use core\Forms\Forms;
use interfaces\Data\Processdata;
use resources\Loginresources\Loginresources;

class Login extends Loginresources implements Processdata{

	// #[Route('/email')]
	public function create()
	{
		if(Forms::isPost()){

			$fields = json_decode(file_get_contents("php://input"));

			if($fields && !empty($fields->username) && !empty($fields->email) && !empty($fields->telephone) && !empty($fields->password)){

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
	
					if(!is_numeric($telephone)){
	
						echo json_encode(['status'=>'error','response'=>"Invalid phone number format."]);
						exit;
					}
					
					if(strlen($telephone) < 10 || strlen($telephone) > 14){
	
						echo json_encode(['status'=>'error','response'=>"Invalid phone number length range (10-14)."]);
						exit;
					}else{return $this->createPost($email,$telephone,$password,$username);}
	
				}
				else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid Input request.']);}
			}
			else
			{
				echo json_encode([
					'status'=>'error',
					'response'=>'Oops! Invalid Input format.',
					'data'=>'Required variable names (username,password,telephone and email)'
				]);
			}

		}else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid request.']);}
	}


	public function auth(){

		if(Forms::isPost()){

			$fields = json_decode(file_get_contents("php://input"));

			if($fields && !empty($fields->authvalue) && !empty($fields->password)){

				$authvalue = filter_var($fields->authvalue,FILTER_DEFAULT);

				$password = filter_var($fields->password,FILTER_DEFAULT);
	
				if(is_numeric($authvalue) || filter_var($authvalue,FILTER_VALIDATE_EMAIL)){
	
					return $this->authLogin($authvalue,$password);

				}
				else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid Input format.']);}
			}
	        else
			{
				echo json_encode([
					'status'=>'error',
					'response'=>'Oops! Invalid Input format.',
					'data'=>'Required variable names (authvalue and password)'
				]);
			}
		}
		else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid request.']);}
	}

	public function updates()
	{
		
	}

	public function view()
	{
		
	}

	public function show()
	{
		return $this->testing();
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
