<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand" href="#">
            <img src="../logo.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">
          Rawr PetShop
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0 ms-lg-4 w-75">

                <form class="d-flex ms-auto me-auto w-100">
                    <div class="input-group">
                        <input class="form-control" id="searchbox" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

            </ul>

            <?php

            if (isset($_SESSION['isLoggedIn'])){

            ?>

            <ul class="navbar-nav ms-auto mb-lg-0 d-flex">

                <li class="nav-item">

                    <div class="dropdown dropstart">
                        <button class="btn btn-outline btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" >
                            <i class="bi-cart-fill me-1"></i>
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo countCart($con,  $row['id'])?></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="shopping-cart active">
                                <div class="shopping-cart-header">
                                    <i class="bi-cart me-1"></i>
                                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo countCart($con,  $row['id'])?></span>

                                    <div class="shopping-cart-total">
                                        <span class="lighter-text">Total:</span>
                                        <span class="main-color-text total">
                                        </span>

                                        <?php

                                        if (isset($_SESSION['total_price'])){
                                            echo '₱' . number_format( $_SESSION['total_price']);
                                        }

                                        ?>


                                        </span>
                                    </div>
                                </div> <!--end shopping-cart-header -->

                                <ul class="shopping-cart-items text-decoration-none">

                                    <?php
                                    $id = $row['id'];

                                    $total_price = 0;
                                    $sql = "SELECT * FROM cart INNER JOIN products ON products.id = cart.product_id INNER JOIN users ON users.id = cart.user_id LEFT JOIN category ON category.category_id = products.category WHERE  users.id = '$id' LIMIT 5";
                                    $result = mysqli_query($con, $sql);
                                    while ($cart = mysqli_fetch_array($result)){
                                    $total_price += $cart['product_price'] * $cart['quantity'];

                                    ?>

                                    <li class="clearfix ">
                                        <img src="<?php echo WEBSITE_DOMAIN. $cart['product_image'] ?>" alt="item1" />
                                        <span class="item-name"><?php echo $cart['product_name'] ?></span>
                                        <span class="item-detail">Price: ₱<?php echo number_format($cart['product_price']) ?></span>
                                        <span class="item-price">₱<?php echo number_format($cart['product_price'] * $cart['quantity']) ?></span>
                                        <span class="item-quantity">Quantity: <?php echo $cart['quantity'] ?></span>
                                    </li>
                                        <hr>

                                    <?php
                                    }

                                    $_SESSION['total_price'] = $total_price;

                                    ?>

                                </ul>
                                <div class="text-center">
                                    <a href="#" class="btn btn-outline-dark btn-sm">Show Cart <i class="bi bi-cart"></i></a>
                                </div>
                            </div> <!--end shopping-cart -->
                        </div>
                    </div>

                </li>




                <li class="nav-item">
                    <button data-bs-toggle="modal" data-bs-target="#myProfile" href="#" class="btn btn-outline btn-sm" type="button">
                        <i class="bi-person me-1"></i>
                        Profile
                    </button>
                </li>

                <li class="nav-item">
                    <button onclick="window.location='../logout.php';" class="btn btn-outline btn-sm" type="button">
                        <i class="bi bi-box-arrow-left"></i>
                        Logout
                    </button>
                </li>

            </ul>

            <?php

            } else {
            ?>


                <ul class="navbar-nav ms-auto mb-lg-0 d-flex">
                    <li class="nav-item">
                        <button onclick="window.location='../login.php';"  href="#" class="btn btn-outline btn-sm" type="button">
                            <i class="bi bi-person"></i>
                            Login
                        </button>
                    </li>
                    <li class="nav-item">
                    <button onclick="window.location='../register.php';" class="btn btn-outline btn-sm" type="button">
                        <i class="bi bi-box-arrow-right"></i>
                        Register
                    </button>
                    </li>
                </ul>

            <?php
            }
            ?>
        </div>
    </div>
</nav>

