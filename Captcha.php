<?php
class Captcha{
    public static function verify($response,$private){
        if (config::$debug) return true;

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$private&response=$response";
        $response = file_get_contents($url);
        $decode = json_decode($response,true);
        if($decode['success']) return true;
        else return false;
        
    }

}

?>