<?php
    ob_start(); // For live hosting so that the header files can be fetched easily.
    session_start();

    $pageTitle = 'Homepage';

    include 'init.php';

?>

    <!-- HTML Start | date - 06.25.2020-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">Ecommerce System Home</h1>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">All Items</h4>
                    
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php
                            $allItems = getAllFrom("*", "items", "WHERE Item_approval = 1", "", "Item_ID", "");

                            foreach ($allItems as $item) {
                                echo '<div class="col-lg-3">';
                                    echo '<div class="item-box">';
                                        echo "<span class='price-tag'><i class='fa fa-tag'></i>{$item["Item_price"]}</span>";
                                        echo "<img src='layout/images/jordan.png' class='img-fluid'>";
                                        echo "<h4 class='item-name'> <a href='items.php?itemid={$item['Item_ID']}'>{$item['Item_name']}</a></h4>";
                                        echo "<p class='item-date'>{$item['Item_date']}</p>";
                                        echo "<p class='item-desc'>{$item['Item_description']}</p>";
                                        echo '<button class="btn btn-warning btn-block cart-btn"><i class="fa fa-shopping-cart"></i> Add to Cart</button>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                   
                </div>
            </div>

        </div>
    </section>

<?php
    include $tpl . 'footer.php';
    ob_end_flush();
?>

