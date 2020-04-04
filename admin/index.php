<?php
session_start();
$pageTitle = 'Login';
$noNavBar  = '';


if (isset($_SESSION['Username'])) {
    header('Location : dashboard.php');
}

include 'init.php';

// Check if the users can come from HTTP Request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username   = $_POST['user'];
    $password   = $_POST['pass'];
    $hashedpass = sha1($password);


    $statement = $connection->prepare("SELECT 
                                UserID, Username, Password 
                            FROM 
                                users 
                            WHERE 
                                Username = ? 
                            AND 
                                Password = ?
                            AND
                                GroupID = 1
                            Limit 1
                            ");

    $statement->execute(array($username, $hashedpass));
    $row = $statement->fetch();
    $count = $statement->rowCount();

    if ($count > 0) {
        // Check the user registered or not
        //echo 'Welcome '. $username;


        $_SESSION['Username'] = $username; // Register Username for Session
        $_SESSION['UserID']   = $row['UserID']; // Register UserID for Session

        header("Location:dashboard.php");
        exit();
    } else {
        if ($row['RegStatus'] == 0) {
            echo "<div class='alert alert-danger'>You are not activated yet!</div>";
        } else {
            echo 'Wrong Username or Password!';
        }
    }
}

?>

<!-- Admin Login Section Starts Here-->
 

<!-- NEW LOGIN STARTS -->

    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="<?= $img; ?>login.jpg" alt="login" class="login-card-img">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <div class="brand-wrapper">
                            <h3 style="font-weight: 700; ">E-COMMERCE</h3>
                            </div>
                            <p class="login-card-description">Sign into your account</p>
                            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="form-group"> 
                                    <input type="text" name="user" id="username" class="form-control" placeholder="Username" required="required">
                                </div>
                                <div class="form-group mb-4"> 
                                    <input type="password" name="pass" id="password" class="form-control" placeholder="Password" required="required">
                                </div>
                                <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                            </form>
                            <a href="#!" class="forgot-password-link">Forgot password?</a>
                            <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                            <!-- <nav class="login-card-footer-nav">
                                <a href="#!">Terms of use.</a>
                                <a href="#!">Privacy policy</a>
                            </nav> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!-- NEW LOGIN  ENDS -->



<!-- Admin Login Section Ends Here-->

<?php include $tpl . 'footer.php'; ?>