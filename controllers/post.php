<?php
class post{
    // Я решил сделать отдельный контроллер для POST запросов
    // так как их стало слишком много
    public function __construct(){
        include_once(MODELS.'Account.php');
        if(!Account::check_auth()){
            Router::redirect('/');
            return;
        }
    }
    public function delete(){
        $id = $_POST['remove_id'];
        $table = $_POST['table'];
        $Account = new Account($_SESSION['id']);
        if($Account->can_remove($id,$table)){
            $sql="DELETE FROM `$table` WHERE `id` = '$id'";
            db::$conn->query($sql);
            if($table == 'record'){
                $this->action_journal('DELETE',$table,$id);
                $sqll = "DELETE FROM `category_record` WHERE `category_record`.`id_record` = '$id'";
                db::$conn->query($sqll);
            }
        }
    }
    public function change(){
        $id = $_POST['id'];
        $table = $_POST['table'];
        $text = $_POST['text'];
        $Account = new Account($_SESSION['id']);
        if(!$Account->can_edit($id,$table)) return;
        if($table != 'record'){
            $this->action_journal('UPDATE',$table,$id);
            $sql = "UPDATE `$table` SET `text` = '$text' WHERE `$table`.`id` = $id";
            db::$conn->query($sql);
        }
    }
    public function action_journal($action_name,$table,$id){
        $actor = $_SESSION['id'];
        $sql = "INSERT INTO `journal` (`id`, `action`, `table_name`, `record_id`, `actor`, `date`) VALUES (NULL, '$action_name', '$table', '$id', '$actor', CURRENT_TIMESTAMP)";
        db::$conn->query($sql);
    }
    public function configure_account(){
        $name = $_POST['name'];
        $about = $_POST['about'];
        Account::update_page($_SESSION['id'],'name',$name);
        Account::update_page($_SESSION['id'],'about',$about);
        if(isset($_FILES) && !isset($_POST['imagefromurl'])){
            $image = Resource::load();
            Account::update_avatar($_SESSION['id'],$image);
        }
        $image = $_POST['imagefromurl'];
        if(!empty($image)){
            Account::update_avatar($_SESSION['id'],$image);
        }
        Router::redirect('/user/'.$_SESSION['id']);
    }
}

?>