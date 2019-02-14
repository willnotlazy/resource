$("#bg_image").fileinput({
    "showUpload":false
});

$("#bg_music").fileinput({
    "showUpload":false
});

$("#thumb").fileinput({
    "showUpload":false
});


function editPost()
{
    var data = new FormData($('.space-form')[0]);
    $('.__token__').val(' ');
    console.log(data);
    $.ajax({
        type : 'post',
        url  : '/editMySpace',
        dataType : "json",
        processData: false,
        contentType: false,
        // contentType : "application/x-www-form-urlencoded",
        // data : {title:$('#title').val(),classify:$('.classify').val(),second_classify:$('.second.classify').val(),content:$('#container').val(),postAddress:$('#postAddress').val(),transpond:$('#transpond').val(),cover:$('#cover').val()},
        data: data,
        success : function (data,status,xhr) {
            var jdata = eval('('+data+')');
            alert(jdata.msg);
            if (jdata.code !== 20000)
            {
                $('.__token__').val(xhr.getResponseHeader('__token__'));
            }
            else{
                window.location.href = '/';
            }
        },
        error : function () {
            alert('服务器错误，请刷新后重试');
        }
    });
}