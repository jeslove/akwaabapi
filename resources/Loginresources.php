<?php 

namespace resources\Loginresources;

use login\models\logins\Logins;

class Loginresources extends Logins{

	public function __construct()
	{
		parent:: __construct();
	}

	protected function createPost($data){

		if($data){

			if($this->createLogin($data)){

				echo json_encode(['status'=>'ok','response'=>"Data pushed successfully."]);
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Something went wrong.',]);}
		}
		else{echo json_encode(['status'=>'error','response'=>'No data found.',]);}
	}
}