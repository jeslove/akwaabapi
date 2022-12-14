<?php 

namespace resources\Loginresources;

use connect\TriatConnect\Traitconnnect;
use core\Auth\Auth;
use login\models\logins\Logins;

class Loginresources extends Logins{

	use Traitconnnect;

	public function __construct()
	{
		parent:: __construct();
	}

	protected function createPost($email,$telephone,$password,$username){

		if(API_KEY == $this->getHeaderpath())
		{
			$checkemaildata = $this->checkDuplicate('email',$email);

			$checktelephonedata = $this->checkDuplicate('telephone',$telephone);

			$checkusernamedata = $this->checkDuplicate('username',$username);

			if($checkemaildata){

				echo json_encode(['status'=>'error','response'=>"{$email} already exsist"]);
				exit;
			}

			if($checktelephonedata){

				echo json_encode(['status'=>'error','response'=>"{$telephone} already exsist"]);
				exit;
			}

			if($checkusernamedata){

				echo json_encode(['status'=>'error','response'=>"{$username} already exsist"]);
				exit;
			}

			$encryption = password_hash($password,PASSWORD_DEFAULT);

			$userId = strtoupper($this->getRandomCode(10));
	
			$data = ['email'=>$email,'telephone'=>$telephone,'password'=>$encryption,'userId'=>$userId,'permission'=>'Client','created_at'=>$this->dayTimeZone(),'username'=>$username];

			$body = "
		
			<h4>Hello {$username},<h4/>
			<h5>Welcome to Akwaaba.</h5>
			<p>Thank you for choosing us</p>
			<p>Please click here <a href='digich.org'>verify account</a> to verify your account email</p>
	
			<span>Thank you.</span>";
	
			if($this->createLogin($data)){

		        $this->sendEmail($email,'Account verification',$body);

				echo json_encode(['status'=>'ok','response'=>"Account created successfully."]);
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Something went wrong.',]);}
		}
		else{echo json_encode(['status'=>'error','response'=>'Invalid Api key',]);}
	}

	protected function authLogin($authvalue,$password){

		if(API_KEY == $this->getHeaderpath()){

			if(!empty($authvalue) && !empty($password)){

				// Varify password and start authorization process
				$checkuserIdentity = $this->checkRequest($authvalue);
	
				if($checkuserIdentity){
	
					return ($checkuserIdentity->status == 1) ? $this->verifyPassword($checkuserIdentity,$authvalue,$password) : $this->userException('Please verify your email to login.');
				}
		        else{$this->userException('Invalid credentials.');}
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid Input format.']);}
		}
		else{echo json_encode(['status'=>'error','response'=>'Invalid Api key',]);}
	}

	private function verifyPassword($checkuserIdentity,$authvalue,$password){

		if(!empty($authvalue) && !empty($password) && $checkuserIdentity){

			if(password_verify($password,$checkuserIdentity->password)){

				switch ($checkuserIdentity->permission) {

					case 'Administrator':
						$this->setToken($checkuserIdentity);
					break;

					case 'Client':
						$this->setToken($checkuserIdentity);
					break;

					case 'User':
						$this->setToken($checkuserIdentity);
					break;
					
					default:
						$this->userException('Invalid credentials.');
					break;
				}
			}
			else{$this->userException('Invalid credentials.');}
		}
	}

	private function setToken($checkuserIdentity){

		$generatetoken = Auth::jwtToken(
			$checkuserIdentity->userId,
			$checkuserIdentity->permission,
			$checkuserIdentity->email,
			$checkuserIdentity->telephone
		);

		if($generatetoken){

			echo json_encode(['status'=>'ok','response'=>$generatetoken]);
			exit;
		}
		else{$this->userException('Invalid credentials.');}
	}

	private function userException($message){
		echo json_encode(['status'=>'error','response'=>$message]);
		exit;
	}
}