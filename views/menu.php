<?php
// create array with menu
// add here new links
$menu = array();
$menu['records'] = "/records/1/";
$menu['profiles'] = "/user/profiles";
$menu['account'] = "/user/";
$menu['welcome'] = "/";

$menu = Router::links($menu);

echo "<link rel='stylesheet' href=".CSS."menu.css>
<div class='container-fluid' id='menu'>
<a href=".$menu['welcome'].">Welcome</a>
<a href=".$menu['records'].">Records</a>
<a href=".$menu['profiles'].">Profiles</a>";


// account menu options go here
if(isset($_SESSION['id'])){
    echo "<a href=<".$menu['account'].$_SESSION['id'].">My account</a>"; 
}?>
</div>