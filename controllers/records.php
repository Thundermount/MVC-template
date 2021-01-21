<?php

class records{
    public function __construct(){
        include(ROOT.'/models/Record.php');
        include(ROOT.'/models/Account.php');
    }
    public function show(){
        $title = "Записи";
        include_once(ROOT.'/views/head.php');
        include_once(ROOT.'/views/menu.php');
        include_once(VIEWS.'records_search.php');
        $page = Router::GetArgument();
        $records = Record::get_records($page);
        if($records != false){
        while($record = $records->fetch_assoc()){
            include(ROOT.'/views/records.php');
        }
        $pages = Record::get_pages();
        $args = Router::GetArguments(2);
        include_once(VIEWS.'record_pages.php');
        echo "<script src='/scripts/record_preview.js'></script>";
    }
        include_once(ROOT.'/views/bottom.html');
    }
    public function record(){
        $id = Router::GetArgument();
        $title = "Запись #$id";
        include_once(ROOT.'/views/head.php');
        include_once(VIEWS.'menu.php');
        $rec = new Record($id);
        $record = $rec->record;
        $Account = new Account($_SESSION['id']);
        include_once(VIEWS.'record.php');
        include_once(MODELS.'Comment.php');
        include_once(VIEWS.'comment_form.php');
        $comments = Comment::get_comments($id);
        while($comment = $comments->fetch_assoc()){
            include(VIEWS.'comments.php');
        }
        echo "<script src='/scripts/send_comment.js'></script>";
        echo "<script src='/scripts/delete_edit.js'></script>";
        include_once(ROOT.'/views/bottom.html');
    }
    public function post_comment(){
        include_once(MODELS.'Account.php');
        if(!Account::check_auth()) return;
        $comment = $_POST['comment'];
        if(isset($comment) && !empty($comment)){
            include_once(MODELS.'Comment.php');
            Comment::create($comment,$_SESSION['id'],$_POST['record_id']);
        }
    }
    public function myrecords(){
        $title = "Мои записи";
        include_once(ROOT.'/views/head.php');
        include_once(VIEWS.'menu.php');
        $records = Record::get_by_author($_SESSION['id']);
        while($record = $records->fetch_assoc()){
            include(ROOT.'/views/records.php');
        }
        echo "<script src='/scripts/record_preview.js'></script>";
        include_once(VIEWS.'bottom.html');
    }
    public function create(){
        $title = "Написать статью";
        include_once(VIEWS.'head.php');
        include_once(VIEWS.'menu.php');
        include_once(VIEWS.'create_record.php');
        include_once(VIEWS.'bottom.html');
    }
    public function create_post(){
        include_once(MODELS.'Account.php');
        if (Account::check_auth()!=true) return;
        $title = $_POST['title'];
        $text = $_POST['text'];
        if(empty($title) || empty($text)) return;
        if(isset($_POST['image-url']) && $_POST['image-url']!=""){
            $image = $_POST['image-url'];
        } else
        if(isset($_FILES["fileToUpload"]["name"])){
            $image = Resource::load();
        } else $image = null;
        $video = isset($_POST['video'])? $_POST['video']:null;
        $author = $_SESSION['id'];
        $record_id = Record::create($title,$text,$author,$image,$video);
        Router::redirect("record/$record_id");
    }
}

?>