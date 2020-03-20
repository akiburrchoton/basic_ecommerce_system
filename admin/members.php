<?php

/*=======================================================================
    =   Use this page for registering Member,
    =   Edit Memeber Profile, Update Memeber Profile, Delete Memeber Profile
    =   Delete Member Profile
    =   -> Super Admin can approve any user account or suspend
    =   GroupID { 1 => SuperAdmin, 2 => Vendor, 3 => Normal users }
    =======================================================================*/
    session_start();
    $pageTitle = 'Members';

    if (isset($_SESSION['Username'])) {
        include 'init.php';


        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

        if ($do == 'manage') {
            // Manage the vendor accounts 
            echo "<h5 class='text-center'>Welcome to the Super Admin Page</h5>";

            
            // Pending Member Approval Query
            $query = '';
            if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
                $query = 'AND ResStatus = 0';
            }

            // Select All Users from Users table
            $query1 = "SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID";
            $stmt  = $connection->prepare($query1);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if(!empty($rows)){
?>

                <div class="container">
                    <div class="row">
                        <div class="col-lg">
                            <hr>
                            <h1 class="text-center">Manage Members </h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td>#ID</td>
                                    <td>Profile Picture</td>
                                    <td>User Name</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Phone Number</td>
                                    <td>Address</td>
                                    <td>Reg Address</td>
                                    <td>Action</td>
                                </tr>

                                <?php
                                    
                                    foreach ($rows as $row) {
                                        $src = 'layout/images/avatar/'. $row['Avatar'];
                                        echo "<tr>";                                        
                                            echo "<td>" . $row['UserID'] . "</td>";   
                                            echo "<td><img src='{$src}' width='100px'></td>"; // Rather than using (.) I used { } to concatanate. 
                                            echo "<td>" . $row['Username'] . "</td>";  
                                            echo "<td>" . $row['FullName'] . "</td>";  
                                            echo "<td>" . $row['Email'] . "</td>";  
                                            echo "<td>" . $row['PhoneNumber'] . "</td>";  
                                            echo "<td>" . $row['PAddress'] . "</td>";  
                                            echo "<td>" . $row['Date'] . "</td>";  
                                            
                                            // Action Buttons
                                            echo "<td>  
                                            
                                            <a href='members.php?do=edit&userid=" . $row['UserID'] . " ' class='btn btn-success'>EDIT</a> 
                                            </br></br>
                                            <a href='members.php?do=delete&userid=" . $row['UserID'] . " ' class='btn btn-danger'>DELETE</a></br></br>";
                                            
                                            if($row['RegStatus'] == 0){
                                                echo "<a href='members.php?do=active&userid=" . $row['UserID'] . " ' class='btn btn-info'>ACTIVE</a>";
                                            }

                                            echo "</td>";  

                                        echo "</tr>";
                                    }
                                
                                ?>

                            </table>
                        </div>
                        <?php echo '<a href="members.php?do=add"><button type="submit" class="btn btn-primary">Add New Memeber</button></a>';?>
                    </div>
                </div>

<?php       
            }
?>

        <?php
        } else if ($do == 'add') { 
            
        ?>
            <!-- Write html code for 'do==add' here -->
            <section>
                <div class="container">
                    <div class="row">
                        <!--Heading title of Add new member page -->
                        <div class="col-lg-12">
                            <h1 class="text-center">Add New Member</h1>
                        </div>

                        <!--  Add new member registration form -->
                        <div class="col-lg-6 offset-lg-3">
                            <form action="?do=insert" method="POST" enctype="multipart/form-data">

                                <!-- Username Field -->
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username"  required="required">
                                </div>

                                <!-- Password Field -->
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password"  required="required">
                                </div>


                                <!-- Full Name Field -->
                                <div class="form-group">
                                    <input type="text" name="fullname" class="form-control" placeholder="Full Name"  required="required">
                                </div>

                                <!-- Email Field -->
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" required="required" >
                                </div>


                                <!-- Phone Field -->
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" required="required" >
                                </div>

                                <!-- Address Field -->
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" placeholder="Address"  required="required">
                                </div>

                                <!-- Avatar Field -->
                                <div class="form-group">
                                    <input type="file" name="avatar" class="form-control" required="required">
                                </div>

                                

                                <div class="form-group">
                                    <input type="submit" value="Register" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Write html code 'do==add' till here -->
        <?php
        } else if ($do == 'insert') { // Insert Page starts here
            
            
            // Insert or Register any new user here
            // echo $_POST['username'] . ' '  . $_POST['password'] . ' '  . $_POST['fullname'] . ' '  . $_POST['email'] . ' '  . $_POST['phone'] . ' '  . $_POST['address']; // Taking member's data from Add Member page


            // Insert page form for user info into database
            if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
                
                echo '<h1 class="text-center">Welcome New Member</h1>';


                //Container Starts here
                echo '<div class="container">';

                    // Upload Variable 
                    $avatar     = $_FILES['avatar'];
                    $avatarName = $_FILES['avatar']['name'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTemp = $_FILES['avatar']['tmp_name'];
                    $avatarType = $_FILES['avatar']['type'];

                    // Allowed Extension Types
                    $avatarAllowedExt = array("jpg", "jpeg", "png", "gif");

                    // Get Avatar Extension
                    $exploaded = explode('.', $avatarName);
                    $avatarExtension  = strtolower(end($exploaded));
 
                    // Get all the variable from the Form of Add page
                    $user       = $_POST['username'] ;
                    $pass       = $_POST['password'] ;
                    $fullname   = $_POST['fullname'] ;
                    $email      = $_POST['email']    ;
                    $phone      = $_POST['phone']    ;
                    $address    = $_POST['address']  ;

                    $hashedPass = sha1($pass);
                    // Validate Form
                    $formErrors   = array();

                    //Username validation
                    if(strlen($user)  < 4){
                        $formErrors[] = '<div class="alert alert-danger">Username cannot be less than 4 letters.</div>';
                    }
                    
                    //Username validation
                    if(strlen($user)  > 15){
                        $formErrors[] = '<div class="alert alert-danger">Username cannot be bigger than 15 letters.</div>';
                    }

                    //Password validation
                    if(empty($pass)){
                        $formErrors[] = '<div class="alert alert-danger">Password cannot be empty.</div>';
                    }

                    //Fullname validation
                    if(empty($fullname)){
                        $formErrors[] = '<div class="alert alert-danger">Fullname cannot be empty.</div>';
                    }

                    //Email validation
                    if(empty($email)){
                        $formErrors[] = '<div class="alert alert-danger">Email cannot be empty.</div>';
                    }

                    //Phone number validation
                    if(empty($phone)){
                        $formErrors[] = '<div class="alert alert-danger">Phone Number cannot be empty.</div>';
                    }

                    //Address validation
                    if(empty($address)){
                        $formErrors[] = '<div class="alert alert-danger">Address cannot be empty.</div>';
                    }

                    //Avatar validation
                    if(!empty($avatarName) && !in_array($avatarExtension, $avatarAllowedExt)){
                        $formErrors[] = '<div class="alert alert-danger">Picture type is not proper, Please use JPG, JPEG , PNG or GIF format.</div>';
                    }
                    
                    if(empty($avatarName)){
                        $formErrors[] = '<div class="alert alert-danger">Please Upload Your Profile Picture</div>';
                    }
                    
                    if(!empty($avatarSize) > 4194304){
                        $formErrors[] = '<div class="alert alert-danger">Picture is too large(more than <strong>4 MB</strong>)</div>';
                    }

                    foreach( $formErrors as $error ){
                        echo '<div class = "alert alert-danger">' . $error . '</div>';
                    }


                    // Check if there is no error > proceed the update operation
                    if(empty($formErrors)){

                        // Avatar checking
                        $avatar = rand(0, 1000000). '_' . $avatarName;

                        $uploadDirection = 'layout/images/avatar/';
                        move_uploaded_file($avatarTemp, "$uploadDirection/$avatar");

                        // Check userinfo exists in Database
                        $checkCurrentUser = checkItem("Username", "users", $user); 

                        if($checkCurrentUser == 1){
                            $message = '<div class="alert alert-danger">Sorry! User already exists.</div>'; 
                            
                            redirectHome($message, 'back', 5);
                        }else{
                            // Insert new member's info into the database
                            $stmt = $connection->prepare("INSERT INTO users(Username, Password, FullName, Email, PhoneNumber, PAddress,  RegStatus, Date, Avatar) VALUES(:zuser, :zpass, :zname, :zemail, :zphone, :zaddress, 0, now(), :zavatar )"); // :z for PDO format

                            $stmt -> execute(array(
                                'zuser'     => $user,
                                'zpass'     => $hashedPass,
                                'zname'     => $fullname,
                                'zemail'    => $email,
                                'zphone'    => $phone,
                                'zaddress'  => $address,
                                'zavatar'  => $avatar
                            ));

                            // Echo Success Message
                            $message = '<div class="alert alert-success">' . $stmt->rowCount() . ' user has been added.</div>';
                            
                            redirectHome($message, 'back', 7);
                        }
                    }else{
                    
                        //If there is no errors                    
                        echo "<div class='container'>";
                            $message = '<div class="alert alert-danger">Sorry, You cannot browse this page.</div>';
                            echo $message;
                            //3 no redirectHome($message, 'back', 10);
                        echo "</div>";

                    }


                echo '</div>'; //Container Ends here
            } // Form Ends here


        } // Insert Page ends here
        else if ($do == 'edit') { // Edit Page starts here
            
            // Members profile page edit
            
            // Condition : True ? False - to check if the GET Request is numeric & get the integer value of it  
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
 
            // Select all data depends on the UserID. 
            $stmt = $connection->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
            // Execute query
            $stmt ->execute(array($userid));
            // Fetch all the data depends on the ID
            $row = $stmt -> fetch();
            // Count Row
            $count = $stmt -> rowCount();

            if($count > 0){// Nested if ends here
                // echo "COUNT is = ". $count ;
                // echo "<br>UserID is = ". $userid ;
                // echo "<br>Username is = ". $row['Username'] ;
                  
        ?>

            <!-- Write html code for 'do==edit' here -->

            <!-- Create form for Members Profile Edit page  -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-center">Edit Your Profile</h1>
                    </div>

                    <!-- Member Edit page form starts here  -->
                    <div class="col-lg-6 offset-lg-3">
                        <form action="?do=update" method="POST">


                            <!-- Hidden field for USER ID  -->
                            <input type="hidden" name="userid" value="<?php echo $userid;?>">
                                
                            <!-- Username Field -->
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" value="<?= $row['Username']; ?>" autocomplete="off">
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <input type="hidden" name="oldPassword" class="form-control"  value="<?=  $row['Password'];?>" required='required'>
                                <input type="password" name="newPassword" class="form-control" placeholder="Enter New Password" autocomplete="New Password">
                            </div>

                            <!-- Avatar Field -->
                            <!-- <div class="form-group">
                                <input type="file" name="avatar" class="form-control" value="<?= $row['Avatar']; ?>" >
                            </div> -->

                            <!-- Full Name Field -->
                            <div class="form-group">
                                <input type="text" name="fullname" class="form-control" value="<?= $row['FullName']; ?>"  >
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" value="<?= $row['Email']; ?>"  >
                            </div>


                            <!-- Phone Field -->
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" value="<?= $row['PhoneNumber']; ?>"  >
                            </div>

                            <!-- Address Field -->
                            <div class="form-group">
                                <input type="text" name="address" class="form-control" value="<?= $row['PAddress']; ?>" >
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Update Profile" class="btn btn-primary">
                            </div>

                        </form>
                    </div>
                    <!-- Member Edit page form ends here  -->
                </div>
            </div>

            <!-- Write html code for 'do==edit' here -->
<?php       } // Nested if ends here
            else{
                echo "Nothing was edited!";
            }
        }// Edit Page ends here
        else if ($do == 'update') {// Update Page Starts here
            // Update user profile here  
            echo '<h1>Update User Profile</h1>';


            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Get all the variables(Sent Data) from the form(Edit Page form)
                $id           = $_POST['userid']  ;
                $user         = $_POST['username'];
                $fullname     = $_POST['fullname'];
                $email        = $_POST['email']   ;
                $phone        = $_POST['phone']   ;
                $address      = $_POST['address'] ;
                
                // echo $id . " " . $user . " " . $fullname;
                
                $pass         = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

                // Validate Form - EDIT Page
                $formErrors   = array();

                //Username validation
                if(strlen($user)  < 4){
                    $formErrors[] = '<div class="alert alert-danger">Username cannot be less than 4 letters.</div>';
                }
                
                //Username validation
                if(strlen($user)  > 15){
                    $formErrors[] = '<div class="alert alert-danger">Username cannot be bigger than 15 letters.</div>';
                } 

                //Fullname validation
                if(empty($fullname)){
                    $formErrors[] = '<div class="alert alert-danger">Fullname cannot be empty.</div>';
                }

                //Email validation
                if(empty($email)){
                    $formErrors[] = '<div class="alert alert-danger">Email cannot be empty.</div>';
                }

                //Phone number validation
                if(empty($phone)){
                    $formErrors[] = '<div class="alert alert-danger">Phone Number cannot be empty.</div>';
                }

                //Address validation
                if(empty($address)){
                    $formErrors[] = '<div class="alert alert-danger">Address cannot be empty.</div>';
                }

                foreach( $formErrors as $error ){
                    echo '<div class = "alert alert-danger">' . $error . '</div>';
                }
                

                // Check if there's no error > then proceed the update operation
                if(empty($formErrors)){

                    $stmt2 = $connection->prepare("SELECT * FROM users WHERE Username = ? AND UserID = ? ");
                    $stmt2->execute(array($user, $id));
                    $count = $stmt2->rowCount();
                    echo $count;
                    if($count == 1){
                        echo '<div class="alert alert-danger">Sorry this user already exists</div>';
                        
                    }else{
                        // Update the user info in database
                        $query = '';

                        $stmt = $connection->prepare("UPDATE users SET Username = ?, Password = ?, FullName = ?, Email = ?, PhoneNumber = ?, PAddress = ? WHERE UserID = ? ");
                        $stmt->execute(array($user, $pass, $fullname, $email, $phone, $address, $id));

                        // Print Success Message 
                        $message = '<div class="alert alert-success">' . $stmt->rowCount() . ' record has been updated.</div>';
                        
                        // Redirect the page on the homepage for error message
                        redirectHome($message, 'back', 6);
                    }
                }
            }

        }// Update Page Ends here
        else if ($do == 'delete') {

            // Delete the user 
            echo '<h1 class="text-center">Delete User</h1>';

            // Condition : True ? False - to check if the GET Request is numeric & get the integer value of it  
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
 
            $checkCurrentUser = checkItem('userid', 'users', $userid);

            // $stmt = $connection->prepare('SELECT * FROM users WHERE UserID = ? LIMIT 1');
            // // Execute the query
            // $stmt -> execute(array($userid));

            // // Row counting 
            // $count = $stmt->rowCount();
            // 

            if($checkCurrentUser > 0){
                $stmt = $connection->prepare("DELETE from users WHERE UserID = :zuser");
                $stmt->bindParam(":zuser", $userid);
                $stmt->execute(); 

                $message = "<div class='alert alert-success'>". $stmt->rowCount() ." record has been deleted successfully!</div>";

                redirectHome($message, 'back', 5);
            }else{
                echo "<div class='container'>";
                    $message = "<div class='alert alert-danger'>This user does not exist!</div>";
                    redirectHome($message, 'back', 5);
                echo "</div>";
            }

        } else if ($do == 'active') {

            echo '<h1 class="text-center">Active User</h1>';

            // Condition : True ? False - to check if the GET Request is numeric & get the integer value of it  
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
            $checkCurrentUser = checkItem('userid', 'users', $userid);

            if($checkCurrentUser > 0){
                $stmt = $connection->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
                $stmt->execute(array($userid)); 

                $message = "<div class='alert alert-success'>". $stmt->rowCount() ." user has been actived successfully!</div>";

                redirectHome($message, 'back', 5);
            }else{
                echo "<div class='container'>";
                    $message = "<div class='alert alert-danger'>This user does not exist!</div>";
                    redirectHome($message, 'back', 5);
                echo "</div>";
            }

        }
        include $tpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }   
?>