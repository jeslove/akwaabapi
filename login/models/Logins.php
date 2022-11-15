<?php 

namespace login\models\logins;

use Illuminate\Database\Eloquent\Model;

class Logins extends Model{

	public function __construct()
	{
		parent:: __construct();
	}

	protected function createLogin($data){

		return Logins::insert($data);
	}
}
