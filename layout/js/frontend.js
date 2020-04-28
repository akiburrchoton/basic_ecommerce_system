// JS FILE

//Login page - form switch 
    $(function(){
        'use strict';

        // Switch - login & logout form

        $('.login-page h1 span').click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');
        
            $('.login-page form').hide();
        
            $('.' + $(this).data('class')).fadeIn("500");
        });
    });


//Live name update un create new add page
    $('#live-title').keyup(function() {
        $('.live-preview .caption h3').text($(this).val());
    });
    $('#live-desc').keyup(function() {
        $('.live-preview .caption p').text($(this).val());
    });
    $('#live-price').keyup(function() {
        $('.live-preview .live-price').text('$' + $(this).val());
    });




