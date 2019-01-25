function doLogin()
{
    $.post('/login',{username:$('#username').val(),password:$.base64.encode($.md5($('#password').val())),code:$('.login-code').val()},function(data,status){
        var jdata = eval('('+data+')');
        if (jdata.code === 20210)
        {
            console.log(data);
            alert(jdata.msg);
            window.location.href = '/';
        } else{
            if (jdata.code === 40426)
            {
                refreshVerify('verify_img1',1);
                alert(jdata.msg + ',您已失败'+jdata.data.errorTimes + '次,剩余可尝试次数'+jdata.data.surplus+'次');
            }else{
                refreshVerify('verify_img1',1);
                alert(jdata.msg);
            }
        }
    });
}



function doRegister()
{
    $.ajax({
        type :  "post",
        url :  "/register",
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {username:$('#r-username').val(),password:$('#r-password').val(),email:$('#r-email').val(),code:$('.register-code').val(),__token__:$('#__token__').val()},
        success : function (data,status,xhr)
        {
            var jdata = eval('('+data+')');
            alert(jdata.msg);
            if(jdata.code !==20200)
            {
                refreshVerify('verify_img2',2);
                $("#__token__").val(xhr.getResponseHeader('__token__'));
            }
            else{
                window.location.href = '/';
            }
        }
    });
}

var $spans = $('.rl-model .rl-model-header span');
var $bodys = $('.rl-model-body');

$spans.click(function (e) {
  var i = $(this).index();

  $(this)
    .addClass('active')
    .siblings()
    .removeClass('active');

  $bodys
    .eq(i)
    .addClass('show')
    .siblings()
    .removeClass('show')
});


// 登陆操作
$('.login').click(function(){
    doLogin();
});

$('.login-div').keydown(function (e) {
    if (e.which == 13)
    {
        doLogin();
    }
});
// 注册操作
$('.register').click(function(){
    doRegister()
});


$('.register-div').keydown(function (e) {
    if (e.which == 13)
    {
        doRegister();
    }
});


function refreshVerify(d,f)
{
    var ts = Date.parse(new Date())/1000;
    $('#'+d + ' img').attr('src',"/captcha/"+f+".html?id="+ts);
}