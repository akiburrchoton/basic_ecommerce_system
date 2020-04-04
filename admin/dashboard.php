<?php

// Start session to save username

session_start();
// print_r($_SESSION);

    if (isset($_SESSION['Username'])) {
        $pageTitle = 'Dashboard';
        include 'init.php';

        /* Number of total member we want to display in Dashboard page */
        $numUsers       = 5;
        $latestUsers    = getLatest('*', 'users', 'UserID', $numUsers);
    }

    
?>

    <section>
        <div class="container">
            
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center" style="margin: 0 0 3% 0;">Welcome to the Dashboard Page, <?= strtoupper($_SESSION['Username']); ?>!</h1>
                </div>
            </div>

            <div class="row">

                <!-- Total Members -->
                <div class="col-sm-3">
                    <div class="items-info">
                        <i class="fa fa-users fa-3x"></i>
                        <h6>TOTAL USERS</h6>
                        <a href="members.php"><p><strong><?= countUsers("UserID", "users" ); ?></strong></p></a>
                        
                    </div>
                </div>

                <!-- Pending Members -->
                <div class="col-sm-3">
                    <div class="items-info">
                        <i class="fa fa-user-plus fa-3x"></i>
                        <h6>PENDING MEMBERS</h6>
                        <a href="members.php?do=manage&page=pending"><p><strong><?= checkItem("RegStatus", "users", 0); ?></strong></p></a>
                    </div>
                </div>

                <!-- Total Items -->
                <div class="col-sm-3">
                    <div class="items-info">
                        <i class="fa fa-product-hunt fa-3x"></i>
                        <h6>TOTAL CATEGORIES</h6>
                        <a href="categories.php"><p><strong>150</strong></p></a>
                    </div>
                </div>
                <!-- Total Comments -->
                <div class="col-sm-3">
                    <div class="items-info">
                        <i class="fa fa-comment fa-3x"></i>
                        <h6>LATEST COMMENTS</h6>
                        <a href="categories.php"><p><strong>78</strong></p></a>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-6">
                    
                    <div class="card">
                        <div class="card-header">
                        <h4><i class="fa fa-users"></i> Latest <?= $numUsers; ?> Registerd Users</h4>
                        </div>

                        <ul class="list-unstyled">

                            <?php
                                if(!empty($latestUsers)){
                                    foreach ($latestUsers as $user) {
                                        // \layout\images\avatar
                                        echo "<li>{$user['Username']} <span class='btn btn-default'><i class='fa fa-edit'></i><a href='members.php?do=edit&userid={$user['UserID']}'>Edit</a></span></li>";
                                    }
                                }
                            ?>

                        </ul>
                    <a href=""></a>
                    </div>
                </div>
            </div>
                                    
        </div>
    </section>

<?php include 'includes/templates/footer.php'; ?>