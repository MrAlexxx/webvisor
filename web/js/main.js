
$(document).ready(function(){
    $('.ml_prod_forecast').on('click',function(e){
        e.preventDefault();
        var name = $('[name="product"]').val();
        if(name!='')
            window.location.href = "/forecast/"+name;
    });

    $('.show_filter').on('click',function(){
        $("#w0-filters").toggle('height:100%').animate(700);
    });

//////////end ready
});
