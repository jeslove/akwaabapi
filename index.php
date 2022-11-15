<?php 

ob_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");

require 'vendor/autoload.php';

use connect\Helpers\Helper;

use core\Router\Router;

ini_set('display_errors', ERR); 

ini_set('display_startup_errors', ERR);

ini_set("allow_url_fopen", true);

error_reporting(E_ALL);

$dirs = array('connect','configs');

$file_ext = array("php");

$files = Helper::scan($dirs, $file_ext);

foreach($files as $path)
{
	if(file_exists($path))
	{
		require_once ($path);
	}
}

function is_session_started()
{
	if (php_sapi_name() !== 'cli')
	{
		if (version_compare(phpversion(), '5.4.0', '>='))
		{
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
		}
		else
		{
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

if (is_session_started() === FALSE) session_start();


$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

// var_dump($url);

new Router($url);
