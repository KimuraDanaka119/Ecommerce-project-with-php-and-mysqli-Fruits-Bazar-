<?php

session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();

$cata_info = $obj->p_display_catagory();
$cataDatas = array();
while ($data = mysqli_fetch_assoc($cata_info)) {
    $cataDatas[] = $data;
}

if (isset($_POST['user_login_btn'])) {
    $logmsg = $obj->user_login($_POST);
}

$userid = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (empty($userid)) {
    header("location:user_login.php");
}

if (isset($_POST['remove_product'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['pdt_name'] == $_POST['remove_pdt_name']) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
}

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "logout") {
        $obj->user_logout();
    }
}

?>


<?php
include_once("includes/head.php");
?>

<body class="biolife-body">
    <!-- Preloader -->

    <?php
    include_once("includes/preloader.php");
    ?>

    <!-- HEADER -->
    <header id="header" class="header-area style-01 layout-03">

        <?php
        include_once("includes/header_top.php");
        ?>

        <?php
        include_once("includes/header_middle.php");
        ?>

        <?php
        include_once("includes/header_bottom.php");
        ?>

    </header>

    <!-- Page Contain -->
    <div class="page-contain">

        <!-- Main content -->
        <div id="main-content" class="main-content">




            <div class="container">
                <h2 class="text-center">Order Sumary</h2>

                <div class="row">
                    <div class="col-md-2">
                        <h4>Hello <?php
                                    if (isset($username)) {
                                        echo strtoupper($username);
                                    }
                                    ?></h4>
                        <a href="?logout=logout">Logout</a>
                    </div>

                    <div class="col-md-10">

                        <?php



                        if (count($_SESSION['cart']) > 0) {
                        ?>
                        
                        <form class="shopping-cart-form" action="#" method="post">
                            <table class="shop_table cart-form">
                                <thead>
                                    <tr>
                                        <th class="product-name">Product Name</th>
                                        <th class="product-price">Status</th>
                                        <th class="product-quantity">Remove</th>
                                        <th class="product-subtotal">Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if (isset($_SESSION['cart'])) {

                                        $_SESSION['subtotal'] = 0;
                                        $_SESSION['cart_pdt_number'] = 0;
                                        foreach ($_SESSION['cart'] as $key => $value) {
                                            $_SESSION['subtotal'] =  $_SESSION['subtotal'] + $value['pdt_price'];
                                            $_SESSION['cart_pdt_number']++;
                                    ?>
                                            <tr class="cart_item">
                                                <td class="product-thumbnail" data-title="Product Name">
                                                    <a class="prd-thumb" href="single_product.php?status=singleproduct&&id=<?php echo $value['pdt_id'] ?>">
                                                        <figure><img width="113" height="113" src="admin/uploads/<?php echo $value['pdt_img'] ?>" alt="shipping cart"></figure>
                                                    </a>
                                                    <a class="prd-name" href="single_product.php?status=singleproduct&&id=<?php echo $value['pdt_id'] ?>"><?php echo $value['pdt_name'] ?></a>

                                                </td>
                                                <td class="product-price" data-title="Price">
                                                    <div class="price price-contain">
                                                        <ins><span class="price-amount"><span class="currencySymbol"></span>Action</span></ins>

                                                    </div>
                                                </td>
                                                <td class="product-quantity" data-title="Quantity">
                                                    <form action="" method="POST">

                                                        <input type="hidden" value="<?php echo $value['pdt_name'] ?>" name="remove_pdt_name">
                                                        <input class="btn btn-warning" type="submit" value="Remove Product" name="remove_product">
                                                    </form>
                                                </td>
                                                <td class="product-subtotal" data-title="Total">
                                                    <div class="price price-contain">
                                                        <ins><span class="price-amount"><span class="currencySymbol">Tk. </span><?php echo $value['pdt_price'] ?></span></ins>

                                                    </div>
                                                </td>
                                            </tr>

                                    <?php }
                                    } else {
                                        echo "Your cart is empty";
                                    } ?>

                                    <tr class="cart_item wrap-buttons">
                                        <td class="wrap-btn-control" colspan="3">
                                            <h2>Total ( <?php echo  $_SESSION['cart_pdt_number']; ?> Items)</h2>
                                        </td>

                                        <td>
                                            <h2>Tk. <?php echo  $_SESSION['subtotal'] ?> </h2>
                                        </td>
                                    </tr>

                                    <tr class="cart_item wrap-buttons">
                                        <td>
                                            <h3 style="color: black;">Payment</h3>
                                        </td>

                                    </tr>

                                    <tr class="cart_item wrap-buttons">
                                        <td>
                                            <h3 style="color: black;">Shiping Address</h3>
                                        </td>
                                        <td colspan="3"><input type="text" placeholder="Input shiping address" style="border: none; width:100%"></td>

                                    </tr>



                                </tbody>
                            </table>


                            <div class="btn-checkout">
                                <a href="paryment.php" class="btn btn-success btn-block btn-lg ">Confirm Order</a>
                            </div>
                        </form>

                        <?php
                        } else {
                            echo "your cart is empty";
                        }
                        ?>

                    </div>
                </div>









            </div>






        </div>
    </div>
    <br>
    <!-- FOOTER -->

    <?php
    include_once("includes/footer.php");
    ?>

    <!--Footer For Mobile-->
    <?php
    include_once("includes/mobile_footer.php");
    ?>

    <?php
    include_once("includes/mobile_global.php")
    ?>


    <!-- Scroll Top Button -->
    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>

    <?php
    include_once("includes/script.php")
    ?>
</body>

</html>