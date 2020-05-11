<?php
    ob_start(); // For live hosting so that the header files can be fetched easily.
    session_start();
    $pageTitle = 'Items';
    include 'init.php';

    // Check if the get request item is a number 
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 

    // Select all data depends on the Item ID
    $stmt = $connection->prepare("SELECT 
                                items.*, 
                                categories.Cat_name AS category_name,
                                users.Username
                            FROM 
                                items
                            INNER JOIN 
                                categories
                            ON 
                                categories.Cat_id = items.Cat_ID
                            INNER JOIN 
                                users
                            ON 
                                users.UserID = items.User_ID
                            WHERE 
                                Item_ID = ?
                            AND
                                Item_approval = 1
                        ");

    $stmt -> execute([$itemid]);
    $count = $stmt -> rowCount();

    if($count > 0){
        $item = $stmt->fetch();
    }

?>

    <section>
        <div class="container">
            <div class="row">
                               
                <div class="col-lg-3">
                    <img class="img-fluid" src="layout/images/jordan.png" alt="">
                </div>

                <div class="col-lg-9">
                    <h2><?= $item['Item_name']; ?></h2>
                    <p><?= $item['Item_description']; ?></p>
                
                    <ul class="list-unstyled">
                        <li><i class="fa fa-money"></i> <span>Price: <?= $item['Item_price'];?></span></li>
                        <li><i class="fa fa-calendar"></i> <span>Added Date: <?= $item['Item_date'];?></span></li>   
                        <li><i class="fa fa-building"></i> <span>Made By: <?= $item['Item_country'];?></span></li>   
                        <li><i class="fa fa-user"></i> <span>Added By: <?= $item['Username'];?></span></li>   
                    </ul>
                </div>
            </div>

            <hr>

            <?php
                if(isset($_SESSION['user']) ){
            ?>

            <div class="row">
                <div class="col-lg-6 offset-lg-3" >
                    <h3>Add Your Comment</h3>
                    <form action="<?= $_SERVER['PHP_SELF'] . "?itemid={$item['Item_ID']}"; ?>" method="POST">
                        <div class="form-group">
                            <textarea class="form-control" name="comment" required="required"></textarea>
                        </div>
                        <input type="submit" name="Add Your Comment" class="btn btn-primary">
                    </form>

                    <?php
                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $userid  = $item['User_ID'];
                            $itemid  = $item['Item_ID'];

                            if(!empty($comment)){
                                $stmt = $connection->prepare("INSERT INTO comments(comment, comment_status, comment_date, comment_itemid, comment_userid) VALUES (:zcomment, 0, now(), :zitemid, :zuserid)");
                                
                                $stmt ->execute([
                                    'zcomment' => $comment ,
                                    'zitemid'  => $userid,
                                    'zuserid'  => $itemid
                                ]);

                                if($stmt){
                                    echo "<div class='alert alert-success'>Thanks for your valuable feedback.</div>";
                                }
                            
                            }


                        }
                    ?>
                </div>
            </div>

            <?php
            }else{
                echo '<div class="col-lg-6 offset-lg-3" >';
                    echo "<div class='alert alert-danger'>Please <a href='login.php'>login</a> to your account to add a comment</div>";
                echo '</div>';
            }
            ?>
        </div>
    </section>
<?php
    include $tpl.'footer.php';
    ob_end_flush();
?>