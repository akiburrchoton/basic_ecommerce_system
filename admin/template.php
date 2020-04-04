<?php

    /*=======================================================================
    =   Use this page for registering Member,
    =   Edit Memeber Profile, Update Memeber Profile, Delete Memeber Profile
    =   Delete Member Profile
    =   -> Super Admin can approve any user account or suspend
    =   GroupID { 1 => SuperAdmin, 2 => Vendor, 3 => Normal users }
    =======================================================================*/

    // Output Buffering Starts Here
    ob_start();

    session_start();
    $pageTitle = 'Members';

    if (isset($_SESSION['Username'])) {
        include 'init.php';


        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

        if ($do == 'manage') {// Manage Page starts here

        } // Manage Page starts here
        else if ($do == 'add') { // Add Page starts here

        } // Add Page starts here
        else if ($do == 'insert') { // Insert Page starts here
            
        } // Insert Page ends here
        else if ($do == 'edit') {
            
        }// Edit Page ends here
        else if ($do == 'update') {// Update Page Starts here

        }// Update Page Ends here
        else if ($do == 'delete') {// Delete Page Starts here
        } // Delete Page Ends here
        else if ($do == 'active') {// Active Page Starts here

        }// Active Page Ends here
        include $tpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }   


    // Output Buffering Ends Here
    ob_end_flush();
?>