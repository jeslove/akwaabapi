<?php

use core\Forms\Forms;
use interfaces\Data\Processdata;
use resources\Companyresources\Companyresources;

class Company extends Companyresources implements Processdata{

	public function __construct()
	{
		parent:: __construct();
	}

	public function create()
	{
		if(Forms::isPost())
		{
			$fields = json_decode(file_get_contents("php://input"));

			if($fields && !empty($fields->companyName) && !empty($fields->email) && !empty($fields->telephone) && !empty($fields->cityId) && !empty($fields->companyAddress) && !empty($fields->companyDescription) && !empty($fields->companyDescription) && !empty($fields->region) && !empty($fields->perantCompany) && !empty($fields->countryId)){

				$companyName = filter_var($fields->companyName, FILTER_DEFAULT) ;
				$email = filter_var($fields->email,FILTER_VALIDATE_EMAIL);
				$telephone = filter_var($fields->telephone,FILTER_DEFAULT);
				$cityId = filter_var($fields->cityId,FILTER_DEFAULT);
				$companyAddress = filter_var($fields->companyAddress, FILTER_DEFAULT);
				$companyDescription = filter_var($fields->companyDescription,FILTER_DEFAULT);
				$region = filter_var($fields->region,FILTER_DEFAULT);
				$perantCompany = filter_var($fields->perantCompany, FILTER_DEFAULT);
				$contactId = filter_var($fields->contactId, FILTER_DEFAULT);
				$countryId = filter_var($fields->countryId, FILTER_DEFAULT);
				
				// expression for each inputs (Input Validation)

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							
					echo json_encode(['status'=>'error','response'=>"Invalid email format."]);
					exit;
				}

				if (!preg_match("/^[a-zA-Z-' ]*$/",$companyName)) {

					echo json_encode(['status'=>'error','response'=>"Only letters and white space allowed."]);
					exit;
				}

				if(!is_numeric($telephone)){

					echo json_encode(['status'=>'error','response'=>"Invalid phone number format."]);
					exit;
				}

				if(strlen($telephone) < 10 || strlen($telephone) > 14){
		
					echo json_encode(['status'=>'error','response'=>"Invalid phone number length range (10-14)."]);
					exit;
				}
				else
				{
					$data = [
						'companyName'=>$companyName,'email'=>$email,
						'telephone'=>$telephone,'cityId'=>$cityId,
						'companyAddress'=>$companyAddress,'companyDescription'=>$companyDescription,
						'region'=>$region,'perantCompany'=>$perantCompany,
						'contactId'=>$contactId,'countryId'=>$countryId,
						'created_at'=>$this->dayTimeZone()
					];

					return $this->createPost($data,$telephone,$email,$companyName);
					exit;
				}
		    }
			else
			{
				echo json_encode([
					'status'=>'error',
					'response'=>'Oops! Invalid Input format.',
					'data'=>'Required variable names (companyName,email,telephone,cityId,companyAddress,companyDescription,region,contactId and perantCompany,countryId)'
				]);
			}
		}
		else{echo json_encode(['status'=>'error','response'=>'Oops! Invalid request.']);}
	}

	public function view()
	{
		
	}

	public function show()
	{
		
	}

	public function edit()
	{
		
	}

	public function patch()
	{
		
	}

	public function delete()
	{
		
	}
}