<?php
    ob_start();
    // Start Session to save Username
    session_start();
    $pageTitle = 'Login';

    if (isset($_SESSION['user'])) {
        header('Location:index.php');
    }
    include 'init.php';

    // Check if the users can come from HTTP Request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $hashedpass = sha1($password);


        $statement = $connection->prepare("SELECT 
                                        UserID, Username, Password, RegStatus
                                    FROM 
                                        users 
                                    WHERE 
                                        Username = ? 
                                    AND 
                                        Password = ?
                                    AND 
                                        RegStatus = 1
                                    LIMIT 1
                                    ");

        $statement->execute([$username, $hashedpass]);
        $get = $statement->fetch();
        $count = $statement->rowCount();

        if ($count > 0) {
            $_SESSION['user']   = $username;
            $_SESSION['uid']    = $get['UserID'];

            header("Location:index.php");
            exit();
        }elseif ($get['RegStatus'] == 0) {
            // If the user is not activated yet
            $successMsg = 'Sorry, you are not activated yet';
        } else {

            // Signup operation - to Insert user data starts here
            $formErrors = array();

            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            $email      = $_POST['email'];


            if(isset($username)){
                $filteredUser = filter_var($username, FILTER_SANITIZE_STRING); // Will skip unwanted signs
                
                if(strlen($filteredUser) < 4){
                    $formErrors[] = 'Username must be larger than 4 charecters.';
                }

            }

            if(isset($password) && isset($password2)){
                
                if(empty($password)){
                    $formErrors[] = 'Sorry, Password can\'t be empty.';
                }

                if( sha1($password) !== sha1($password2) ){
                    $formErrors[] = 'Sorry, Password didn\'t match.';
                }

            }

            if(isset($email)){
                $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL); // Will skip unwanted signs
                
                if(filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true){
                    $formErrors[] = 'Invalid Email';
                }
            }

            // Check if there is no error -> then proceed the user to be added
            if(empty($formErrors)){
                $checkUser = checkItem("Username", "users", $username);

                if ($checkUser == 1) {
                    $formErrors[] = 'User already exists';
                }else{
                    // Insert the new user info into the database
                    $stmt = $connection->prepare("INSERT INTO users(Username, Password, Email, Regstatus, Date) 
                    VALUES (:zuser, :zpass, :zemail, 0, now()) ");

                    $stmt->execute([
                        'zuser' => $username,
                        'zpass' => sha1($password),
                        'zemail'=> $email
                    ]);

                    $successMsg = "Congratulations, You are now signed up!";
                }
            }else{
                $successMsg = "Sorry, Signup couldn't be done!";
            }

        }//else ends

    }// Main 'if' ends here
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 login-page">
                <h1 class="text-center">
                    <span class="selected" data-class="login">Login</span> |
                    <span data-class="signup">Signup</span>
                </h1>

                <!-- Login Form For Vendor -->
                <form class="login" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <div class="input-container">
                            <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Email or Username" required="required">

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-container">
                            <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password" required="required">
                        </div>
                    </div>

                    <input type="submit" name="login" id="" value="Login" class="btn btn-success btn-block">
                </form>



                <!-- Signup Form Starts Here -->
                <form class="signup" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <div class="input-container">
                            <input pattern=".{4,}" title="Username must be at least 4 Charecters" type="text" name="username" class="form-control" autocomplete="off" placeholder="Username" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-container">
                            <input minlength="4" type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Password" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-container">
                            <input minlength="4" type="password" name="password2" class="form-control" autocomplete="new-password" placeholder="Re-enter Password" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-container">
                            <input type="email" name="email" class="form-control" autocomplete="off" placeholder="Your Email" required="required">
                        </div>
                    </div>
                    <input type="submit" name="signup" class="btn btn-primary btn-block" value="Signup">
                </form>

                <?php
                    if (!empty($formErrors)) {
                        foreach ($formErrors as $error) {
                            echo $error . '</br>';
                        }
                    }

                    if (isset($successMsg)) {
                        echo "<div class='alert alert-success'>{$successMsg}</div>";
                    }
                ?>

            </div>
        </div>
    </div>
</section>


<?php

include $tpl . 'footer.php';
ob_end_flush();
?>