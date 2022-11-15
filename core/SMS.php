<?php 
namespace core\SMS;
// $key = "qNiCI57hmHrBgsZUMKukIjlNn"; webbermill sms api key
class SMS
{

    public static function sms($number,$message)
    {
        $curl_handle=curl_init();

		$key = SMS_KEY;

		$to = "$number";

		$msg = "$message";

        $sender_id = SENDERID;

		$url = "https://apps.mnotify.net/smsapi?key=$key&to=$to&msg=$msg&sender_id=$sender_id";

		curl_setopt($curl_handle, CURLOPT_URL,$url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle,CURLOPT_POST, 1); 
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Church DataBase');
		curl_exec($curl_handle);
		curl_close($curl_handle);

		
    }

    
	public static function response_SMS($number,$message)
    {
        $curl_handle=curl_init();

		$type = "Quick";

		$to = "$number";

		$message = "$message";

        $from = "RCC";

		// $url = "https://apps.mnotify.net/smsapi?key=$key&to=$to&msg=$msg&sender_id=$sender_id";

		$url = "https://api.kairosafrika.com/v1/external/sms/quick?to=$to&from=$from&message=$message&type=$type";

		curl_setopt($curl_handle, CURLOPT_URL,$url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle,CURLOPT_POST, 1); 
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Church DataBase');
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
            'x-api-key: U2FsdGVkX18RjAFhm+yqWOSUQMRQmC9SdakWO8I4wt4=',
            'x-api-secret: acvMExxxxxxxxxxxxSBPkjxxxx'
        ));
        
		curl_exec($curl_handle);
		curl_close($curl_handle);
    }







}