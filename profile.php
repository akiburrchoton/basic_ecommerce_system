<?php

    ob_start();
    
    session_start();

    $pageTitle = "Profile";

    include 'init.php';

    if (isset($_SESSION['user'])) {
        
        $getUser = $connection->prepare('SELECT * FROM users WHERE Username = ?');
        
        $getUser->execute([$_SESSION['user']]);

        $info = $getUser->fetch();

        $userid = $info['UserID'];
    
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">My Profile</h1>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>My Information</h4>
                        </div>

                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="fa fa-user"></i><span> Name</span>: <?= $info['Username']; ?></li>
                                <li><i class="fa fa-user"></i><span> Fullname</span>: <?= $info['FullName']; ?></li>
                                <li><i class="fa fa-envelope"></i><span> Email</span>: <?= $info['Email']; ?></li>
                                <li><i class="fa fa-calendar"></i><span> Registered Date</span>: <?= $info['Date']; ?></li>
                                <li><i class="fa fa-phone"></i><span> Number</span>: <?= $info['PhoneNumber']; ?></li>
                                <li><i class="fa fa-tag"></i><span> Address</span>: <?= $info['PAddress']; ?></li>
                            </ul>
                            <a href="" class="btn btn-primary btn-block">Edit Information</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">My Items</h4>
                        </div>
                        
                        <div class="card-body">
                            <?php
                                $myItems = getAllFrom("*", "items", "WHERE User_ID = $userid", "", "", "Item_ID");

                                if(!empty($myItems)){
                                    echo '<div class="row">';
                                    
                                        foreach ($myItems as $item) {
                                            echo '<div class="col-lg-3">';
                                                echo '<div class="item-box">';
                                                    if($item['Item_approval'] == 0){
                                                        echo '<div class="alert alert-warning">Waiting for approval from admin</div>';
                                                    }else{
                                                        echo "<span class='price-tag'><i class='fa fa-tag'></i>{$item["Item_price"]}</span>";
                                                        echo "<img src='layout/images/tandra.jpg' class='img-fluid'>";
                                                        echo "<h4 class='item-name'>{$item['Item_name']}</h4>";
                                                        echo "<span class='item-date'><p>{$item['Item_date']}</p></span>";
                                                        echo "<span class='item-desc'>{$item['Item_description']}</span>";
                                                    }

                                                    

                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    
                                    echo '</div>';
                                }else{
                                    echo "Sorry, there is no item to show. Please add a <a href='addnewitem.php' class='btn btn-primary'>New Item</a> ";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comments coming on specific item from the buyers -->

    <!-- <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Latest Comments</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

<?php

    }else{
        header('Location:login.php');
        exit();
    }

    include $tpl.'footer.php';

    ob_end_flush();
?>