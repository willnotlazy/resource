function addPost()
{
    var data = new FormData($('.post-form')[0]);
    console.log(data);

    $.ajax({
        type : 'post',
        url  : '/addpost',
        dataType : "json",
        processData: false,
        contentType: false,
        // contentType : "application/x-www-form-urlencoded",
        // data : {title:$('#title').val(),classify:$('.classify').val(),second_classify:$('.second.classify').val(),content:$('#container').val(),postAddress:$('#postAddress').val(),transpond:$('#transpond').val(),cover:$('#cover').val()},
        data: data,
        success : function (data,status,xhr) {
            var jdata = eval('('+data+')');
            alert(jdata.msg);
            if (jdata.code !== 20600)
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

var ue = UE.getEditor('container', {
    toolbars: [
        ['fullscreen', 'source', 'undo', 'redo'],
        ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset',
            'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','insertimage','link','unlink']
    ],
    initialFrameHeight:366,
    elementPathEnabled:false,
});


$('#cover').fileinput({
    language:'zh',
});

$('.fileinput-upload').remove();