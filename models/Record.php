<?php
class Record{
    public $record;
    public static $limit_page = 10;
    public function __construct($id){
        $this->id = $id;
        $sql = "SELECT * FROM `record` WHERE `id` = '$id'";
        if ($result = db::$conn->query($sql)){
            while($row=$result->fetch_assoc()){
                $this->record = $row;
                return;
            }
        }
    }
    // Вывести список назначенных категорий для конкретной записи
    public function get_category_name(){
        $id = $this->record['id'];
        $names;
        $sql="SELECT * FROM `category_record` WHERE `id_record` = '$id'";
        $result = db::$conn->query($sql);
        while($row = $result->fetch_assoc()){
            $id_category = $row['id_category'];
            $get_name = "SELECT * FROM `category` WHERE `id` = '$id_category'";
            $var1 = db::$conn->query($get_name);
            while ($var2 = $var1->fetch_assoc()){
                $names[$var2['id']] = $var2['name'];
            }
        }
        if (isset($names))
        return $names;
        else return null;
    }
    public static function get_author($id){
        $sql="SELECT `login` FROM `account` WHERE `id` = '$id'";
        $result = db::$conn->query($sql);
        while($row = $result->fetch_assoc()){
            return $row['login'];
        }
    }
    public static function create($title, $text, $author,$image,$video){
        $sql ="INSERT INTO `record` (`id`, `title`, `text`, `author`, `image`, `video`,`date`) VALUES (NULL, '$title', '$text', '$author', '$image', '$video',CURRENT_TIMESTAMP)";
        db::$conn->query($sql);
        $record_id = db::$conn->insert_id;
        $categories = Record::get_categories();
        while($category = $categories->fetch_assoc()){
            $category_id = $category['id'];
            if(isset($_POST[$category_id])){
                $add_category = "INSERT INTO `category_record` (`id_record`, `id_category`) VALUES ('$record_id', '$category_id')";
                db::$conn->query($add_category);
            }
        }
        return $record_id;
    }
    public static function get_pages(){
        $sql ="SELECT COUNT(*) FROM record";
        $result = db::$conn->query($sql);
        $row = $result->fetch_array();
        $records = $row[0];
        return round($records/Record::$limit_page,0,PHP_ROUND_HALF_UP);
    }
    public static function get_records($page){
        $limit = Record::$limit_page;
        $offset = ($page-1) * $limit;
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $catg_res = Record::get_categories();
            $categories = array();
            $i = 0;
            // Если галочка отмечена добавляем id категории
            // В массив выбранных
            while ($category = $catg_res->fetch_assoc()){
                if(isset($_GET[$category['id']])){
                $categories[$i] = $category['id'];
                $i+=1;
                }
            }

            // Передаем массив с выбранными категориями в функцию
            // Функция возвращает перечисление элементов массива в формате SQL
            $catg = db::array_to_sql($categories);
            $sql = "SELECT `id_record` FROM `category_record` WHERE id_category IN $catg";
            $record_ids = db::$conn->query($sql);
            $ids = array();
            $i = 0;
            while($row = $record_ids->fetch_assoc()){
                $ids[$i] = $row['id_record'];
                $i += 1;
            }
            $selected_records = db::array_to_sql($ids);
            if(!empty($search)) {
                $sql = "SELECT * FROM `record` WHERE `id` IN $selected_records AND `title` LIKE '%$search%' ORDER BY `date` DESC LIMIT $limit OFFSET $offset";
            } else $sql = "SELECT * FROM `record` WHERE `id` IN $selected_records ORDER BY `date` DESC LIMIT $limit OFFSET $offset";
            return db::$conn->query($sql);
        } else
        $sql = "SELECT * FROM `record` ORDER BY `date` DESC LIMIT $limit OFFSET $offset";
        return db::$conn->query($sql);
    }
    public static function get_by_author($id){
        $sql = "SELECT * FROM `record` WHERE `author` = '$id' ORDER BY `date` DESC";
        return db::$conn->query($sql);
    }
    // Выводит список всех существующих категорий
    public static function get_categories(){
        $sql = "SELECT * FROM `category`";
        if ($result = db::$conn->query($sql)){
            return $result;
        }
    }
}

?>