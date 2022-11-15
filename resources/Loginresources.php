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

			echo json_encode(['status'=>'ok','response'=>$data]);
		}
		else{echo json_encode(['status'=>'error','response'=>'No data found.',]);}
	}
}