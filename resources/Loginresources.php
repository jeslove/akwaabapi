<?php 

namespace resources\Loginresources;

use connect\TriatConnect\Traitconnnect;
use login\models\logins\Logins;

class Loginresources extends Logins{

	use Traitconnnect;

	public function __construct()
	{
		parent:: __construct();
	}

	protected function createPost($email,$telephone,$password){

		if(API_KEY == $this->getHeaderpath())
		{
			$checkemaildata = $this->checkDuplicate('email',$email);

			$checktelephonedata = $this->checkDuplicate('telephone',$telephone);

			if($checkemaildata){

				echo json_encode(['status'=>'error','response'=>"{$email} already exsist"]);
				exit(1);
			}

			if($checktelephonedata){

				echo json_encode(['status'=>'error','response'=>"{$telephone} already exsist"]);
				exit(1);
			}

			$encryption = password_hash($password,PASSWORD_DEFAULT);

			$userId = strtoupper($this->getRandomCode(10));
	
			$data = ['email'=>$email,'telephone'=>$telephone,'password'=>$encryption,'userId'=>$userId,'permission'=>'Client','created_at'=>$this->dayTimeZone(),'status'=>1];
	
			if($this->createLogin($data)){
	
				echo json_encode(['status'=>'ok','response'=>"Account created successfully."]);
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Something went wrong.',]);}
		}
	}
}