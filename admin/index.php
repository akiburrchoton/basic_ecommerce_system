<?php 
    session_start();
    $pageTitle = 'Login';
    $noNavBar  = '';


    if(isset($_SESSION['Username'])){
        header('Location : dashboard.php');
    }

    include 'init.php'; 

    // Check if the users can come from HTTP Request.
    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        $username   = $_POST['user'];
        $password   = $_POST['pass'];
        $hashedpass = sha1($password);
        

        $statement = $connection -> prepare("SELECT 
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

        $statement -> execute(array($username, $hashedpass));
        $row = $statement -> fetch();
        $count = $statement -> rowCount();
        
        if($count > 0){
            // Check the user registered or not
            //echo 'Welcome '. $username;

              
            $_SESSION['Username'] = $username; // Register Username for Session
            $_SESSION['UserID']   = $row['UserID'];// Register UserID for Session

            header('Location: dashboard.php');
            exit();
        }else{
            echo 'Wrong ...';
        }

    }
    
?>

    <!-- Admin Login Section Starts Here-->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4">
                    <h1>Admin Panel</h1>
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <input type="text" name="user" class="form-control" placeholder="Username" required="required">
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass" class="form-control" placeholder="Password" required="required">
                        </div> 
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Admin Login Section Ends Here-->

<?php include $tpl. 'footer.php'; ?>