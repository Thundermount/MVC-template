<div class="row pt-4">
<div class="mx-auto col-6">
<button type="button" class="btn btn-success" onclick="location.href='records/create'">Create article</button>
<form method="GET" action="">
<div class="input-group pt-2">
<input type="text" class="form-control" id="search" name="search">
<button type="submit" class="btn btn-danger px-4">Search</button>
</div>
<?php 
$categories = Record::get_categories();
while($category = $categories->fetch_assoc()){
$id = $category['id'];
$name = $category['name'];
echo "<div class='form-check form-check-inline'>";
echo  "<input class='form-check-input' type='checkbox' id='$id' name='$id' value='$id' checked>";
echo  "<label class='form-check-label text-light' for='$id'>$name</label>";
echo "</div>";
}
?>
</div>
</form>
</div>