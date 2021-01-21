<div class="row pt-5 text-light">
<div class="col-6 mx-auto form-group">
<form method="POST" action="/records/create_post">
<label for="title" class="h2">Заголовок</label>
<input class="form-control" type="text" id="title" name="title">

<div class="pt-4 input-group mb-2 mr-sm-2">
<label class="btn btn-success">
    Картинка из файла <input type="file" id="image" name="image">
</label>
<input class="form-control ml-4" type="text" id="image-url" name="image-url" placeholder="Картинка из URL">
</div>

<input class="form-control" type="text" id="video" name="video" placeholder="Видео с YouTube">

<div class="pt-4">
<?php
$categories = Record::get_categories();
while($category = $categories->fetch_assoc()){
$id = $category['id'];
$name = $category['name'];
echo "<div class='form-check form-check-inline'>";
echo  "<input class='form-check-input' type='checkbox' id='$id' name='$id' value='$id'>";
echo  "<label class='form-check-label' for='$id'>$name</label>";
echo "</div>";
}
?>
</div>

<label for="text" class="h2 pt-4">Текст статьи</label>
<textarea class="form-control" rows="7" id="text" name="text"></textarea>
<input type="submit" class="btn btn-primary mt-4">
</form>
</div>
</div>