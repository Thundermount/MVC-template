<?php
class Comment{
    private $id;
    private $text;
    private $author;
    private $record_id;
    private $date;
    public function __construct($id){
        $this->id = $id;
        $sql = "SELECT * FROM `comment` WHERE `id` = $id";
        if($result = $conn->query($sql)){
            while($row = $result->fetch_assoc()){
                $this->text = $row['text'];
                $this->author = $row['author'];
                $this->record_id = $row['record_id'];
                $this->date = $row['date'];
            }
        }
    }
    public static function create($text, $author, $record_id){
        $sql = "INSERT INTO `comment` (`id`, `text`, `author`, `record_id`, `date`) VALUES (NULL, '$text', '$author', '$record_id', CURRENT_TIMESTAMP)";
        db::$conn->query($sql);
    }
    public static function get_comments($id){
        $sql="SELECT * FROM `comment` WHERE `record_id` = '$id' ORDER BY `date` DESC";
        return db::$conn->query($sql);
    }

}

?>