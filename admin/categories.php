<?php

    /*=======================================================================
    =   Use this page for Category Page,
    =   Edit, Update, Delete Categories
    =======================================================================*/

    // Output Buffering Starts Here
    ob_start();

    session_start();
    $pageTitle = 'Categories';

    if (isset($_SESSION['Username'])) {
        include 'init.php';


        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

        if ($do == 'manage') {// Manage Page starts here

            // echo '<a href="categories.php?do=add"><button type="submit" class="btn btn-primary">Add New Category</button></a>';

            $sort = 'ASC';

            $sort_array = array('ASC', 'DESC');

            if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array ) ){
                $sort = $_GET['sort'];
            }

            $stmt2 = $connection->prepare("SELECT * FROM categories WHERE Cat_parent = 0 ORDER BY Cat_ordering $sort");

            $stmt2->execute();

            $cats = $stmt2->fetchAll();


            $stmt3 = $connection->prepare("SELECT * FROM categories WHERE Cat_parent != 0 ORDER BY Cat_ordering $sort");

            $stmt3->execute();

            $subCats = $stmt3->fetchAll();

                if(!empty($cats) || !empty($subCats)){ 
?>
                    
                    <div class="container"><!-- Start Container Div -->
                        <!-- Parent Category Section -->
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="text-center">Manage Category</h1>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Categories</strong> 
                                        <div class="pull-right">
                                            Ordering: [ <a class="<?php if($sort == 'ASC'){ echo 'active'; }   ?>" href="?sort=ASC">ASC</a> | <a class="<?php if($sort == 'DESC'){ echo 'active'; } ?>" href="?sort=DESC">DESC</a> ]
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <?php

                                            foreach ($cats as $cat) {
                                                echo "<div class='container'>";
                                                    echo '<div class="category-item">';
                                                        echo '<div class="row">';

                                                                echo '<div class="col-lg-10">';
                                                                // [USE: {} for concatanation rather than using dot (.)]
                                                                echo "<h4>{$cat['Cat_name']}</h4>";
                                                                echo "<p>"; if($cat['Cat_description'] == ''){ echo 'This category has no description.';}else{echo $cat['Cat_description'];}
                                                                echo "</p>";
                                                                
                                                                if ($cat['Cat_visibility'] == 1) {
                                                                    echo "<span class='cat-info activee'><i class='fa fa-check'></i>Active</span>";
                                                                }else{
                                                                    echo "<span class='cat-info disablee'><i class='fa fa-times'></i>Hidden</span>";
                                                                }

                                                                if ($cat['Cat_comments'] == 1) {
                                                                    echo "<span class='cat-info activee'><i class='fa fa-check'></i>Comments On</span>";
                                                                }else{
                                                                    echo "<span class='cat-info disablee'><i class='fa fa-times'></i>Comments Off</span>";
                                                                }

                                                                if ($cat['Cat_ads'] == 1) {
                                                                    echo "<span class='cat-info activee'><i class='fa fa-check'></i>Ads Allowed</span>";
                                                                }else{
                                                                    echo "<span class='cat-info disablee'><i class='fa fa-times'></i>Ads Disallowed</span>";
                                                                }

                                                            echo '</div>';

                                                            echo '<div class="col-lg-2">';
                                                                echo "<a href='categories.php?do=edit&catid={$cat['Cat_id']}' class='btn btn-primary'>Edit</a>" ;
                                                                echo "<span> </span>";
                                                                echo "<a href='categories.php?do=delete&catid={$cat['Cat_id']}' class='btn btn-danger'>Delete</a>" ;
                                                            echo '</div>';
                                                        echo '</div>';

                                                    echo '</div>';
                                                echo "</div>";
                                            }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <!-- Child Category Section -->
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Sub Categories</strong> 
                                        <div class="pull-right">
                                            Ordering: [ <a class="<?php if($sort == 'ASC'){ echo 'active'; }   ?>" href="?sort=ASC">ASC</a> | <a class="<?php if($sort == 'DESC'){ echo 'active'; } ?>" href="?sort=DESC">DESC</a> ]
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            
                                            foreach ($subCats as $subCat) {
                                                $stt= $connection->prepare("SELECT Cat_name FROM categories WHERE Cat_id ={$subCat['Cat_parent']}");
                                                $stt->execute();
                                                $parent= $stt->fetch();
                                                
                                                echo "<div class='container'>";
                                                    echo '<div class="category-item">';
                                                        echo '<div class="row">';

                                                            echo '<div class="col-lg-10">';
                                                                // [USE: {} for concatanation rather than using dot (.)]
                                                                echo "<h4>{$subCat['Cat_name']}</h4>";
                                                                echo "<p>"; 
                                                                    if($subCat['Cat_description'] == ''){ 
                                                                        echo 'This category has no description.';
                                                                    }else{
                                                                        echo $subCat['Cat_description'];
                                                                    }
                                                                echo "</p>"; 

                                                                echo "<p class='child-parent'>Parent: {$parent['Cat_name']}</p>"; 
                                                                
                                                                if ($subCat['Cat_visibility'] == 1) {
                                                                    echo "<span class='cat-info activee'><i class='fa fa-check'></i>Active</span>";
                                                                }else{
                                                                    echo "<span class='cat-info disablee'><i class='fa fa-times'></i>Hidden</span>";
                                                                }
                                                                
                                                                if ($subCat['Cat_comments'] == 1) {
                                                                    echo "<span class='cat-info activee'><i class='fa fa-check'></i>Comments On</span>";
                                                                }else{
                                                                    echo "<span class='cat-info disablee'><i class='fa fa-times'></i>Comments Off</span>";
                                                                }

                                                                if ($subCat['Cat_ads'] == 1) {
                                                                    echo "<span class='cat-info activee'><i class='fa fa-check'></i>Ads Allowed</span>";
                                                                }else{
                                                                    echo "<span class='cat-info disablee'><i class='fa fa-times'></i>Ads Disallowed</span>";
                                                                }

                                                            echo '</div>';

                                                            echo '<div class="col-lg-2">';
                                                                echo "<a href='categories.php?do=edit&catid={$subCat['Cat_id']}' class='btn btn-primary'>Edit</a>" ;
                                                                    echo "<span> </span>";
                                                                echo "<a href='categories.php?do=delete&catid={$subCat['Cat_id']}' class='btn btn-danger'>Delete</a>" ;
                                                            echo '</div>';

                                                        echo '</div>';
                                                    echo '</div>';
                                                echo "</div>";
                                            }

                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                        <div class="col-lg-12">
                                <a href="categories.php?do=add" class="btn btn-primary mt-3"><i class="fa fa-plus"></i> Add New Category</a>
                            </div>
                        </div>
                    </div><!-- End Container Div -->
                    
                    
<?php           
                }

        } // Manage Page starts here

        else if ($do == 'add') { 
?>  <!-- Add Page starts here -->

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-center">Add New Category</h1>
                    </div>
                    

                    <!-- Form Starts Here -->
                    <div class="col-lg-6 offset-lg-3">
                        <form action="?do=insert" method="POST">
                        
                            <!-- Category Name Field Starts -->
                            <div class="form-group">
                                <input type="text" name="category_name" class="form-control" placeholder="Category Name" required="required">
                            </div>
                            <!-- Category Name Field Ends -->
                            
                            <!-- Category Description Field Starts -->
                            <div class="form-group">
                                <input type="text" name="category_desc" class="form-control" placeholder="Description"  autocomplete="off">
                            </div>
                            <!-- Category Description Field Ends -->
                            
                            <!-- Sub-category Parent Field Starts -->
                            <div class="form-group">
                                <select name="cat_parent"   class="form-control">
                                    <option value="0">None</option>
                                    <?php
                                        $allCats = getAllFrom("*", "categories", "WHERE Cat_parent = 0", "", "Cat_id", "DESC");
                                        
                                        foreach ($allCats as $category) {
                                            echo "<option value='{$category['Cat_id']}'>{$category['Cat_name']}</option>";
                                        }
                                    ?>  

                                </select>
                            </div>
                            <!-- Sub-category Parent Field Ends -->

                            <!-- Category Ordering Field Starts -->
                            <div class="form-group">
                                <input type="text" name="category_order" class="form-control" placeholder="Order in Number" required="required" autocomplete="off">
                            </div>
                            <!-- Category Ordering Field Ends -->

                            <!-- Category Visibility Field Starts -->
                            <div class="form-group">
                                <label>Visibility</label>
                                 <div class="input-group">
                                    <div>
                                        <input type="radio" name="cat_visibility" id="cat_visibility_no" value="0" checked>
                                        <label for="">No</label>
                                    </div> 
                                    <div>
                                        <input type="radio" name="cat_visibility" id="cat_visibility_yes" value="1" >
                                        <label for="">Yes</label>
                                    </div>
                                 </div>
                            </div>
                            <!-- Category Visibility Field Ends -->

                            <!-- Category Comment Field Starts -->
                            <div class="form-group">
                                <label>Allow Comment</label>
                                 <div class="input-group">
                                    <div>
                                        <input type="radio" name="cat_commenting" id="cat_com_no" value="0" checked>
                                        <label for="">No</label>
                                    </div> 
                                    <div>
                                        <input type="radio" name="cat_commenting" id="cat_com_yes" value="1" >
                                        <label for="">Yes</label>
                                    </div>
                                 </div>
                            </div>
                            <!-- Category Comment Field Ends -->

                            <!-- Category Ads Field Starts -->
                            <div class="form-group">
                                <label>Allow Ads</label>
                                 <div class="input-group">
                                    <div>
                                        <input type="radio" name="category_ads" id="cat_ads_no" value="0" checked>
                                        <label for="">No</label>
                                    </div> 
                                    <div>
                                        <input type="radio" name="category_ads" id="cat_ads_yes" value="1" >
                                        <label for="">Yes</label>
                                    </div>
                                 </div>
                            </div>
                            <!-- Category Ads Field Ends -->


                            <!-- Add Category Button -->
                            <div class="form-group">
                                <input type="submit" value="Add Category" class="btn btn-primary">
                            </div>

                        </form>
                    </div>
                    <!-- Form Ends Here -->
                </div>
            </div>

<?php
        } // Add Page starts here
        else if ($do == 'insert') { // Insert Page starts here
             
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo '<h1 class="text-center">Insert New Category</h1>';
                
                // Get All The Variable from The Form(Add)

                $category_name  = $_POST['category_name'];
                $category_desc  = $_POST['category_desc'];
                $cat_parent     = $_POST['cat_parent'];
                $category_order = $_POST['category_order'];
                $cat_visibility = $_POST['cat_visibility'];
                $cat_commenting = $_POST['cat_commenting'];
                $category_ads   = $_POST['category_ads'];

                // echo $category_name . $category_desc . $cat_parent. $category_order.$cat_visibility.$cat_commenting.$category_ads;

                $check_category = checkItem("Cat_name", "categories", $category_name); 

                if($check_category == 1){
                    $message = "<div class='alert alert-danger'>This Category Already Exists</div>";
                    echo $message;
                    redirectHome($message, 'back', 3);
                }else{
                    // Insert The Category Info Into Database 
                    $stmt = $connection->prepare("INSERT INTO categories (Cat_name, Cat_description, Cat_parent, Cat_ordering,Cat_visibility,Cat_comments,Cat_ads) VALUES (:zcategory_name, :zcategory_desc, :zcat_parent, :zcategory_order, :zcat_visibility, :zcat_commenting, :zcategory_ads)  ");

                    $stmt->execute([
                        ':zcategory_name'     => $category_name,
                        ':zcategory_desc'     => $category_desc,
                        ':zcat_parent'        => $cat_parent,
                        ':zcategory_order'    => $category_order,
                        ':zcat_visibility'    => $cat_visibility,
                        ':zcat_commenting'    => $cat_commenting,
                        ':zcategory_ads'      => $category_ads 
                    ]);

                    // Echo Success Message 

                    $message = "<div class='alert alert-success'>{$stmt->rowCount()} record have been updated</div>";
                    redirectHome($message, 'back', 7);
                }
            
            }else{

                echo "<div class='container'>";

                    $message = "<div class='alert alert-danger'>Sorry, Your aren\'t allowed to access here!</div>";
                    echo $message;
                    redirectHome($message, 'back', 3);

                echo "</div>";
            }

        } // Insert Page ends here
        
        else if ($do == 'edit') {
            
            // This [$catid] is acutally getting the 'category ID' through URL by using GET[] method. 
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

            // Select All Data Depending on this Category ID 
            $stmt   = $connection->prepare("SELECT * FROM categories WHERE Cat_id = ?");
            $stmt->execute([$catid]);
            $cat    = $stmt->fetch();
            $count  = $stmt->rowCount();

            if($count > 0){?>
                
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="text-center">Edit Category</h1>
                        </div>
                        
                        <div class="col-lg-12">
                            
                            <form action="?do=update" method="POST">
                                <input type="hidden" name="catid" value="<?= $catid;?>" >

                                <!-- Category Name Field Starts -->
                                <div class="form-group">
                                    <input type="text" name="category_name" class="form-control" value="<?= $cat['Cat_name'];?>">
                                </div>
                                <!-- Category Name Field Ends -->
                                
                                <!-- Category Description Field Starts -->
                                <div class="form-group">
                                    <input type="text" name="category_desc" class="form-control" value="<?= $cat['Cat_description'];?>" autocomplete="off">
                                </div>
                                <!-- Category Description Field Ends -->
                                
                                <!-- Sub-category Parent Field Starts -->
                                <div class="form-group">
                                    <select name="cat_parent" class="form-control">
                                        <option value="0">None</option>
                                        <?php
                                            // Function - Which can call all the parent categories
                                            $allCats = getAllFrom("*", "categories", "WHERE Cat_parent = 0", "", "Cat_id", "DESC");
                                            
                                            foreach ($allCats as $category) {
                                                echo "<option value='{$category['Cat_id']}'>{$category['Cat_name']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!-- Sub-category Parent Field Ends -->

                                <!-- Category Ordering Field Starts -->
                                <div class="form-group">
                                    <input type="text" name="category_order" class="form-control" value="<?= $cat['Cat_ordering'];?>" required="required" autocomplete="off">
                                </div>
                                <!-- Category Ordering Field Ends -->

                                <!-- Category Visibility Field Starts -->
                                <div class="form-group">
                                    <label>Visibility</label>
                                    <div class="input-group">
                                        <div>
                                            <input type="radio" name="cat_visibility" id="cat_visibility_no" <?php if($cat['Cat_visibility'] == 0 ){ echo "checked"; } ?> >
                                            <label for="">No</label>
                                        </div> 
                                        <div>
                                            <input type="radio" name="cat_visibility" id="cat_visibility_yes" value="1" <?php if($cat['Cat_visibility'] == 1 ){ echo "checked"; } ?> >
                                            <label for="">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Category Visibility Field Ends -->

                                <!-- Category Comment Field Starts -->
                                <div class="form-group">
                                    <label>Allow Comment</label>
                                    <div class="input-group">
                                        <div>
                                            <input type="radio" name="cat_commenting" id="cat_com_no"  <?php if($cat['Cat_comments'] == 0 ){ echo "checked"; } ?> >
                                            <label for="">No</label>
                                        </div> 
                                        <div>
                                            <input type="radio" name="cat_commenting" id="cat_com_yes" value="1" <?php if($cat['Cat_comments'] == 1 ){ echo "checked"; } ?> >
                                            <label for="">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Category Comment Field Ends -->

                                <!-- Category Ads Field Starts -->
                                <div class="form-group">
                                    <label>Allow Ads</label>
                                    <div class="input-group">
                                        <div>
                                            <input type="radio" name="category_ads" id="cat_ads_no" <?php if($cat['Cat_ads'] == 0 ){ echo "checked"; } ?> >
                                            <label for="">No</label>
                                        </div> 
                                        <div>
                                            <input type="radio" name="category_ads" id="cat_ads_yes" value="1" <?php if($cat['Cat_ads'] == 1 ){ echo "checked"; } ?> >
                                            <label for="">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Category Ads Field Ends -->

                                <div class="form-group">
                                    <input type="submit" value="Update Category" class="btn btn-primary">
                                </div>
                            </form>

                        </div>


                    </div>
                </div>

<?php       }else{

                echo "<div class='contanier'>";
                    $message = '<div class="alert alert-danger">There is no such category.</div>';
                echo "</div>";

            }
            
        }// Edit Page ends here
        else if ($do == 'update'){ ?> <!-- // Update Page Starts here -->

                <div class="container">
                    <div class="row">

                        <div class="col-lg-12">
                            <h1 class="text-center">Update Category</h1>
                        </div>
                        
                        <div class="col-lg-12">
                            <?php
                                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                    // Get all the info from Edit page form and update those in Database. 
                                    $cat_id         = $_POST['catid']; // This catid is from line 258 through URL.  
                                    $category_name  = $_POST['category_name'];
                                    $category_desc  = $_POST['category_desc'];
                                    $cat_parent     = $_POST['cat_parent'];
                                    $category_order = $_POST['category_order'];
                                    $cat_visibility = $_POST['cat_visibility'];
                                    $cat_commenting = $_POST['cat_commenting'];
                                    $category_ads   = $_POST['category_ads'];

                                    // Check if there is no error in proceeding the update operatiion

                                    if(empty($formErrors)){
                                        // Update The Database without any error

                                        $stmt = $connection->prepare("UPDATE categories SET Cat_name = ?, Cat_description = ?, Cat_parent = ?, Cat_ordering = ?, Cat_visibility = ?, Cat_comments = ?, Cat_ads = ? WHERE Cat_id = ? ");
                                        $stmt->execute([$category_name, $category_desc, $cat_parent, $category_order, $cat_visibility, $cat_commenting, $category_ads, $cat_id]);

                                        $message = "<div class='alert alert-success'>{$stmt->rowCount()} record has been updated.</div>";
                                        
                                        redirectHome($message, 'back', 5);
                                    }
                                }
                            ?>
                        </div>

                    </div>
                </div>

<?php   }// Update Page Ends here
        else if ($do == 'delete') { ?> <!-- // Delete Page Starts here -->
            
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    
                        <?php
                            echo '<h1 class="text-center">Delete Category</h1>';

                            // This [$catid] is acutally getting the 'category ID' through URL by using GET[] method. 
                            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                            //Select All Data From Database
                            $check_category = checkItem('Cat_id', 'categories', $catid);

                            if($check_category > 0){
                                $stmt = $connection->prepare("DELETE FROM categories WHERE Cat_id = :zcat_id");
                                $stmt->bindParam(":zcat_id", $catid);
                                $stmt->execute();

                                $message = "<div class='alert alert-success'>{$stmt->rowCount()} record has been removed.</div>";
                                redirectHome($message, 'back', 5);
                            }else{
                                $message = "<div class='alert alert-danger'>There is no such Category ID.</div>";
                                redirectHome($message, 'back', 5);
                            }

                        ?>

                    </div>
                </div>
            </div>

<?php   } // Delete Page Ends here
        
        
        // else if ($do == 'active') {// Active Page Starts here
        //     echo "WELCOME TO THE CATEGORY PAGE - ACTIVE";
        // }// Active Page Ends here


        include $tpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }   


    // Output Buffering Ends Here
    ob_end_flush();
?>