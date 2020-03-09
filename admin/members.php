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
            echo 'Welcome to the Super Admin Page.';
?>

            <a href="members.php?do=add"><button type="submit" class="btn btn-primary">Add New Memeber</button></a>

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
                            <form action="?do=insert" method="POST">

                                <!-- Username Field -->
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username"  >
                                </div>

                                <!-- Password Field -->
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password"  >
                                </div>


                                <!-- Full Name Field -->
                                <div class="form-group">
                                    <input type="text" name="fullname" class="form-control" placeholder="Full Name"  >
                                </div>

                                <!-- Email Field -->
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address"  >
                                </div>


                                <!-- Phone Field -->
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number"  >
                                </div>

                                <!-- Address Field -->
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" placeholder="Address"  >
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

                    foreach( $formErrors as $error ){
                        echo '<div class = "alert alert-danger">' . $error . '</div>';
                    }


                    // Check if there is no error > proceed the update operation
                    if(empty($formErrors)){
                        // Check userinfo exists in Database
                        $checkCurrentUser = checkItem("Username", "users", $user); 

                        if($checkCurrentUser == 1){
                            $message = '<div class="alert alert-danger">Sorry! User already exists.</div>'; 
                            
                            redirectHome($message, 'back', 5);
                        }else{
                            // Insert new member's info into the database
                            $stmt = $connection->prepare("INSERT INTO users(Username, Password, FullName, Email, PhoneNumber, PAddress,  RegStatus, Date) VALUES(:zuser, :zpass, :zname, :zemail, :zphone, :zaddress, 0, now() )"); // :z for PDO format

                            $stmt -> execute(array(
                                'zuser'     => $user,
                                'zpass'     => $hashedPass,
                                'zname'     => $fullname,
                                'zemail'    => $email,
                                'zphone'    => $phone,
                                'zaddress'  => $address
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
                        $message = '<div class="alert alert-success">' . $stmt->rowCount() . ' record is updated.</div>';
                        
                        // Redirect the page on the homepage for error message
                        redirectHome($message, 'back', 6);
                    }
                }
            }

        }// Update Page Ends here
        else if ($do == 'delete') {
            // Delete the user 
            echo 'Delete the user';
        } else if ($do == 'active') {
            // Super admin can approve here 
            echo 'Super admin can approve here';
        }
        include $tpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }   
?>