<?php
class config{
// Отключает капчу, включает режим отладки
static $debug = true;
// Для соединения с базой данных
static $hostname = "localhost";
static $username = "root";
static $password = "";
static $database = "forum";
// Капча
static $recaptcha_html = "insert your capthcha element code";
static $recaptcha = "insert your captcha code";
// Если приложение находится в папке например localhost/application то нужно указать эту папку
// При установке на домен следует оставить пустым или выключить debug
// Изменено: фича не работает адекватно поэтому нужно создавать виртуальный домен через файл hosts
// и в файле httpd-vhosts.conf указывать директорию в которой лежит сайт
static $application_dir = '';
}
?>