function addPost()
{
    $.ajax({
        type : 'post',
        url  : '/addpost',
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {title:$('.title').val(),content:$('.content').val(),postAddress:$('.postAddress').val(),classify:$('.classify').val(),couldPost:$('.couldPost').val(),isEffective:$('.isEffective').val(),checkStatus:$('.checkStatus').val()},
        success : function (data) {
            alert(data);
        },
        error : function () {

        }
    });
}