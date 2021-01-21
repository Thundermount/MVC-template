<?php
spl_autoload_register(function($class){
    if(!file_exists($class.'.php')) return false;
    include($class.'.php');
});
define('ROOT',dirname(__FILE__));
define('VIEWS', ROOT.'/views/');
define('MODELS', ROOT.'/models/');
define('RESOURCES', ROOT.'/resources/');
define('RECAPTCHA-HTML',"insert your capthcha element code");
define('RECAPTCHA',"insert your captcha code");
if(config::$application_dir != '' && config::$debug){
define('CSS', '/'.config::$application_dir.'/views/css/');
} else
define('CSS', '/views/css/');
if (config::$debug) ini_set('display_errors', 1);
session_start();
// connect to database
// uncomment this and set up your database
//db::$conn = new mysqli("localhost","root","","your db");
//db::$conn->set_charset("utf8");
$router = new Router();
$router->run();
?>