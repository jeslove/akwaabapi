<?php 

namespace core\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use DateTimeImmutable;
use Exception;

/**
 * Runing the verification script (POST)
 * Check users ip exsists
*/
/** Generate JWT token for user */
class Auth
{
	/** Generate JWT-TOKEN */
	public static function jwtToken($userId,$permission,$churchId,$tel,$role,$ministry="")
	{
		/** API KEYS */
		$secret_key = API_KEY;

		$issuer_claim = BASE_PATH; 

		$audience_claim = "churchERP";

		$issuedat_claim = new DateTimeImmutable();

		$expire_claim = $issuedat_claim->modify('+480 minutes')->getTimestamp(); 

		$users =[
			"userId"=>$userId,
			"permission"=>$permission,
            "churchId"=>$churchId,
            "telephone"=>$tel,
            "rolestatus"=>$role,
            'ministry'=>$ministry
		];

		$token = array(
			"iss" => $issuer_claim,
			"aud" => $audience_claim,
			"iat" => $issuedat_claim->getTimestamp(),
			"nbf" => $issuedat_claim->getTimestamp(),
			"exp" => $expire_claim,
			"data"=>$users
		);

        /**
         * You can add a leeway to account for when there is a clock skew times between
         * the signing and verifying servers. It is recommended that this leeway should
         * not be bigger than a few minutes.
         *
         * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
        */

		return JWT::encode($token, $secret_key,AUTH_KEY);
	}

	/** Process Auth token via header */
	public static function getAuthorizationHeader()
    {
        $headers = null;

        if (isset($_SERVER['Authorization']))
        {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION']))
        { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } 
        elseif (function_exists('apache_request_headers'))
        {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            
            if (isset($requestHeaders['Authorization']))
            {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

	/** Get access token via bearer */
    public static function getBearerToken()
    {
        $headers = self::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers))
        {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches))
            {
                return $matches[1];
            }
        }
        else
        {
            echo json_encode(['status'=>'error','message'=>'Access Token Not found']);
         
        }
    }


	/** Decode JWT TOKEN VALUES */
	public static function decodeJWT()
	{
        try {
            $token = self::getBearerToken();

		    // return JWT::decode($token, API_KEY, [AUTH_KEY]);

            /**
             * IMPORTANT:
             * You must specify supported algorithms for your application. See
             * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
             * for a list of spec-compliant algorithms.
            */

            return JWT::decode($token, new Key(API_KEY, AUTH_KEY));

            /*
            NOTE: This will now be an object instead of an associative array. To get
            an associative array, you will need to cast it as such:
            */

        } catch (Exception $e)
        {
            echo json_encode(['status'=>'error','response'=>$e->getMessage()]);
        }
	}

    public static function checkexpiredToken()
    {
        $time = new DateTimeImmutable();

        $server = BASE_PATH;

        $token = static::decodeJWT();

        if(!empty($token))
        {
            if($token->exp > $time->getTimestamp() && $token->iss === $server)
            {
                return true;
            }
            else{ return false;}
        }
    }
}