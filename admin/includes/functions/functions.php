<?php

    /*
    =====================================================================
    = Title function that echo the page title in case the page 
    = has the varibale $pageTitle and echo default title for other page
    =====================================================================
    */

    function getTitle(){
        global $pageTitle;

        if(isset($pageTitle)){
            echo $pageTitle;
        }else{
            echo 'Default';
        }
    }
    
    /*
    =====================================================================
    = Check items function - Check if current user exists or not
    = $select   = The item to SELECT from the table [Ex. Username, Fullname etc]  
    = $table     = The Table to SELECT from Database [ users ]
    = $value    = The value of SELECE [Ex. akibur, tandra etc]
    =====================================================================
    */

    function checkItem($select, $table, $value){

        // Make the MySQL query dynamic using $select, $table, $value [Being called from members page]
        global $connection ;

        $statement = $connection->prepare("SELECT $select FROM $table WHERE $select=? ");
        $statement -> execute(array($value));
        $count     = $statement->rowCount(); 

        return $count;

    }

    /*
    =====================================================================
    =  This function accepts parameter 
    =  $message = Echo the message [Error or Success or Warning]
    =  $url     = The link you want to redirect
    =  $seconds = after how many seconds it will redirect
    =====================================================================
    */
    function redirectHome($message, $url = null, $seconds = 3){
        if($url === null){
            $url    = 'index.php';
            $link   = 'Homepage';
        }else{
            // Condition ? True : False 
            
            $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php'; 
            $link = 'Previous Page'; 
        }
            echo $message; 
            echo "<div class='alert alert-info'>You will be redirected to $link after $seconds Seconds</div>";
            header("refresh:$seconds; url = $url"); // Refresh must be written as [refresh:$seconds]
            exit();
    }




    /*
    =====================================================================
    =  This function accepts parameter 
    =  $message = Echo the message [Error or Success or Warning]
    =  $url     = The link you want to redirect
    =  $seconds = after how many seconds it will redirect
    =====================================================================
    */
    // function getAllFrom($a, $b, $c, $d, $e, $f){
    //     if($url === null){
    //         $url    = 'index.php';
    //         $link   = 'Homepage';
    //     }else{
    //         // Condition ? True : False 
            
    //         $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php'; 
    //         $link = 'Previous Page'; 
    //     }
    //         echo $message; 

    //         echo "<div class='alert alert-info'>You will be redirected to $link after $seconds Seconds</div>";
    //         header("refresh:$seconds; url = $url"); // Refresh must be written as [refresh:$seconds]
    //         exit();
    // }



    /*
    =====================================================================
    =  Get the latest records  
    =  Function to get latest info database [Users, Items, Comments etc]
    =  $select     = Column to Select in Table
    =  $table      = Table we want to choose
    =  $order      = Ordering the items
    =  $limit      = How many users we want to choose.
    =====================================================================
    */
    function getLatest($select, $table, $order, $limit = 5){
        global $connection;

        $getStmt  = $connection->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $getStmt->execute();
        $rows     = $getStmt->fetchAll();
        return $rows;
    }


    /*
    =====================================================================
    =  Get all data from Database - getAllFrom()
    =====================================================================
    */
    function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderingfield, $ordertype){
        global $connection;

        $getAll = $connection->prepare("SELECT $field FROM $table $where $and ORDER BY $orderingfield $ordertype");
        $getAll->execute();
        $all = $getAll->fetchAll();
        
        return $all;
    }

    
    /*
    =====================================================================
    =  Count all the Users of the system
    =====================================================================
    */
    function countUsers($items, $table){
        global $connection;
        $stmt = $connection->prepare("SELECT COUNT($items) FROM $table");
        $stmt->execute();
        echo $stmt->fetchcolumn();
    }
?>