<?php

class user{
    public function __construct(){
        include_once(ROOT.'/models/Account.php');
        if(!Account::check_auth()) Router::redirect('');
    }
    public function page(){
        $title = 'Страница';
        include_once(ROOT.'/views/head.php');
        include_once(VIEWS.'menu.php');
        $id = Router::GetArgument();
        $acc = new Account($id);
        if (!Account::check_auth()) return;
        $acc_page = $acc->get_account_page();
        $user = $acc->user;
        $user+= $acc_page;
        if($id == $_SESSION['id']) include_once(VIEWS.'user_menu.php');
        include_once(ROOT.'/views/user_page.php');
        include_once(ROOT.'/views/bottom.html');
    }
    public function configure(){
        $title="Настройки аккаунта";
        include_once(ROOT.'/views/head.php');
        include_once(VIEWS.'menu.php');
        $account = new Account($_SESSION['id']);
        $page_info = $account->get_account_page();
        include_once(VIEWS.'configure.php');
        include_once(ROOT.'/views/bottom.html');
    }
    public function profiles(){
        $title="Пользователи";
        include_once(ROOT.'/views/head.php');
        include_once(VIEWS.'menu.php');
        include_once(VIEWS.'profiles.php');
        include_once(VIEWS.'bottom.html');
    }
    public function leave(){
        Account::leave();
        Router::redirect('');
    }
}

?>