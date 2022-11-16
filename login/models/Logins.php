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

	protected function checkDuplicate($value,$item){

		return Logins::query()->where($value,$item)->first();
	}

	protected function checkRequest($item)
	{
		return Logins::query()->where('email',$item)->orwhere('telephone',$item)->first();
	}
}
