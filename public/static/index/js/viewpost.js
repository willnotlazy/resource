$('.view-times').everyTime('30s',function () {
   $.ajax({
       type:'post',
       url:'/viewtimes',
       dataType : "json",
       contentType : "application/x-www-form-urlencoded",
       data : {postid:$('.hide').text()},
       success : function (data,status,xhr)
       {
           $('.view-times span').text(data);
       }
   });
});



function showForm()
{
    $.ajax({
        type: "post"
        ,url: "/addreply"
        ,dataType: "json"
        ,contentType: "application/x-www-form-urlencoded"
        ,data: {postID:$('.hide').text(),editorValue:ue.getContent()}
        ,success: function (data,status,xhr)
        {
            var jdata = eval('(' + data + ')');
            if (jdata.code != 20099)
            {
                alert(jdata.msg)
            }
            else
            {
                alert(jdata.msg);
                location.reload();
            }
        }
    });
}


var ue = UE.getEditor('content', {
    toolbars: [[
        'fullscreen', 'source', '|', 'undo', 'redo', '|',
        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
        'directionalityltr', 'directionalityrtl', 'indent', '|',
        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
        'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
        'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
        'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
        'print', 'preview', 'searchreplace', 'drafts', 'help'
    ]],
    initialFrameHeight:366
    ,maximumWords: 30
    ,elementPathEnabled:false
});


$(function () {
    responseImg("img","img-fit",40);
});