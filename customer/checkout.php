<?php

include_once '../includes/connection.php';

if (isset($_SESSION['isLoggedIn'])){
    $id = $_SESSION['id'];


    $sql = "SELECT * FROM users WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

}




if (isset($_POST['continue_checkout'])){

    $user = $_POST['user'];
    $product = $_POST['checkout_products'];

    $product = explode(',', $product);

    foreach ($product as $p){

        $sql = "INSERT INTO checkout (`user_id`, `cart_id`, `message`) VALUES ('$user', '$p', 'Your package has been confirmed!')";
        $result = mysqli_query($con, $sql);

        $sql = "UPDATE cart SET status = '1' WHERE cart_id = '$p'";
        $result = mysqli_query($con, $sql);
    }

    header("Location: delivery.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My Cart | Rawr PetShop</title>
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

<div class="container py-2">


    <div class="row">



        <div class="col-12 col-lg-12">
            <div class="container px-4 px-lg-5 mt-5">

                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Your cart</span>
                            <span class="badge badge-secondary badge-pill">3</span>
                        </h4>
                        <ul class="list-group mb-3">

                            <?php
                            if (isset($_POST['checkout'])) {
                                $id = $row['id'];

                                $cart =  implode(',', $_POST['product']);

                                $sql = "SELECT cart.product_id, cart.user_id, cart.quantity, products.*, category.* FROM cart INNER JOIN products ON products.id = cart.product_id INNER JOIN users ON users.id = cart.user_id LEFT JOIN category ON category.category_id = products.category WHERE cart.cart_id IN ($cart) AND users.id = '$id'";
                                $result = mysqli_query($con, $sql);
                                $total_price1 = 0;
                                while ($cart = mysqli_fetch_array($result)){
                                    $total_price1 += $cart['product_price'] * $cart['quantity'];

                                    ?>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><?php echo $cart['product_name'] ?> (<?php echo $cart['quantity'] ?>)</h6>
                                            <small class="text-muted"><?php echo $cart['category_name'] ?></small>
                                        </div>
                                        <span class="text-muted">₱<?php echo number_format($cart['product_price']) ?></span>
                                    </li>
                                    <?php

                                }
                            }?>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (PHP)</span>
                                <strong>₱<?php echo number_format($total_price1) ?></strong>
                            </li>
                        </ul>

                        <div class="bg-dark p-4 p-md-5 text-white">
                            <h3 class="fs-3 fw-bold m-0 text-center">Order Summary</h3>
                            <div class="py-3 border-bottom-white-opacity">
                                <div class="d-flex justify-content-between align-items-center mb-2 flex-column flex-sm-row">
                                    <p class="m-0 fw-bolder fs-6">Subtotal</p>
                                    <p class="m-0 fs-6 fw-bolder">₱ <?php echo number_format($total_price1); ?></p>
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
                                    </div>
                                    <p class="mt-3 m-sm-0 fs-5 fw-bold">₱ <?php echo number_format($total_price1); ?></p>
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

                            <form method="post" action="checkout.php">
                                <?php

                                if (isset($_POST['checkout'])) {
                                    ?>
                                    <input type="hidden" name="checkout_products" value="<?php echo implode(',', $_POST['product']);?>">
                                    <input type="hidden" name="user" value="<?php echo $row['id'] ?>">
                                    <button class="btn btn-outline-light w-100 text-center mt-3" name="continue_checkout" type="submit">Proceed to checkout</button>
                                    <?php
                                }
                                ?>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Billing address</h4>
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="<?php echo $row['firstname'] ?>" required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="" value="<?php echo $row['lastname'] ?>" required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control" id="username" value="<?php echo $row['username'] ?>" placeholder="Username" required>
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                <input type="email" class="form-control" id="email" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="" value="<?php echo $row['address'] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="country">Country</label>
                                    <select class="custom-select d-block w-100" id="country" required>
                                        <option value="">Choose...</option>
                                        <option>Philippines</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid country.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="state">State</label>
                                    <select class="custom-select d-block w-100" id="state" required>
                                        <option value="">Choose...</option>
                                        <option>Tagudin</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a valid state.
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip">Zip</label>
                                    <input type="text" class="form-control" id="zip" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Zip code required.
                                    </div>
                                </div>
                            </div>


                            <hr class="mb-4">

                            <h4 class="mb-3">Payment</h4>

                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                                    <label class="custom-control-label" for="card">Debit/Credit card</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                                    <label class="custom-control-label" for="cod">Cash On Delivery</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cc-name">Name on card</label>
                                    <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                    <small class="text-muted">Full name as displayed on card</small>
                                    <div class="invalid-feedback">
                                        Name on card is required
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">Credit card number</label>
                                    <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Credit card number is required
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="cc-expiration">Expiration</label>
                                    <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Expiration date required
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cc-cvv">CVV</label>
                                    <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Security code required
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>


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
<script>
    function selectAll(source) {
        checkboxes = document.getElementsByName('product[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }
    selectAll(this)
</script>
</body>
</html>

