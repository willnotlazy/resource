function layout()
{
    $.ajax({
        type : "post",
        url : "/layout",
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {username:$('#uname').val(),__token__:$('#token').val()},
        success : function (data, status,xhr){
            var jdata = eval('('+data+')');
            alert(jdata.msg);
            if (jdata.code !== 20199)
            {
                $('#token').val(xhr.getResponseHeader('__token__'));
            }
            else{
                window.location.href = '/';
            }
        }
    })
}


$('.nav li').removeClass('active');

$(window).resize(function () {
    var imgs = document.getElementsByTagName("img");
    var contentLeft = document.getElementsByClassName("img-fit");
    for (var j=0; j<contentLeft.length; j++){
        for(var i=0; i<imgs.length; i++){
            imgs[i].style["max-width"] = contentLeft[j].offsetWidth - 40 + "px";
        }
    }

});

// 图片自适应函数
function responseImg(img,content,offset) {
    var imgs = document.getElementsByTagName(img);
    var contentLeft = document.getElementsByClassName(content);
    for (var j=0; j<contentLeft.length; j++){
        for(var i=0; i<imgs.length; i++){
            imgs[i].style["max-width"] = contentLeft[j].offsetWidth - parseInt(offset) + "px";
        }
    }
}


function showClassify(content)
{
    $('.'+content).animate({
        height:'toggle'
    })
}

$('.msg-container').everyTime('30s',function () {
   $.ajax({
       type:'post'
       ,url :'/getReplyNum'
       ,dataType: "json"
       ,contentType : "application/x-www-form-urlencoded"
       ,data: ""
       ,success : function (data) {
           var jdata = eval('('+data+')');
           if (jdata.nums !== 0)
               $('.msg-container').html('消息<span class="msg-nums" style="color: red;">('+jdata.nums+')</span>');
           else
               $('.msg-container').html('消息');
       }

   });
});


// ajax更新排行表单
$('.range-page').everyTime('30s',function () {
    $.ajax({
        type:'post'
        ,url :'/updateRange'
        ,dataType: "json"
        ,contentType : "application/x-www-form-urlencoded"
        ,data: ""
        ,success : function (data) {
            var jdata = eval('('+data+')');
            var all_range_html = '<div class="range">';
            var day_range_html = '<div class="range">';
            var announce_range_html = '<div class="range">';
            var lastest_user_html = '';
            if (jdata.all){
                for (var i in jdata.all)
                {
                    all_range_html += '<li><span class="badge">'+jdata.all[i].views+'</span><a href="/viewpost/postid/'+jdata.all[i].postID+'">'+jdata.all[i].title+'</a></li>';
                }
                all_range_html += '</div>';
                $('#all_range').html(all_range_html);
            }
            if (jdata.day){
                for (var j in jdata.day)
                {
                    day_range_html += '<li><span class="badge">'+jdata.day[j].views+'</span><a href="/viewpost/postid/'+jdata.day[j].postID+'">'+jdata.day[j].title+'</a></li>';
                }
                day_range_html += '</div>';
                $('#day_range').html(day_range_html);
            }

            if (jdata.announce){
                for (var l in jdata.announce)
                {
                    announce_range_html += '<li> <span class="badge">'+jdata.announce[l].nums+'</span> <a href="/showUser/'+jdata.announce[l].authorID+'">'+jdata.announce[l].username+'</a> </li>';
                }
                announce_range_html += '</div>';
                $('#announce_range').html(announce_range_html);
            }

            if (jdata.user){
                for (var k in jdata.user)
                {
                    lastest_user_html += '<li><a href="/showuser?name='+jdata.user[k].username+'"><img class="avatar" src="'+jdata.user[k].thumb+'"' +
                        ' data-original="'+jdata.user[k].thumb+'" title="'+jdata.user[k].username+'" width="55" height="55" style="display: inline;"></a></li>';
                }
                $('#recent_user').html(lastest_user_html);
            }
        }
    });
});