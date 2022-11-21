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

	protected function createPost($data,$telephone,$email,$companyName){

		if($this->getchecker() === true && count($data) > 0){

			$checkemaildata = $this->checkForDuplicate('email',$email);

			if($checkemaildata){

				echo json_encode(['status'=>'error','response'=>"{$email} already exsist"]);
				exit;
			}

			$checktelephonedata = $this->checkForDuplicate('telephone',$telephone);

			if($checktelephonedata){

				echo json_encode(['status'=>'error','response'=>"{$telephone} already exsist"]);
				exit;
			}

			$checkcompanynamedata = $this->checkForDuplicate('companyName',$companyName);

			if($checkcompanynamedata){

				echo json_encode(['status'=>'error','response'=>"{$companyName} already exsist"]);
				exit;
			}

			if($this->createCompany($data)){

				echo json_encode(['status'=>'ok','response'=>'Data created successfully.']);
				exit;
			}
			else{echo json_encode(['status'=>'error','response'=>'Oops! Something went wrong.']);exit;}
		}
	}
}