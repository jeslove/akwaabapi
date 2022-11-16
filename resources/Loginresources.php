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
	
			$data = ['email'=>$email,'telephone'=>$telephone,'password'=>$encryption,'userId'=>$userId,'permission'=>'Client','created_at'=>$this->dayTimeZone(),'status'=>1,'username'=>$username];
	
			if($this->createLogin($data)){
	
				echo json_encode(['status'=>'ok','response'=>"Account created successfully."]);
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Something went wrong.',]);}
		}
	}

	protected function authLogin($authvalue,$password){

		if(API_KEY == $this->getHeaderpath()){

			if(!empty($authvalue) && !empty($password)){

				// Varify password and start authorization process
				$checkuserIdentity = $this->checkRequest($authvalue);
	
				if($checkuserIdentity){
	
					return ($checkuserIdentity->status == 1) ? $this->verifyPassword($checkuserIdentity,$authvalue,$password) : $this->userException();
				}
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid Input format.']);}
		}
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
						$this->userException();
					break;
				}
			}
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
	}

	private function userException(){
		echo json_encode(['status'=>'error','response'=>'Invalid credentials.']);
		exit;
	}
}