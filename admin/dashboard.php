<?php 
 
    // Start session to save username

    session_start();
    // print_r($_SESSION);

    if(isset($_SESSION['Username'])){
        $pageTitle = 'Dashboard';
        include 'init.php';
    }
     
?>



<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Welcome to the Dashboard Page!</h1> 
            </div>
        </div>
    </div>
</section>

<?php include 'includes/templates/footer.php'; ?>