function layout(name,token)
{
    $.ajax({
        type : "post",
        url : "/layout",
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {username:name,__token__:token},
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