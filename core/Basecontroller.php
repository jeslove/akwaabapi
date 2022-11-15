<?php
namespace core\Basecontroller;


abstract class Basecontroller 
{
    protected static $alphabet,$alphabetLength;

    // protected  $_seassion, $_checktoken;

    public function __construct()
    {
    //    $this->_seassion = Auth::decodeJWT();

    //    $this->_checktoken = Auth::checkexpiredToken();
    }

    # Day Time Zone for Africa
    protected function dayTimeZone()
    {
        date_default_timezone_set('Africa/Accra');

        $date = date('Y-m-d');

        $time = date('H:i:s');

        return $date . ' ' . $time;
    }

    # Day Zone for Africa
    protected static function dateZone()
    {
        date_default_timezone_set('Africa/Accra');
        
        return date('Y-m-d');
    }

    protected static function getDay()
    {
        date_default_timezone_set('Africa/Accra');
        
        return date('d');
    }

    protected static function getMonth()
    {
        date_default_timezone_set('Africa/Accra');
        
        return date('m');
    }


    #validate Input fields
    protected function validate($data)
    {
        $data = htmlspecialchars($data);

        $data = strip_tags($data);

        $data = trim($data);

        $data = ltrim($data);

        return $data;
    }

    #Random Charactors generator
    protected static function getRandomCode($getNewNumbers)
    {
        $upcoming_event_code = uniqid(md5(true));

        $upcoming_event_code = str_shuffle($upcoming_event_code);

        return $upcoming_event_code = substr($upcoming_event_code,25, $getNewNumbers);
    }


    #Random Charactors generator
    protected static function setApikeys($getNewNumbers)
    {
        $upcoming_event_code = uniqid(md5(true));

        $upcoming_event_code = str_shuffle($upcoming_event_code);

        return $upcoming_event_code = substr($upcoming_event_code,0, $getNewNumbers);
    }

