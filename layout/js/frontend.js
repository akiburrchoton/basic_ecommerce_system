// JS FILE

$(function(){
    'use strict';

    // Switch - login & logout form

    $('.login-page h1 span').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');
     
        $('.login-page form').hide();
    
        $('.' + $(this).data('class')).fadeIn("500");
    });
});




