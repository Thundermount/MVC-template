<?php
class Account{
    public $user;
    // Это хеш пароля никому его не давайте
    private $pass_hash;
    public function __construct($id){
        $sql="SELECT * FROM `account` WHERE `id` = '$id'";
        if ($result = db::$conn->query($sql)){
            while($row = $result->fetch_assoc()){
                $this->user = $row;
                break;
            }
        }
    }
    public static function get_by_login($login){
        $sql = "SELECT * FROM `account` WHERE `login` = '$login'";
        return db::$conn->query($sql);
    }
    public static function verify($login, $password){
        $account = Account::get_by_login($login);
        while($row = $account->fetch_assoc()){
            if(!password_verify ($password,$row['password_hash'])){
                return false;
            }
            return $row;
        }
    }
    public static function leave(){
        setcookie("id",null,1,"/");
        setcookie("login",null,1,"/");
        setcookie("password_hash",null,"/");
        setcookie("admin_group",null,"/");
        if(isset($_SESSION['id'])) unset($_SESSION['id']);
        if(isset($_SESSION['login'])) unset($_SESSION['login']);
        if(isset($_SESSION['password_hash'])) unset($_SESSION['password_hash']);
        if(isset($_SESSION['admin_group'])) unset($_SESSION['admin_group']);
    }
    public static function auth($account){
        $_SESSION['id'] = $account['id'];
        $_SESSION['login'] = $account['login'];
        $_SESSION['password_hash'] = $account['password_hash'];
        if($account['admin_group'] != null) $_SESSION['admin_group'] = $account['admin_group'];
        setcookie("id",$account['id']);
        setcookie("login",$account['login']);
        setcookie("password_hash", $account['password_hash']);
        if($account['admin_group']!= null)setcookie("admin_group",$account['admin_group']);
    }
    public static function check_auth(){
        if(!isset($_COOKIE['id'])) return false;
        if(!isset($_SESSION['id'])){
            $_SESSION['id'] = $_COOKIE['id'];
            $_SESSION['login'] = $_COOKIE['login'];
            $_SESSION['password_hash'] = $_COOKIE['password_hash'];
            $_SESSION['admin_group'] = isset($_COOKIE['admin_group']) ? $_COOKIE['admin_group'] : null;
        }
        $id = $_SESSION['id'];
        $login = $_SESSION['login'];
        $pass_hash = $_SESSION['password_hash'];
        $sql = "SELECT * FROM `account` WHERE `id` = '$id'";
        $result = db::$conn->query($sql);
        if(!$result->num_rows > 0){
            $this->leave();
            return false;
        }
        while($row = $result->fetch_assoc()){
            if($row['id'] != $id){
                $this->leave();
                return false;
            }
            if($row['login'] != $login){
                return false;
                $this->leave();
            }
            if($row['password_hash'] != $pass_hash){
                $this->leave();
                return false;
            }
        }
        return true;
    }
    public static function update_avatar($id, $path){
        $sql = "UPDATE `account` SET `avatar` = '$path' WHERE `account`.`id` = '$id'";
        db::$conn->query($sql);
    }
    public static function update_page($id, $field, $value){
        $sql = "UPDATE `account_page` SET `$field` = '$value' WHERE `account_page`.`id_account` = $id";
        db::$conn->query($sql);
    }
    public function get_account_page(){
        $id = $this->user['id'];
        $sql = "SELECT * FROM `account_page` WHERE `id_account` = '$id'";
        if($result = db::$conn->query($sql)){
            while($row=$result->fetch_assoc()){
                return $row;
            }
        }
        
    }
    public function can_edit($id, $table){
        $sql="SELECT `author` FROM `$table` WHERE `id` = '$id'";
        $result = db::$conn->query($sql);
        while ($row = $result->fetch_assoc()){
            if($row['author'] == $_SESSION['id']) return true;
        }
        return false;
    }
    public function can_remove($id, $table){
        if(isset($this->user['admin_group']) && $this->user['admin_group']<=2){
            // Then it's admin or moderator
            return true;
        }
        $sql="SELECT `author` FROM `$table` WHERE `id` = '$id'";
        $result = db::$conn->query($sql);
        while ($row = $result->fetch_assoc()){
            if($row['author'] == $_SESSION['id']) return true;
        }
        return false;
    }
    public static function create($login, $password){
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `account` (`id`, `login`, `password_hash`, `avatar`, `admin_group`, `date`) VALUES (NULL, '$login', '$password_hash', NULL, NULL, CURRENT_TIMESTAMP)";
        db::$conn->query($sql);
        $id = db::$conn->insert_id;
        $sql = "INSERT INTO `account_page` (`id_account`, `about`, `name`) VALUES ('$id', '', NULL)";
        db::$conn->query($sql);
        // Возвращаем id созданного пользователя
        return $id;
    }

}

?>