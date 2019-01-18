$(function () { $("[data-toggle='tooltip']").tooltip(); });

$('.index-views').everyTime('60s',function () {
    $.ajax({
        type:'post',
        url:'/indexviewtimes',
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {postid:$('span.hide').text()},
        success : function (data,status,xhr)
        {
            console.log(data);
            for (i in data)
            {
                $('.views-time-'+i+' span').text(data[i]);
            }
        }
    });
});