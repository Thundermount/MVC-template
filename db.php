<?php
class db{
        static $conn;
        public static function array_to_sql($array_var){
                $sql = "( ". implode(',', array_map('intval', $array_var)).")";
                return $sql;
        }
}
?>