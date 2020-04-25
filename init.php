<?php 

    // Error Report
    ini_set('display_error', 'On');
    error_reporting(E_ALL);

    //Database Connection File
    include 'admin/connect.php';

    $sessionedUser = '';

    if(isset($_SESSION['user'])){
        $sessionedUser = $_SESSION['user'];
    }


    /* 
       ==============================================
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
    include $tpl  . 'navbar.php';
    include $tpl  . 'header.php';

    
?>