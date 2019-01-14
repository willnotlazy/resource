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