$(function(){
 $('#dialog').dialog({
    autoOpen: false,
     show:{
        effect: "blind",
         duration: 1000
     },
     hide: {
        effect: "explode",
         duration: 1000
     },
     position: { my: "center", at: "left+800px top+500px ", of: window  } ,
     width: 410,
     height: 200,
 });
});

function showmiu(id)
{
    $.ajax({
        type:'post',
        url:'/replyDialog',
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {id:id},
        success : function (data,status,xhr)
        {
            jdata = eval('('+data+')');
            $('#dialog').html('<p>文章标题：'+jdata.post_title+'</p><p>审核结果：'+jdata.msg_content+'</p>').dialog("open");
            $('.msg-nums').text('('+jdata.nums+')');
        }
    });
}