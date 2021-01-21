<?php

class main{
    public function __construct(){
        include(MODELS.'Account.php');
        if(Account::check_auth()){
            $id = $_SESSION['id'];
            Router::redirect("user/$id");
        }
    }
    public function welcome(){
        $title = "Главная";
        include_once(ROOT.'/views/head.php');
        include_once(VIEWS.'menu.php');
        include_once(ROOT.'/views/welcome.html');
        include_once(ROOT.'/views/login_form.html');
        include_once(ROOT.'/views/bottom.html');
    }
    public function register(){
        $title = "Регистрация";
        include_once(ROOT.'/views/head.php');
        $captcha = $_POST['g-recaptcha-response'];
        if(!Captcha::verify($captcha,RECAPTCHA)){
            echo '<div class="alert alert-danger" role="alert">Капча не пройдена!</div>';
            include_once(ROOT.'/views/bottom.html');
            return;
        }
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $pass_rep = $_POST['pass-rep'];
        if($login ==""){
            $this->error_message('Поле логина не должно быть пустым!');
            return;
        }
        if($pass ==""){
            $this->error_message('Поле пароля не должно быть пустым!');
            return;
        }
        if($pass != $pass_rep){
            echo '<div class="alert alert-danger" role="alert">Пароли не совпадают!</div>';
            include_once(ROOT.'/views/bottom.html');
            return;
        }
        include_once(ROOT.'/models/Account.php');
        if(Account::get_by_login($login)->num_rows > 0){
            echo '<div class="alert alert-danger" role="alert">Такой логин уже есть.</div>';
            include_once(ROOT.'/views/bottom.html');
            return;
        }
        Account::create($login,$pass);
        echo '<div class="alert alert-success" role="alert">Аккаунт успешно создан!
        <a href=/> Войти</a></div>';
        include_once(ROOT.'/views/bottom.html');
    }
    public function login(){
        $title = "Авторизация";
        include_once(ROOT.'/views/head.php');
        $captcha = $_POST['g-recaptcha-response'];
        if(!Captcha::verify($captcha,RECAPTCHA)){
            echo '<div class="alert alert-danger" role="alert">Капча не пройдена!</div>';
            include_once(ROOT.'/views/bottom.html');
            return;
        }
        $login = $_POST['login'];
        $password = $_POST['pass'];
        $account = Account::verify($login,$password);
        if($account == false) {
            echo '<div class="alert alert-danger" role="alert">Пароль не подходит или такого пользователя нет.</div>';
            include_once(ROOT.'/views/bottom.html');
            return;
        }
        Account::auth($account);
        $id = $_SESSION['id'];
        Router::redirect("user/$id");
    }
    private function error_message($message){
        echo "<div class='alert alert-danger' role='alert'>$message</div>";
        include_once(ROOT.'/views/bottom.html');
    }
}

?>