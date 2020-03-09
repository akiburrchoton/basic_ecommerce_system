<?php 
    
    
    //Database Connection File
    include 'connect.php';

    
    /* ==============================================
    = Routing For Templates, Languages, Functions, CSS, JS, Images
       ============================================== 
    */
    

    $tpl    = 'includes/templates/';
    $lang   = 'includes/languages/';
    $func   = 'includes/functions/';
    $css    = 'layout/css/';
    $js     = 'layout/js/';
    $img    = 'layout/images/';


    include $func . 'functions.php';
    include $lang . 'english.php';
    include $tpl  . 'header.php';

    /* ==============================================
    = If anypage has the variable $noNavBar > Our Navbar will be hidden
    = If anypage has no instruction about the variable $noNavBar > Our Navbar will be shown
    ============================================== */
    
    if(!isset($noNavBar)){
        include $tpl. 'navbar.php';
    }
?>