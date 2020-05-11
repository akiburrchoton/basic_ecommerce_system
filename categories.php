<?php include 'init.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Show Category Based Item</h1>
                <div class="row">
                    <?php
                    if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {

                        $category = intval($_GET['pageid']);

                        $allItems = getAllFrom("*", "items", "WHERE CAT_ID = {$category}", "AND Item_approval = 1", "Item_ID", "");

                        foreach ($allItems as $item) {

                            echo '<div class="col-lg-3">';
                                echo '<div class="item-box">';
                                    echo "<span class='price-tag'><i class='fa fa-tag'></i>{$item["Item_price"]}</span>";
                                    echo "<img src='layout/images/jordan.png' class='img-fluid'>";
                                    echo "<h4 class='item-name'>{$item['Item_name']}</h4>";
                                    echo "<p class='item-date'>{$item['Item_date']}</p>";
                                    echo "<p class='item-desc'>{$item['Item_description']}</p>";
                                    echo '<button class="btn btn-warning btn-block cart-btn"><i class="fa fa-shopping-cart"></i> Add to Cart</button>';
                                echo '</div>';
                            echo '</div>';
                            
                        }
                    }
                    ?>
                </div>
        </div>
    </div>
</div>
<?php include $tpl . 'footer.php'; ?>