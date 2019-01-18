$('.view-times').everyTime('60s',function () {
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