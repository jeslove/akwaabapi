<?php 

namespace connect\TriatConnect;
use core\Auth\Auth;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

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

	// send email to members base on church Id

	protected function sendEmail($email,$subject,$body){

		$transport = Transport::fromDsn(EMAIL_SMTP_HOST);

		$mailer = new Mailer($transport);

		$email = (new Email())
			->from(SET_FROM_MAIL)
			->to($email)
			->cc(MAILCC)
			->bcc(MAILBCC)
			->replyTo(SET_FROM_MAIL)
			->priority(Email::PRIORITY_HIGH)
			->subject($subject)
			// ->text('Sending emails is fun again!');
			->html($body);

		return $mailer->send($email);
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