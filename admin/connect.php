<?php

    /* ==============================================
    = Database Connection Using PDO - [PHP Data Object]
       ============================================== 
    */

    $dbname     = 'mysql:host=localhost;dbname=ecom';
    $user       = 'choton';
    $pass       = 'ZzZz1VTiiMJ5Q8ik';

    $option     = array(
        PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES utf8'
    );

    try{
        $connection = new PDO($dbname, $user, $pass, $option);
        $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'Database Connection Completed!';
    }
    catch(PDOException $e){
        echo 'Database Connection Failed!';
    } 
?>