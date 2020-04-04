<?php

    /*=======================================================================
    =   Use this page for Items Page,
    =   Edit, Update, Delete Items
    =======================================================================*/

    // Output Buffering Starts Here
    ob_start();

    session_start();
    $pageTitle = 'Members';

    if (isset($_SESSION['Username'])) {
        include 'init.php';


        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

        if ($do == 'manage') {// Manage Page starts here
            
            echo "<h1 class='text-center'>Manage Items</h1>";
            
        } // Manage Page starts here
        elseif ($do == 'add') { // Add Page starts here        
?>  
        <div class="container">
            <div class="row">
                
                <div class="col-lg-12">
                    <h1 class='text-center'>Add Items</h1> 
                </div>

                <div class="col-lg-6 offset-lg-3">

                    <form action="?do=insert" method="POST">
                        
                        <!-- Start Items Name Field -->
                        <div class="form-group">
                            <input type="text" name="item_name" class="form-control" autocomplete="off" placeholder="Item Name" required>
                        </div>
                        <!-- End Items Name Field -->
                        
                        <!-- Start Items Description Field -->
                        <div class="form-group">
                            <input type="text" name="item_desc" class="form-control" autocomplete="off" placeholder="Item Description" required>
                        </div>
                        <!-- End Items Description Field -->
                        
                        <!-- Start Items Price Field -->
                        <div class="form-group">
                            <input type="text" name="item_price" class="form-control" autocomplete="off" placeholder="Item Price" required>
                        </div>
                        <!-- End Items Price Field -->
                        
                        <!-- Start Items Country Field -->
                        <div class="form-group">
                            <input type="text" name="item_country" class="form-control" autocomplete="off" placeholder="Item Country" required>
                        </div>
                        <!-- End Items Country Field -->

                        
                        <!-- Start Items Status Field -->
                        <div class="form-group">
                            <select name="item_status" class="form-control">
                                <option value="0">Status</option>
                                <option value="1">New</option>
                                <option value="2">Semi New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                        <!-- End Items Status Field -->
                                
                        <!-- Start Items User Field -->
                        <div class="form-group">
                            <select name="item_status" class="form-control">
                                <option value="0">Select User</option>
                                    <?php
                                        $allUsers = getAllFrom("*", "users", "", "", "UserID", "DESC");
                                        
                                        foreach ($allUsers as $user) {
                                            echo "<option value='{$user['UserID']}'>{$user['Username']}</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                        <!-- End Items User Field -->
                        
                        <!-- Start Items Category Field -->
                        <div class="form-group">
                            <select name="item_category" class="form-control">
                                <option value="0">Select Category</option>
                                    <?php
                                        $allCats = getAllFrom("*", "categories", "WHERE Cat_parent = 0", "", "Cat_id", "ASC");
                                        
                                        foreach ($allCats as $category) {
                                            echo "<option value='{$category['Cat_id']}'>{$category['Cat_name']}</option>"; 

                                            $childCats = getAllFrom("*", "categories", "WHERE Cat_parent = {$category['Cat_id']}", "", "Cat_id", "ASC");

                                            foreach ($childCats as $child) {
                                                echo "<option value='{$child['Cat_id']}'>--- {$child['Cat_name']}</option>"; 
                                            }
                                        }
                                    ?>    
                            </select>
                        </div>
                        <!-- End Items Category Field -->

                    </form>
                
                </div>
            </div>
        </div>
            
<?php   } // Add Page starts here
        elseif ($do == 'insert') { // Insert Page starts here
            echo 'insert';
        } // Insert Page ends here
        elseif ($do == 'edit') {
            echo 'edit';
        }// Edit Page ends here
        elseif ($do == 'update') {// Update Page Starts here
            echo 'update';
        }// Update Page Ends here
        elseif ($do == 'delete') {// Delete Page Starts here
            echo 'delete';
        } // Delete Page Ends here
        elseif ($do == 'active') {// Active Page Starts here
            echo 'active';
        }// Active Page Ends here
        include $tpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }   


    // Output Buffering Ends Here
    ob_end_flush();
?>