<?php

ob_start();

session_start();

$pageTitle = "Add New Item";

include 'init.php';

if (isset($_SESSION['user'])) {
//    echo "User ID of " . $_SESSION['user'] . " is " . $_SESSION['uid'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $name       = filter_var($_POST['item_name'], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['item_desc'], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['item_price'], FILTER_SANITIZE_NUMBER_INT);
        $country    = filter_var($_POST['item_country'], FILTER_SANITIZE_STRING);
        $status     = filter_var($_POST['item_status'], FILTER_SANITIZE_NUMBER_INT);
        $item_cat   = filter_var($_POST['item_cat'], FILTER_SANITIZE_NUMBER_INT);

            $formErrors = array();

            if (strlen($name) < 4) {
                $formErrors[] = 'Title must be at least 4 charecters'; 
            }
            if (strlen($desc) < 10) {
                $formErrors[] = 'Title must be at least 4 charecters'; 
            }
            if (empty($price)) {
                $formErrors[] = 'Price can\'t be empty'; 
            }
            if (strlen($country) < 2) {
                $formErrors[] = 'Country must be at least 2 charecters'; 
            }
            if (empty($status)) {
                $formErrors[] = 'You must choose item condition'; 
            }
            if (empty($item_cat)) {
                $formErrors[] = 'You must choose item category'; 
            }

            // If there is no errors proceed to - Insert item info to database
            $stmt =$connection->prepare("INSERT INTO items(Item_name, Item_description, Item_price, Item_date, Item_country, Item_status, Cat_ID, User_ID) VALUES (:zname, :zdesc, :zprice, now(), :zcountry, :zstatus, :zitem_cat, :zitem_user)");

            $stmt->execute([
                'zname'       => $name,
                'zdesc'       => $desc,
                'zprice'      => $price,
                'zcountry'    => $country,
                'zstatus'     => $status,
                'zitem_cat'   => $item_cat,
                'zitem_user'  => $_SESSION['uid']
            ]);

            // Success Message
                if ($stmt) {
                    $successMsg = 'Item is added successfully!';
                }
    }
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 card">
                    <div class="card-header">
                        <h4>Add New Item</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Create New Item Form Starts -->
                                <form class="add-item-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">

                                    <!-- Item name field - Start  -->
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Name</label>
                                        </div>

                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <input pattern=".{4,}" title="This field requires at least 4 charecters" type="text" name="item_name" class="form-control" autocomplete="off" placeholder="Item Name" id="live-title"  required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item Description field - Start  -->
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Description</label>
                                        </div>

                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <input pattern=".{10,}" title="This field requires at least 10 charecters" type="text" name="item_desc" class="form-control" autocomplete="off" placeholder="Item Description" id="live-desc" data-class=".live-desc" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price field - Start  -->
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Price</label>
                                        </div>

                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <input type="text" id="live-price" name="item_price" class="form-control" autocomplete="off" placeholder="Item Price" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Country field - Start  -->
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Country</label>
                                        </div>

                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <input type="text" name="item_country" class="form-control" autocomplete="off" placeholder="Item Country" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item Status field - Start  -->
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Status</label>
                                        </div>

                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <select name="item_status" class="form-control" required="required">
                                                    <option value="0">Condition</option>
                                                    <option value="1">New</option>
                                                    <option value="2">Semi New</option>
                                                    <option value="3">Used</option>
                                                    <option value="4">Old</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <!-- Item Category field - Start  -->
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Category</label>
                                        </div>

                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <select name="item_cat" class="form-control">
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
                                        </div>
                                    </div>

                                    


                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Add Item">
                                    </div>
                                </form>
                                <!-- Create New Item Form Ends -->
                            </div>

                            <!-- Right Side -->
                            <div class="col-lg-4">
                                <div class="add-item-box live-preview">
                                    <span class="price-tag live-price"><i class="fa fa-tag"></i> $ </span>
                                    <img src="layout/images/tandra.jpg" class="img-fluid img-center">

                                    <div class="caption">
                                        <h3 class="text-center live-title">Title</h3>
                                        <p class="text-center live-desc">Description</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <?php
                        
                            if(!empty($formErrors)){
                                foreach ($formErrors as $error) {
                                    echo "<div class='alert alert-danger'>{$error}</div>"; 
                                }
                            }

                            if (isset($successMsg)) {
                                echo "<div class='alert alert-success'>{$successMsg}</div>";
                            }

                        ?>

                    </div> <!-- Card Body ends -->
                </div>
            </div>
        </div>
    </section>

<?php

} else {
    header('Location:login.php');
    exit();
}


include $tpl . 'footer.php';

ob_end_flush();
?>