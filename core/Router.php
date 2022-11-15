<?php 
namespace core\Router;
use Exception;
class Router
{
    public function __construct($url)
    {
        switch (ENVERONMENT) {
            case 'Development':
                $this->routedev($url);
            break;

            case 'Production':
                $this->route($url);
            break;
            
            default:
                echo 'Please set development enveronment (Development | Production) mode';
            break;
        }
    }

    /**
     * Production Level Route
     */
    private function route($url)
    {
        $controller = (isset($url[0]) && $url[0] != '')? ucwords($url[0]) : '';
        
        $controller_name = $controller; // Getting the router controller name form the url stream data

        // var_dump($url[0]);

        array_shift($url);

        $action = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_METHOD;
        
        array_shift($url);

        $queryparams = $url;

        if(class_exists($controller))
        {
            $dispatch = new $controller($controller_name, $action);

            if (isset($controller, $action))
            {
                if (method_exists($controller, $action))
                {
                    try
                    {
                        call_user_func_array([$dispatch, $action], $queryparams);
                    } 
                catch (Exception $th) {static::pagenotfound();}
                }
                else {static::pagenotfound();}
            } 
            else {static::pagenotfound();}
        }  
        else{static::pagenotfound();}      
    }

    /**
     * Development Level Route
     */
    private function routedev($url)
    {
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : '';
        
        $controller_name = $controller;

        array_shift($url);

        $action = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_METHOD;
        
        array_shift($url);

        $queryparams = $url;

        // var_dump($controller);

        if(class_exists($controller))
        {
            $dispatch = new $controller($controller_name, $action);

            if (isset($controller, $action))
            {
                if (method_exists($controller, $action))
                {
                    call_user_func_array([$dispatch, $action], $queryparams);
                }
                else {static::pagenotfound();}
            } 
            else {static::pagenotfound();}
        } 
        else {static::pagenotfound();}     
    }



    public static function redirect($path,$location)
    {
        if(!headers_sent()) 
        {
            header('Location:'.$path.$location);
            exit;
        }
        else
        {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$path.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0,url='.$location.'"/>';
            echo '</noscript>';exit;
        }
    }

  
    

    public static function redirectpay($location)
    {
        if (!headers_sent())
        {
            header('Location:'.$location);
            exit;
        }
        else
        {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0,url='.$location.'"/>';
            echo '</noscript>';exit;
        }
    }

    private static function pagenotfound()
    {
        echo 'Page not found';
    }


}
