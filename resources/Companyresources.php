<?php 

namespace resources\Companyresources;

use connect\TriatConnect\Traitconnnect;
use setting\models\companies\Companies;

class Companyresources extends Companies{

	use Traitconnnect;

	public function __construct()
	{
		parent:: __construct();
	}

	protected function createPost($data){

		if($this->getchecker() === true && $data){

			if($this->createCompany($data)){

				echo json_encode(['status'=>'ok','response'=>'Data created successfully.']);
				exit;
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Something went wrong.']);exit;}
		}
	}
}