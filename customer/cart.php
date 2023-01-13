<?php

include_once '../includes/connection.php';

if (isset($_SESSION['isLoggedIn'])){
    $id = $_SESSION['id'];


    $sql = "SELECT * FROM users WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

}


if (isset($_POST['addtocart'])){

    // User id
    $user_id = $row['id'];
    $product = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the item is already in the cart
    $result = mysqli_query($con, "SELECT * FROM cart WHERE product_id = '$product' AND user_id = '$user_id'");
    if (mysqli_num_rows($result) > 0) {
        // Item is already in the cart, update quantity
        mysqli_query($con, "UPDATE `cart` SET quantity = quantity + '$quantity' WHERE product_id = '$product' AND user_id = '$user_id'");
        header("Location: index.php");
    } else {
        // Item is not in the cart, insert new row
        mysqli_query($con, "INSERT INTO `cart` (product_id, user_id, quantity) VALUES ('$product', '$user_id', '$quantity')");
        header("Location: index.php");
    }
}


if (isset($_POST['editProfile'])){

    $id = $row['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    if ($password == ""){
        // Dont change password
        $newpassword = $row['password'];
    } else {
        $newpassword = md5($password);
    }

    $sql = "UPDATE users SET password = '$newpassword', firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', address = '$address' WHERE id = '$id'";
    $result = mysqli_query($con, $sql);

    if ($result === TRUE){

        header("Location: index.php?success=Profile edit success!");

    }

}
//echo json_encode($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home | ShopOn-it</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/icons/favicon-16x16.png">
    <link rel="manifest" href="../assets/icons/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            overflow: scroll;
        }
        @media (max-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }

            .header_col {
                display: none;
            }
        }

        @media (min-width: 1025px) {
            .category {
                display: none !important;
            }
        }
        .carousel {
            width: 88vw;
            height: 400px;
            border-radius: 3px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }
        .carousel:hover .controls {
            opacity: 1;
        }
        .carousel .controls {
            opacity: 0;
            display: flex;
            position: absolute;
            top: 50%;
            left: 0;
            justify-content: space-between;
            width: s%;
            z-index: 99999;
            transition: all ease 0.5s;
        }
        .carousel .controls .control {
            margin: 0 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            opacity: 0.5;
            transition: ease 0.3s;
            cursor: pointer;
        }
        .carousel .controls .control:hover {
            opacity: 1;
        }
        .carousel .slides {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            display: flex;
            width: 100%;
            transition: 1s ease-in-out all;
        }
        .carousel .slides .slide {
            min-width: 100%;
            min-height: 250px;
            height: auto;
        }


        .bottom{
            padding: 10px;
            padding-top: 30px;
        }
        .add {

            height: 38px;
            border-radius: 4px;
            margin-left: 40px;
            padding-right: 22px;
            padding-left: 20px;
        }


        .card-img {
            width: 100%;
            height: 15vw;
            object-fit: cover;
        }

    </style>
</head>
<body>

<?php
include '../includes/navbar.php';
?>

