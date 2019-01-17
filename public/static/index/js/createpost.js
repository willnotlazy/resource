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

$(".chosen-select").chosen({
    no_results_text: "没有找到结果！",//搜索无结果时显示的提示
    search_contains:true,   //关键字模糊搜索，设置为false，则只从开头开始匹配
    allow_single_deselect:true, //是否允许取消选择
    max_selected_options:6  //当select为多选时，最多选择个数
});
