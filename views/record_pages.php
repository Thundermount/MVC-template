<link rel="stylesheet" href=<?php echo CSS."pages.css";?>>
<div class="pages-container">
<?php
$i = 1;
while($i<= $pages+1){
    echo "<a href='/records/$i/$args'>$i</a>";
    $i++;
}
?>
</div>