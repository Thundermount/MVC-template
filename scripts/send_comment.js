$('#send-comment').click(function(){
    $.ajax({
        url: "/records/post_comment",
        type: "POST",
        data: {
          comment:$('#comment').val(),
          record_id:$('#record_id').val()
        },
        success: null,
        dataType: "text"
      });
location.reload(true);
});