    protected static function random_string($length) 
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }

 

    #Random Numbers generator
    protected static function getVerificationCode($getNumbers)
    {
        $upcoming_event_code = str_shuffle(VERIFICATION_CODE);

        return $upcoming_event_code = substr($upcoming_event_code,1, $getNumbers);
    }

    # Generate Random colors
    protected function generate_color()
    {
        mt_srand((float) microtime() * 1000000);
        $color_code = '';
        while (strlen($color_code) < 6)
        {
            $color_code .= sprintf("%02X", mt_rand(0, 255));
        }
        return '#'.$color_code;
    }



    #Miles To kilometers Calculator
    public static function milesToKilometers($miles)
    {
       return $miles * 1.60934;
    }

    # Get User Browser Details
    protected static function agentVersion()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $regx = '/\/[a-zA-Z0-9.]+/';
        
        return preg_replace($regx,'', $agent);
    }

    #Get user Ip address
    protected static function getRealIpAddr()
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

    # Convert Image script name to binarys
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

    /**
     * detect if request over secured connection(SSL)
     *
     * @return boolean
     *
    */

    public function isSSL()
    {
        return isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off";
    }

    /**
     * Gets the request's protocol.
     *
     * @return string
    */

    public function protocol()
    {
        return $this->isSSL() ? 'https' : 'http';
    }

    /**
     * Get the referer of this request.
     *
     * @return string|null
    */

    public function referer()
    {
        return isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']: null;
    }

    # Return a clean output script for display
    static public function htmlToPlainText($str)
    {
        $str = str_replace('&nbsp;', ' ', $str);

        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT, 'UTF-8');

        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');

        $str = html_entity_decode($str);

        $str = htmlspecialchars_decode($str);

        $str = strip_tags($str);
        
        return $str;
    }

    public static function get_age($date)
    {
        $year_diff = '';

        $time = strtotime($date);

        if (FALSE === $time) {
            return '';
        }

        $date = date('Y-m-d', $time);

        list($year, $month, $day) = explode("-", $date);

        $year_diff = date("Y") - $year;

        $month_diff = date("m") - $month;

        $day_diff = date("d") - $day;

        if ($day_diff < 0 || $month_diff < 0) $year_diff;

        return $year_diff;
    }

    protected static function getuserage($date) 
    { // Y-m-d format
        $now = explode("-", date('Y-m-d'));
        $dob = explode("-", $date);
        $dif = $now[0] - $dob[0];
        if ($dob[1] > $now[1]) { // birthday month has not hit this year
            $dif -= 1;
        }
        elseif ($dob[1] == $now[1]) { // birthday month is this month, check day
            if ($dob[2] > $now[2]) {
                $dif -= 1;
            }
            elseif ($dob[2] == $now[2]) { // Happy Birthday!
                $dif = $dif." Happy Birthday!";
            };
        };
        return $dif;
    }

    function get_user_age($date)  
    { // Y-m-d format
        return intval(substr(date('Ymd') - date('Ymd', strtotime($date)), 0, -4));
    }

    # currency formator

    public static function number_format_short($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        if ($precision > 0)
        {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }
        return $n_format . $suffix;
    }

    // sms script

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


    protected static function systemsms($number,$message)
	{
		$curl_handle=curl_init();

		$key = SMS_KEY;

		$to = "$number";

        $sender_id = SENDERID;

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

    protected function getsmsbalance()
    {
        $endPoint = 'https://api.mnotify.com/api/balance/sms';

        $apiKey =SMS_KEY_VERS2;

        $url = $endPoint . '?key=' . $apiKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        return $result = json_decode($result, TRUE);
        curl_close($ch);
    }

    protected function getperiodicreport($from,$to)
    {
        $endPoint = "https://api.mnotify.com/api/report";

        $apiKey =SMS_KEY_VERS2;

        $url = $endPoint . '?key=' . $apiKey .'&from='.$from.'&to='.$to;
    
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        return $result = json_decode($result, TRUE);
        curl_close($ch);
    }

    protected function createsenderid($data)
    {
        $endPoint = 'https://api.mnotify.com/api/senderid/register';

        $apiKey = SMS_KEY_VERS2;

        $url = $endPoint . '?key=' . $apiKey;
    
        $ch = curl_init();
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        return $result = json_decode($result, TRUE);
        curl_close($ch);
    }

    protected function bulksms($senderId,$number,$message)
    {
        $endPoint = 'https://api.mnotify.com/api/sms/quick';

        $apiKey = SMS_KEY_VERS2;

        $url = $endPoint . '?key=' . $apiKey;

        $data = [
           'recipient' => $number,
           'sender' => $senderId,
           'message' => $message,
           'is_schedule' => 'false',
           'schedule_date' => ''
        ];
    
        $ch = curl_init();
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        $result = json_decode($result, TRUE);
        curl_close($ch);
    }


    protected function systembulksms($number,$message)
    {
        $endPoint = 'https://api.mnotify.com/api/sms/quick';

        $apiKey = SMS_KEY_VERS2;

        $url = $endPoint . '?key=' . $apiKey;

        $data = [
           'recipient' => $number,
           'sender' => SENDERID,
           'message' => $message,
           'is_schedule' => 'false',
           'schedule_date' => ''
        ];
    
        $ch = curl_init();
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        return json_decode($result, TRUE);
        curl_close($ch);
    }

    protected function extract_ids($cats)
	{
		$res = array();

		foreach($cats as $v) {
			$res[]= $v->telephone;
		}
		return $res;
	}

    protected function extract_ips($cats)
	{
		$res = array();

		foreach($cats as $v) {
			$res[]= $v;
		}
		return $res;
	}

    // protected function auditrails($message)
	// {
	// 	$trail =[
	// 		'userIdentity'=>$this->_seassion->data->telephone,
	// 		'flags'=>$message,
	// 		'userIP'=>$this->getRealIpAddr(),
	// 		'created_at'=>$this->dayTimeZone(),
	// 		'churchId'=>$this->_seassion->data->churchId,
	// 		'userBrowser'=>$this->agentVersion(),
    //         'datecheck'=>$this->dateZone()
	// 	];

	// 	Loghestorys::createtrails($trail);
	// }

    // protected function processMessages($churchId,$telephone,$message)
	// {
	// 	$keys = Smsapikeys::getkeys($churchId);

	// 	$this->sendsms($keys['senderName'],$telephone,$message);

	// 	$this->countsmspost($churchId,1);
	// }

	/** Update sms table counter */
	// private function countsmspost($churchId,$data)
	// {
	// 	$check = Smscountertables::getcounter($churchId);

	// 	if(!empty($check))
	// 	{
	// 		Smscountertables::updatedcount($churchId,$data);
	// 	}
	// 	else
	// 	{
	// 		$dataup =['churchId'=>$churchId,'messages'=>$data,'created_at'=>$this->dateZone()];

	// 	    Smscountertables::createcopies($dataup);
	// 	}
	// }

    protected function readIpAddress($keys)
    {
        // $apikey = "9e4523380a307106f8e1628797251b9b";

        $endPoint = 'http://api.ipstack.com/';

        $endPoint = 'http://ip-api.com/';

        // $url = $endPoint . '?access_key=' . $apikey;

        $url = $endPoint . 'json/' . $keys;

        $ch = curl_init();
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        return json_decode($result, TRUE);
        curl_close($ch);
    }
    


}
