
$( document ).ready(function() {
    $('#name').attr("contenteditable","true");
});
$('#name').focusout(function(){
    $.ajax({
        url: "/user/configure",
        type: "POST",
        data: 'name='+$('#name').text(),
        success: null,
        dataType: "text"
      });
});
$('#about').click(function(){
    $('#about').css("display","none");
    $('#about-edit').css("display","flexbox");
    $('#about-edit').val($("#about").text());
    $('#about-edit').focus();
});
$('#about-edit').focusout(function(){
    $('#about').css("display","flexbox");
    $('#about').text($('#about-edit').val());
    $('#about-edit').css("display","none");
    $.ajax({
        url: "/user/configure",
        type: "POST",
        data: 'about='+$('#about-edit').val(),
        success: null,
        dataType: "text"
      });
});