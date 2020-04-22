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
            
            // Select All Users from Users table
            $query1 =   "SELECT 
                            items.*, 
                            categories.Cat_name,
                            users.Username 
                        FROM 
                            items 
                        INNER JOIN 
                            categories 
                        INNER JOIN 
                            users 
                        ON 
                            items.Cat_ID  = categories.Cat_id
                        AND 
                            items.User_ID = users.UserID 
                        ORDER BY 
                            Item_ID";

            $stmt  = $connection->prepare($query1);
            $stmt->execute();
            $items = $stmt->fetchAll();

            if(!empty($items)){
?>

                <div class="container">
                    <div class="row">
                         
                        <div class="text-center">
                            <table class="table table-responsive table-bordered ">
                                    
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Description</td>
                                        <td>Price</td>
                                        <td>Date</td>
                                        <td>Category</td>
                                        <td>Username</td>
                                        <td>Control</td>
                                    </tr>
                                </thead>

                                <tbody >
                                    <?php 
                                        foreach ($items as $item) {
                                            echo "<tr>";
                                                echo "<td>{$item['Item_ID']}</td>";
                                                echo "<td>{$item['Item_name']}</td>";
                                                echo "<td>{$item['Item_description']}</td>";
                                                echo "<td>{$item['Item_price']}</td>";
                                                echo "<td>{$item['Item_date']}</td>";
                                                echo "<td>{$item['Cat_name']}</td>";
                                                echo "<td>{$item['Username']}</td>";
                                                echo "<td><p><a href='items.php?do=edit&itemid={$item['Item_ID']}' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a></p><p> <a href='items.php?do=delete&itemid={$item['Item_ID']}' class='btn btn-danger'><i class='fa fa-close'></i>Delete</a></p>";
                                                    if ($item['Item_approval'] == 0) {
                                                        echo "<p><a href='items.php?do=approve&itemid={$item['Item_ID']}' class='btn btn-warning'><i class='fa fa-check'></i>Approve</a></p>";
                                                    };
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>

                            </table>
                        </div>

                        <?php echo '<a href="items.php?do=add"><button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item</button></a>';?>
                    </div>
                </div>

<?php
            }// End of nested if(!empty($items))
             
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

                            <!-- Start Items User Field -->
                            <div class="form-group">
                                <select name="item_userid" class="form-control">
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
                            
                            <!-- Add Item Button -->
                            <div class="form-group">
                                <input type="submit" value="Add Item" class="btn btn-primary">
                            </div>
                        </form>
                    
                    </div>
                </div>
            </div>
            
<?php   
        } // Add Page ends here
        elseif ($do == 'insert') { // Insert Page starts here
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo "<h1 class='text-center'>Insert New Item</h1>";

                $item_name      = $_POST['item_name'];
                $item_desc      = $_POST['item_desc'];
                $item_price     = $_POST['item_price'];
                $item_country   = $_POST['item_country'];
                $item_status    = $_POST['item_status'];
                $item_category  = $_POST['item_category'];
                $item_userid    = $_POST['item_userid'];
                 

                // Validation for items
                $formErrors   = array();

                //Item Name validation
                if(empty($item_name)){
                    $formErrors[] = '<div class="alert alert-danger">Item name cannot be empty</div>';
                }
                 

                //Description validation
                if(empty($item_desc)){
                    $formErrors[] = '<div class="alert alert-danger">Description cannot be empty.</div>';
                }

                //Item Price validation
                if(empty($item_price)){
                    $formErrors[] = '<div class="alert alert-danger">Item Price cannot be empty.</div>';
                }

                //Email validation
                if(empty($item_country)){
                    $formErrors[] = '<div class="alert alert-danger">Country cannot be empty.</div>';
                }

                //Item Status validation
                if($item_status == 0){
                    $formErrors[] = '<div class="alert alert-danger">You must select the condition of the product</div>';
                }
                
                //Item Category validation
                if($item_status == 0){
                    $formErrors[] = '<div class="alert alert-danger">You must select the condition of the product</div>';
                }

                //Item Category validation
                if($item_category == 0){
                    $formErrors[] = '<div class="alert alert-danger">You must select the category of the product</div>';
                }
                
                //Item User validation
                if($item_userid == 0){
                    $formErrors[] = '<div class="alert alert-danger">You must select the user of the product</div>';
                }

                // Loop the errors inside the array 
                foreach ($formErrors as $error) {
                    echo '<div class="alert alert-danger">{$error}}</div>';
                }

                // If no error exists, proceed to insert item
                if(empty($formErrors)) {
                    // Insert new item info into 'items' table in the database
                    $stmt = $connection->prepare("INSERT INTO items(Item_name, Item_description, Item_price, Item_date, Item_country, Item_status, Cat_ID, User_ID) VALUES(:zitem_name, :zitem_desc, :zitem_price, now(), :zitem_country, :zitem_status, :zitem_category,:zitem_userid)");

                    $stmt ->execute([
                        'zitem_name'       => $item_name,
                        'zitem_desc'       => $item_desc,
                        'zitem_price'      => $item_price,
                        'zitem_country'    => $item_country,
                        'zitem_status'     => $item_status,
                        'zitem_category'   => $item_category,
                        'zitem_userid'     => $item_userid
                    ]);

                    // Success Message
                    $message = "<div class='alert alert-success'> {$stmt->rowCount()} item has been added.</div>";
                    redirectHome($message, 'back', 7);
                }

            }else{
                // Error Message
                echo "<div class='container'>";
                    $message = '<div class="alert alert-danger">Error Occured!</div>';
                    redirectHome($message, 'back', 5);
                echo "</div>";    
            }

        } // Insert Page ends here
        elseif ($do == 'edit') {
                // Check the get is numeric or not 
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; 

                // Select all data depends on the UserID. 
                $stmt = $connection->prepare("SELECT * FROM items WHERE Item_ID = ? ");
                // Execute query
                $stmt ->execute([$itemid]);
                // Fetch all the data depending on the $itemid
                $row = $stmt -> fetch();
                // Count Row
                $count = $stmt -> rowCount();
                if($count > 0){ // Nested if Starts here    
                                  
?>
                <!-- Write html code for 'do==edit' here -->

                <!-- Create form for Item Edit page  -->
                <div class="container">
                    <div class="row">
                       
                        <div class="col-lg-12">
                            <h1 class="text-center">Edit Item</h1>
                        </div>

                        <!-- Member Edit page form starts here  -->
                        <div class="col-lg-6 offset-lg-3">
                            <form action="?do=update" method="POST">

                                <!-- Hidden field for item ID  -->
                                <input type="hidden" name="itemid" value="<?= $itemid;?>">
                                    
                                <!-- Item name Field -->
                                <div class="form-group">
                                    <input type="text" name="item_name" class="form-control" value="<?= $row['Item_name']; ?>" autocomplete="off">
                                </div>

                                
                                <!-- Description Field -->
                                <div class="form-group">
                                    <input type="text" name="item_desc" class="form-control" value="<?= $row['Item_description']; ?>"  >
                                </div>

                                <!-- Price Field -->
                                <div class="form-group">
                                    <input type="text" name="item_price" class="form-control" value="<?= $row['Item_price']; ?>"  >
                                </div>

                                <!-- Country Field -->
                                <div class="form-group">
                                    <input type="text" name="item_country" class="form-control" value="<?= $row['Item_country']; ?>"  >
                                </div>

                                <!-- Start Items Status Field -->
                                <div class="form-group">
                                    <select name="item_status" class="form-control">
                                        <option value="0">Status</option> 
                                        <option value="1" <?php if($row['Item_status'] == 1){ echo "selected"; }?> >New</option> 
                                        <option value="2" <?php if($row['Item_status'] == 2){ echo "selected"; }?> >Semi New</option> 
                                        <option value="3" <?php if($row['Item_status'] == 3){ echo "selected"; }?> >Used</option> 
                                        <option value="4" <?php if($row['Item_status'] == 4){ echo "selected"; }?> >Old</option> 
                                    </select>
                                </div>
                                <!-- End Items Status Field -->

                                <!-- Start Items Category Field -->
                                <div class="form-group">
                                    <select name="item_category" class="form-control">
                                        <option value="0">Select Category</option>
                                            <?php
                                                $stmt = $connection->prepare("SELECT * FROM categories");
                                                $stmt->execute();
                                                $categories = $stmt->fetchAll();

                                                foreach ($categories as $cat) {
                                                    echo "<option value='{$cat['Cat_id']}'" ;
                                                        if($row['Cat_ID'] == $cat['Cat_id']){
                                                            echo "selected"; 
                                                        }
                                                    echo ">{$cat['Cat_name']}</option>";
                                                }
                                            ?>    
                                    </select>
                                </div>
                                <!-- End Items Category Field -->

                                <!-- Start Items User Field -->
                                <div class="form-group">
                                    <select name="item_userid" class="form-control">
                                        <option value="0">Select User</option>
                                            <?php
                                            
                                                $stmt = $connection->prepare("SELECT * FROM users");
                                                $stmt->execute();
                                                $users = $stmt->fetchAll();
 
                                                foreach ($users as $user) {
                                                echo "<option value='{$user['UserID']}'"; 
                                                    if($row['User_ID'] == $user['UserID']){
                                                        echo "selected";
                                                    }
                                                echo ">{$user['Username']}</option>";
                                                }
                                            ?>  
                                    </select>
                                </div>
                                <!-- End Items User Field -->

                                <div class="form-group">
                                    <input type="submit" value="Update Item" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                        <!-- Member Edit page form ends here  -->

                    </div>
                </div>

                <!-- Write html code for 'do==edit' here -->
                                          
<?php
                } // Nested if ends here

        }// Edit Page ends here
        elseif ($do == 'update') {// Update Page Starts here
            
            echo "<h1 class='text-center'>Update Items</h1>";
            
            echo "<div class='container'>";
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $item_id        = $_POST['itemid'];
                    $item_name      = $_POST['item_name'];
                    $item_desc      = $_POST['item_desc'];
                    $item_price     = $_POST['item_price'];
                    $item_country   = $_POST['item_country'];
                    $item_status    = $_POST['item_status'];
                    $item_category  = $_POST['item_category'];
                    $item_userid    = $_POST['item_userid'];

                    // Validation for items
                    $formErrors   = array();

                    //Item Name validation
                    if(empty($item_name)){
                        $formErrors[] = '<div class="alert alert-danger">Item name cannot be empty</div>';
                    }
                    

                    //Description validation
                    if(empty($item_desc)){
                        $formErrors[] = '<div class="alert alert-danger">Description cannot be empty.</div>';
                    }

                    //Item Price validation
                    if(empty($item_price)){
                        $formErrors[] = '<div class="alert alert-danger">Item Price cannot be empty.</div>';
                    }

                    //Email validation
                    if(empty($item_country)){
                        $formErrors[] = '<div class="alert alert-danger">Country cannot be empty.</div>';
                    }

                    //Item Status validation
                    if($item_status == 0){
                        $formErrors[] = '<div class="alert alert-danger">You must select the condition of the product</div>';
                    }
                    
                    //Item Category validation
                    if($item_category == 0){
                        $formErrors[] = '<div class="alert alert-danger">You must select the category of the product</div>';
                    }

                    //Item User validation
                    if($item_userid == 0){
                        $formErrors[] = '<div class="alert alert-danger">You must select the user of the product</div>';
                    }

                    // Loop the errors inside the array 
                    foreach ($formErrors as $error) {
                        echo '<div class="alert alert-danger">{$error}}</div>';
                    }

                    // Check is there is no error -> proceed to update
                    if(empty($formErrors)){
                        
                        $stmt = $connection->prepare("UPDATE items SET Item_name = ?, Item_description = ?, Item_price = ?, Item_country = ?, Item_status = ?, Cat_ID = ?, User_ID = ? WHERE Item_ID = ?");
                        $stmt->execute([
                            $item_name,
                            $item_desc,
                            $item_price,
                            $item_country,
                            $item_status,
                            $item_category,
                            $item_userid,
                            $item_id
                        ]);
                        
                        // Success Message
                        $message = "<div class='alert alert-success'>{$stmt->rowCount()} record is updated</div>";
                        redirectHome($message, 'back', 5);
                    }// Nested if ends here

                }// if ends here 
                else{
                    // Failure Message
                    $message = "<div class='alert alert-danger'>Sorry, You cannot browse this page!</div>";
                    redirectHome($message, 'back', 5);
                }

            echo "</div>";

        }// Update Page Ends here
        elseif ($do == 'delete') {// Delete Page Starts here
            echo "<h1 class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";
                // Delete items with all info
                // Check the get is numeric or not 
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                //Select all the datum depending on the itemid
                $checkitem = checkItem("Item_ID", "items", $itemid);

                if ($checkitem > 0) {
                    $stmt = $connection->prepare("DELETE FROM items WHERE Item_ID = ?");
                    $stmt->execute([$itemid]);

                    // Success Message
                    $message = "<div class='alert alert-success'>{$stmt->rowCount()} record is deleted</div>";
                    redirectHome($message, 'back', 5);
                }else{
                    // Failure Message
                    $message = "<div class='alert alert-danger'>This ID does not exist!</div>";
                    redirectHome($message, 'back', 5);
                }
            echo "</div>";

        } // Delete Page Ends here
        elseif ($do == 'approve') {// Active Page Starts here
            echo "<h1 class='text-center'>Active Item</h1>";
            echo "<div class='container'>";
                
                // Check the get is numeric or not 
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
                
                //Select all the datum depending on the itemid
                $checkitem = checkItem("Item_ID", "items", $itemid);

                if ($checkitem > 0) {
                    $stmt = $connection->prepare("UPDATE items SET Item_approval = 1 WHERE Item_ID = ?");
                    $stmt->execute([$itemid]);

                    // Success Message
                    $message = "<div class='alert alert-success'>{$stmt->rowCount()} item is approved</div>";
                    redirectHome($message, 'back', 5);
                }else{
                    // Failure Message
                    $message = "<div class='alert alert-danger'>This ID does not exist!</div>";
                    redirectHome($message, 'back', 5);
                }

            echo "</div>";
        }// Active Page Ends here
        include $tpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }   


    // Output Buffering Ends Here
    ob_end_flush();

?>