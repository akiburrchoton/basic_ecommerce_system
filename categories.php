<?php include 'init.php?'; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Show Category Based Item</h1>

                <?php
                    if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
                        
                        $category = intval($_GET['pageid']);

                        $allItems = getAllFrom("*","items","WHERE CAT_ID = {$category}", "AND Item_approval = 1","Item_ID","");

                        foreach ($allItems as $item) {
                            
                            echo '<div class="col-lg-3">';
                                echo '<div>';
                                    echo "<span class='price-tag'><i class='fa fa-tag'>{$item['Item_price']}</spann>";
                                    echo "<img src=>";
                                echo '</div>';
                            echo '</div>';
                        }
                    }
                ?>

            </div>
        </div>
    </div>
<?php include $tpl.'footer.php?'; ?>