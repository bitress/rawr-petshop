<?php

include_once '../includes/connection.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM `products` LEFT JOIN `category` ON `category`.category_id = products.category WHERE products.id = '$id'";
    $result = mysqli_query($con, $sql);
    $res = mysqli_fetch_assoc($result);
}

if (isset($_SESSION['isLoggedIn'])){
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

}


if (isset($_POST['addtocart'])){
    $user_id = $row['id'];

    $product = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the item is already in the cart
    $result = mysqli_query($con, "SELECT * FROM cart WHERE product_id = '$product' AND user_id = '$user_id'");
    if (mysqli_num_rows($result) > 0) {
        // Item is already in the cart, update quantity
        mysqli_query($con, "UPDATE `cart` SET quantity = quantity + '$quantity' WHERE product_id = '$product' AND user_id = '$user_id'");
        header("Location: product.php?id=". $product);
    } else {
        // Item is not in the cart, insert new row
        mysqli_query($con, "INSERT INTO `cart` (product_id, user_id, quantity) VALUES ('$product', '$user_id', '$quantity')");
        header("Location: product.php?id=". $product);
    }
}

if (isset($_POST['checkout'])){
    $checkBox = implode(',', $_POST['product']);
    echo $checkBox;
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>All Products | Rawr PetShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>
<link rel="stylesheet" href="css/style.css">
<style>
    @media (min-width: 1025px) {
        .h-custom {
            height: 100vh !important;
        }
    }


    .bottom{
        padding: 10px;
        padding-top: 30px;
    }
    .add{

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

    .card-img-top {
        width: 100%;
        height: 30vw;
    }


    .quantity {
        display: inline-block; }

    .quantity .input-text.qty {
        width: 35px;
        height: 39px;
        padding: 0 5px;
        text-align: center;
        background-color: transparent;
        border: 1px solid #efefef;
    }

    .quantity.buttons_added {
        text-align: left;
        position: relative;
        white-space: nowrap;
        vertical-align: top; }

    .quantity.buttons_added input {
        display: inline-block;
        margin: 0;
        vertical-align: top;
        box-shadow: none;
    }

    .quantity.buttons_added .minus,
    .quantity.buttons_added .plus {
        padding: 7px 10px 8px;
        height: 41px;
        background-color: #ffffff;
        border: 1px solid #efefef;
        cursor:pointer;}

    .quantity.buttons_added .minus {
        border-right: 0; }

    .quantity.buttons_added .plus {
        border-left: 0; }

    .quantity.buttons_added .minus:hover,
    .quantity.buttons_added .plus:hover {
        background: #eeeeee; }

    .quantity input::-webkit-outer-spin-button,
    .quantity input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        margin: 0; }

    .quantity.buttons_added .minus:focus,
    .quantity.buttons_added .plus:focus {
        outline: none; }




</style>
<body>


<?php
include_once '../includes/navbar.php';
?>






<section class="py-5">
    <form action="product.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $res['id']?>">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php echo WEBSITE_DOMAIN . $res['product_image']?>" alt="..." /></div>
            <div class="col-md-6">
                <div class="small mb-1"><?php echo $res['category_name']; ?></div>
                <h1 class="h5 fw-bolder"><?php echo $res['product_name']; ?></h1>
                <p><?php echo $res['product_description'] ?></p>
                <div class="fs-5 mb-5">
                    <span>₱<?php echo number_format($res['product_price'])?></span>
                </div>
                <div class="row">
                    <div class="quantity buttons_added" data-trigger="spinner" >
                        <input type="button" value="-" class="minus btn-outline-dark" data-spin="down">
                        <input type="text" class="input-text qty text" name="quantity" value="1" title="quantity">
                        <input type="button" value="+" class="plus" data-spin="up">
                    </div>
                    <div class="col-md-9">
                        <input type="submit"  name="addtocart" id="addtocart" class="btn btn-outline-dark flex-shrink-0 addtocart mt-4" value="Add to Cart">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

</section>
<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">You may also like</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
            $category = $res['category_id'];
            $id = $res['id'];
            $sql = "SELECT * FROM products LEFT JOIN category ON category.category_id = products.category WHERE category = '$category' AND NOT id = '$id' LIMIT 4";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0){
            while($product = mysqli_fetch_assoc($result)){
            ?>
                <div class="col-sm-3 col-6">
                    <div class="card mb-4 product-wap rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="<?php echo WEBSITE_DOMAIN . $product['product_image']?>">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">

                            </div>
                        </div>

                        <form action="index.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                            <div class="card-body">
                                <span class="h6 text-dark"><a href="product.php?id=<?php echo $product['id']?>" class="text-decoration-none"><?php echo substr($product['product_name'], 0, 50 ) . "...";?></a> </span>
                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li class="fw-light"><a href="category.php?id=<?php echo $product['category']?>&name=<?php echo urlencode($product['category_name'])?>"><?php echo $product['category_name']?></a> </li>

                                </ul>
                                <p class="text-center mb-0 h6">₱<?php echo number_format($product['product_price'])?></p>
                                <div class="bottom d-flex flex-row justify-content-center">
                                    <div class="quantity buttons_added" data-trigger="spinner" >
                                        <input type="button" value="-" class="minus btn-outline-dark" data-spin="down">
                                        <input type="text" class="input-text qty text" name="quantity" value="1" title="quantity">
                                        <input type="button" value="+" class="plus" data-spin="up">
                                    </div>
                                    <?php
                                    if (isset($_SESSION['isLoggedIn'])) {
                                        ?>
                                        <button name="addtocart"  class="btn btn-outline-success add btn-sm addtocart" type="submit">
                                            <i class="bi bi-cart"></i>                                    </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button onclick="window.location='../login.php';" class="btn btn-outline-success add btn-sm" type="button">
                                            <i class="bi bi-cart"></i>                                    </button>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
        <?php
        }
        } else {
            echo "No products to show!";
        }
        ?>


    </div>
    </div>
</section>

<footer class="footer text-center bg-light p-4">
    Copyright &copy; 2023 - Rawr Pet Shop
</footer>



<?php

include_once '../includes/modal.php';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="../js/jquery.spinner.min.js"></script>

</body>
</html>