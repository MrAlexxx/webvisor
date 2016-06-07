
$(document).ready(function(){

    //$('body').on('click',function(e){
    //    $.ajax({
    //        //url: 'http://analitics/views/add-views',   вказати абсолютний шлях
    //        url: 'http://analitics/views/add-views',
    //        data: {
    //            'x': (Math.floor(e.pageX/5)*5)+5,//приводимо координати до кратних 5
    //            'y':(Math.floor(e.pageY/5)*5),
    //            'url':location.href},
    //        type: 'POST',
    //        success: function (data) {
    //        }
    //    });
    //});

    $('.screenshot').hover(
        function(){
            var path = $(this).attr('href');
            $(this).append('<img class="screenshot" src="http://mini.s-shot.ru/1024x768/240/jpeg/?'+path+';">');
        },
        function(){
            $('img.screenshot').remove();
        });

    $('.ml_url').on('change',function(){
        var text = $(this).val();
        //console.log(text.search('/\?/'));
        if(text.indexOf("?") + 1)
            text = text+"&screenshot=12";
        else
            text = text+"?screenshot=12";

       $('.ml_site_url').attr('href',text);
    });


//////////end ready
});

function getScreenshot(){
    html2canvas(document.body, {
        onrendered: function (canvas) {
            var canvasImg = canvas.toDataURL("image/png");
            //$('#canvasImg').html('<img src="'+canvasImg+'" alt="">');
            $('#canvasImg').attr("href",canvas.toDataURL("image/png"));
            $('#canvasImg').attr("download","Test.png");
            $('#canvasImg')[0].click();
            //window.open(canvas.toDataURL("image/jpg"));

        }
    });

}

function  open_container(){
    $('#myModal').modal('show');
}


