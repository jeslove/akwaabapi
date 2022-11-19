<?php 

namespace setting\models\companies;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model{

	public function __construct()
	{
		parent:: __construct();
	}

	protected function createCompany($data){

		return Companies::insert($data);
	}

	protected function updateCompany($value,$item,$data){

		return Companies::query()->where($value,$item)->update($data);
	}

	protected function checkForDuplicate($value,$item){

		return Companies::query()->where($value,$item)->first();
	}

	protected function getCompanies($item){

		return Companies::query()->where($item)->get();
	}

	protected function getCompany($item){
		
		return Companies::query()->where($item)->first();
	}
}