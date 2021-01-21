var id;
var type;
$('.delete-button').click(function(){
    id = $(this).attr('data-id');
    type = $(this).attr('data-type');
});
$('#delete-confirm').click(function(){
    $.ajax({
        url: "/post/delete",
        type: "POST",
        data: {
          remove_id: id,
          table: type
        },
        success: null,
        dataType: "text"
      });
    $('#comment'+id).remove();
});
$('#delete-cancel').click(function(){
    id = null;
    type = null;
});
$('.edit-button').click(function(){
    id = $(this).attr('data-id');
    show_edit();
    $('#comment-edit-'+id).val($('#comment-text-'+id).text());
});
$('.edit-send').click(function(){
  if($('#comment-edit-'+id).val()!=$('#comment-text-'+id).text()){
  $.ajax({
    url: "/post/change",
    type: "POST",
    data: {
      id: id,
      text: $('#comment-edit-'+id).val(),
      table: 'comment'
    },
    success: null,
    dataType: "text"
  });
}
  hide_edit();
  $('#comment-text-'+id).text($('#comment-edit-'+id).val());
});
$('.edit-cancel').click(function(){
    hide_edit();
});
function show_edit(){
  $('#comment-edit-'+id).css("display","flexbox");
    $('#edit-send-'+id).css("display","flexbox");
    $('#edit-cancel-'+id).css("display","flexbox");
    $('#comment-text-'+id).css("display","none");
}
function hide_edit(){
  $('#comment-edit-'+id).css("display","none");
    $('#edit-send-'+id).css("display","none");
    $('#edit-cancel-'+id).css("display","none");
    $('#comment-text-'+id).css("display","flexbox");
}
