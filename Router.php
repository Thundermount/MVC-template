<?php

class Router{
    private $routes;
    public function __construct(){
        $this->routes = include(ROOT.'/routes.php');
    }

    public static function GetURI(){
        if (!empty($_SERVER['REQUEST_URI'])){
            $uri = trim($_SERVER['REQUEST_URI'],'/');
            if(config::$debug == true) $uri = str_replace(config::$application_dir,"",$uri);
            return $uri;
        }
    }
    public static function GetArgument(){
        $uri = Router::GetURI();
        $argument = explode("/",$uri);
        return $argument[1];
    }
    public static function GetArguments($id){
        $uri = Router::GetURI();
        $argument = explode("/",$uri);
        if (isset($argument[$id])) return $argument[$id];
        else return "";
    }
    public static function redirect($destination){
        $host = $_SERVER['HTTP_HOST'];
        header("Location: http://$host/$destination");
    }
    // creates a link based on whether domain is set or not
    // takes string as an argument
    public static function link($link){
        if(config::$debug == true && config::$application_dir != ''){
            $link = "/".config::$application_dir.$value;
        }
        return $link;
    }
    // changes array of strings based on whether domain is set or not
    // takes associative array as an argument
    public static function links($links){
        if(config::$debug == true && config::$application_dir != ''){
            foreach ($links as $i => $value){
                $links[$i] = "/".config::$application_dir.$value;
            }
        }
        return $links;
    }

    public function run(){
        $uri = $this->GetURI();
        foreach($this->routes as $route=>$path){
            if(preg_match("`$route`",$uri)){
                $path_seperated = explode("/",$path);
                $controller_name = $path_seperated[0];
                $action = $path_seperated[1];
                include_once("controllers/$controller_name.php");
                $controller = new $controller_name();
                $controller->$action();
                break;
            }
        }
    }
}

?>