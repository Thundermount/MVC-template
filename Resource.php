<?php
class Resource{
    public static function load(){
    $targetdir = RESOURCES.$_SESSION['id']."/";
    $target_file = $targetdir . date("Y-m-d H-i-s").".".pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }


// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    return $target_file;
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
}
public static function simple_upload(){
  $uploaddir = './recources/';
  $uploadfile = $uploaddir . basename($_FILES['image']['name']);
  if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
      echo "Файл корректен и был успешно загружен.\n";
      $image = $uploadfile;
  } else {
      echo "Ошибка при загрузке файла.\n";
  }
}

}
?>