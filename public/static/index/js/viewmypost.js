$('.self-views').everyTime('30s',function () {
    $.ajax({
        type:'post',
        url:'/indexviewtimes',
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        data : {postid:$('span.hide').text()},
        success : function (data,status,xhr)
        {
            for (i in data)
            {
                $('.views-time-'+i+' span').text(data[i]);
            }
        }
    });
});


$(function () {
    responseImg("img","img-fit",40);
});