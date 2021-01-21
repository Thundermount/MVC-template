<div class="row text-light pt-5 justify-content-center">
<div class="col-sm-7">
<div class="h2"><?php echo $record['title']; 
$record_id = $record['id'];
if($Account->can_remove($id,'record'))
echo "<div class='float-right delete-button bg-light' data-toggle='modal' data-target='#confirmModal' data-id='$record_id' data-type='record'></div>"
?></div>
<div class="text-secondary"><?php echo $record['date']."    ";
$author_id = $record['author'];
$author_login = Record::get_author($author_id);
echo "<a href='/user/$author_id'>$author_login</a>  ";
$categories = $rec->get_category_name();
echo "<div>Категории: ";
if(isset($categories)){
foreach ($categories as &$category){
    echo  " ".$category;
}
}
echo "</div>";
?></div>
<hr class="bg-light">
<?php
if(isset($record['video']) && $record['video']!=""){
    $video = $record['video'];
    $video_id = explode('=',$video);
    $video_id = $video_id[1];
    $video_id = explode('&t',$video_id);
    $video_id = $video_id[0];
    echo "<iframe width=560 height=315 class='embed-responsive-item mx-auto d-block' src=https://www.youtube.com/embed/$video_id frameborder=0 allow=accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture allowfullscreen></iframe>";
}
if (isset($record['image'])&& $record['image']!=""){
    $image = $record['image'];
echo "<img src='$image' class='img-fluid mx-auto d-block w-50' alt='Responsive image'>";
}
?>
<div class="h4 pre"><?php echo $record['text']; ?></div>
</div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Вы уверены что хотите удалить это?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success" id="delete-confirm" data-dismiss="modal">Да</button>
        <button type="button" class="btn btn-danger" id="delete-cancel" data-dismiss="modal">Нет</button>
      </div>
    </div>
  </div>
</div>