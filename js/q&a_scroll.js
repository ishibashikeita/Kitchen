$(window).on('load', function (){
    $('.fadeIn').each(function(){
        $(function(){
            $('.fadeIn').each(function(i){
                $(this).delay(i * 200).queue(function(){
                    $(this).addClass('animated');
                });
            });
        });
    });
});
