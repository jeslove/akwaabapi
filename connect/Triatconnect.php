<?php 

namespace connect\TriatConnect;
use core\Auth\Auth;
use Smsconnection;

trait Traitconnnect
{
	protected $_seasion , $_checktoken;

	protected function getseassion()
	{
		return $this->_seasion = Auth::decodeJWT();
	}

	protected function getchecker()
	{
		return $this->_checktoken = Auth::checkexpiredToken();
	}

	protected function getHeaderpath(){

		return Auth::getX_API_KEYHeader();
	}

	// protected function connect($item){

	// 	$data = new Smsconnection();

	// 	return $data->connectSmsKey($item);	
	// }

	// Generate random codes for verification token
	protected function getVerificationCode($getNumbers)
	{
		$upcoming_event_code = str_shuffle(VERIFICATION_CODE);

		return $upcoming_event_code = substr($upcoming_event_code,1, $getNumbers);
	}

	#Random Charactors generator
	protected function getRandomCode($getNewNumbers)
	{
		$upcoming_event_code = uniqid(md5(true));

		$upcoming_event_code = str_shuffle($upcoming_event_code);

		return $upcoming_event_code = substr($upcoming_event_code,25, $getNewNumbers);
	}
	

	/** Update sms table counter */
	// protected function countsmspost($churchId,$data)
	// {
	// 	$check = new Smsconnection();

	// 	return $check->count_sms_post($churchId,$data);
	// }

	# Day Zone for Africa
	protected function dateZone()
	{
		date_default_timezone_set('Africa/Accra');
		
		return date('Y-m-d');
	}

	protected function agentVersion()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $regx = '/\/[a-zA-Z0-9.]+/';
        
        return preg_replace($regx,'', $agent);
    }

    #Get user Ip address
    protected function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
        return $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
        return $_SERVER['REMOTE_ADDR'];
        }
    }
	

	protected function dayTimeZone()
    {
        date_default_timezone_set('Africa/Accra');

        $date = date('Y-m-d');

        $time = date('H:i:s');

        return $date . ' ' . $time;
    }

	// send sms to members base on church Id
	protected static function sendsms($senderId,$number,$message)
	{
		$curl_handle=curl_init();

		$key = SMS_KEY;

		$to = "$number";

		$sender_id = "$senderId";

		$msg = "$message";

		$url = "https://apps.mnotify.net/smsapi?key=$key&to=$to&msg=$msg&sender_id=$sender_id";

		curl_setopt($curl_handle, CURLOPT_URL,$url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle,CURLOPT_POST, 1); 
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Church DataBase');
		curl_exec($curl_handle);
		curl_close($curl_handle);
	}

	protected function tempnam_sfx($path, $suffix)
    {
        $file = '';
        do {
            $file = $path . "/" . mt_rand() . $suffix;

            $fp = @fopen($file, 'x');
        } while (!$fp);

        fclose($fp);

        return $file;
	}


	protected function successMessage($message)
	{
		echo json_encode(['status'=>'ok','response'=>$message]);
		http_response_code(200);
	}

	protected function errorMessage($message)
	{
		echo json_encode(['status'=>'error','response'=>$message]);
		http_response_code(404);
	}
}