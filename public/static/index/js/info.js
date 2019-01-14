function layout()
{
    $.ajax({
        type : "post",
        url : "/layout",
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {username:$('#user').val(),__token__:$('#token').val()},
        success : function (data, status,xhr){
            var jdata = eval('('+data+')');
            alert(jdata.msg);
            if (jdata.code !== 20199)
            {
                $('#token').val(xhr.getResponseHeader('__token__'));
            }
            else{
                window.location.href = '/login';
            }
        }
    })
}

function createpost()
{
    window.location.href = '/createpost';
}