<div class="container py-5">
    <div class="row mb-4">

        <div class="col-md-12">
            <div class="d-flex category">
                <select id="category_select" class="form-control">
                    <option selected disabled>--- Choose a Category ---</option>
                    <?php

                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($con, $sql);
                    while ($category = mysqli_fetch_assoc($result)){

                        ?>
                        <option value="category.php?id=<?php echo $category['category_id'] ?>&name=<?php echo $category['category_name'] ?>"><?php echo $category['category_name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-6 col-xl-7"
        <h5>My Cart</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell"></th>
                        <th class="ps-sm-3">Details</th>
                        <th>Qty</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $id = $row['id'];

                    $total_price = 0;
                    $sql = "SELECT * FROM cart INNER JOIN products ON products.id = cart.product_id INNER JOIN users ON users.id = cart.user_id LEFT JOIN category ON category.category_id = products.category WHERE  users.id = '$id' LIMIT 5";
                    $result = mysqli_query($con, $sql);
                    while ($cart = mysqli_fetch_array($result)){
                    $total_price += $cart['product_price'] * $cart['quantity'];

                    ?>
                    <tr>
                        <!-- image -->
                        <td class="d-none d-sm-table-cell">
                            <picture class="d-block bg-light p-3 f-w-20">
                                <img class="img-fluid" src="<?php echo WEBSITE_DOMAIN. $cart['product_image'] ?>" width="80px" alt="">
                            </picture>
                        </td>
                        <!-- image -->

                        <!-- Details -->
                        <td>
                            <div class="ps-sm-3">
                                <h6 class="mb-2 fw-bolder">
                                    <?php echo $cart['product_name'] ?>
                                </h6>
                                <small class="d-block text-muted"><?php echo $cart['category_name'] ?></small>
                            </div>
                        </td>
                        <!-- Details -->

                        <!-- Qty -->
                        <td>
                            <div class="px-3">
                                <span class="small text-muted mt-1"><?php echo ($cart['quantity']) ?> @ ₱<?php echo number_format($cart['product_price']) ?></span>
                            </div>
                        </td>
                        <!-- /Qty -->

                        <!-- Actions -->
                        <td class="f-h-0">
                            <div class="d-flex justify-content-between flex-column align-items-end h-100">
                                <i class="ri-close-circle-line ri-lg"></i>
                                <p class="fw-bolder mt-3 m-sm-0">₱<?php echo number_format($cart['product_price'] * $cart['quantity']) ?></p>
                            </div>
                        </td>
                        <!-- /Actions -->

                    </tr>

                    <?php

                    }

                    ?>

                    </tbody>
                </table>
            </div>


        </div>

    <div class="col-12 col-lg-6 col-xl-5">
        <div class="bg-dark p-4 p-md-5 text-white">
            <h3 class="fs-3 fw-bold m-0 text-center">Order Summary</h3>
            <div class="py-3 border-bottom-white-opacity">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-column flex-sm-row">
                    <p class="m-0 fw-bolder fs-6">Subtotal</p>
                    <p class="m-0 fs-6 fw-bolder">$422.99</p>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row mt-3 m-sm-0">
                    <p class="m-0 fw-bolder fs-6">Shipping</p>
                    <span class="text-white opacity-75 small">Will be set at checkout</span>
                </div>
            </div>
            <div class="py-3 border-bottom-white-opacity">
                <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row">
                    <div>
                        <p class="m-0 fs-5 fw-bold">Grand Total</p>
                        <span class="text-white opacity-75 small">Inc $45.89 sales tax</span>
                    </div>
                    <p class="mt-3 m-sm-0 fs-5 fw-bold">$422.99</p>
                </div>
            </div>

            <!-- Coupon Code-->
            <button class="btn btn-link p-0 mt-2 text-white fw-bolder text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Have a coupon code?
            </button>
            <div class="collapse" id="collapseExample">
                <div class="card card-body bg-transparent p-0">
                    <div class="input-group mb-0 mt-2">
                        <input type="text" class="form-control border-0" placeholder="Enter coupon code">
                        <button class="btn btn-white text-dark px-3 btn-sm border-0 d-flex justify-content-center align-items-center"><i class="ri-checkbox-circle-line ri-lg"></i></button>
                    </div>
                </div>
            </div>
            <!-- / Coupon Code-->

            <!-- Checkout Button-->
            <a href="./checkout.html" class="btn btn-white w-100 text-center mt-3" role="button"><i class="ri-secure-payment-line align-bottom"></i> Proceed to checkout</a>
            <!-- Checkout Button-->
        </div>
     </div>



    </div>
</div>

<footer class="footer text-center bg-light p-4">
    Copyright &copy; 2023 - Rawr Pet Shop
</footer>
<?php


if (isset($_SESSION['isLoggedIn'])) {
    include_once '../includes/modal.php';
}

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

</body>
</html>

