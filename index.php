<?php
    ob_start(); // For live hosting so that the header files can be fetched easily.
    session_start();

    $pageTitle = 'Homepage';

    include 'init.php';
?>

    <!-- HTML Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">Ecommerce System</h1>
                </div>
            </div>
        </div>
    </section>

<?php
    include $tpl . 'footer.php';
    ob_end_flush();
?>

