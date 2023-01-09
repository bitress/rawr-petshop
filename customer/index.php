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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>
    <link rel="stylesheet" href="../css/style.css">
    <style>
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
            width: 58vw;
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


        .container {
            margin: auto;
            width: 80%;
        }
        .badge {
            background-color: #6394f8;
            border-radius: 10px;
            color: white;
            display: inline-block;
            font-size: 12px;
            line-height: 1;
            padding: 3px 7px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        .shopping-cart {
            margin: 20px 0;
            float: right;
            background: white;
            width: 320px;
            position: relative;
            border-radius: 3px;
            padding: 20px;
        }
        .shopping-cart .shopping-cart-header {
            border-bottom: 1px solid #e8e8e8;
            padding-bottom: 15px;
        }
        .shopping-cart .shopping-cart-header .shopping-cart-total {
            float: right;
        }
        .shopping-cart .shopping-cart-items {
            padding-top: 20px;
        }
        .shopping-cart .shopping-cart-items li {
            margin-bottom: 18px;
        }
        .shopping-cart .shopping-cart-items img {
            float: left;
            margin-right: 12px;
        }
        .shopping-cart .shopping-cart-items .item-name {
            display: block;
            padding-top: 10px;
            font-size: 16px;
        }
        .shopping-cart .shopping-cart-items .item-price {
            color: #6394f8;
            margin-right: 8px;
        }
        .shopping-cart .shopping-cart-items .item-quantity {
            color: #abb0be;
        }
        .shopping-cart:after {
            bottom: 100%;
            left: 89%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: white;
            border-width: 8px;
            margin-left: -8px;
        }
        .cart-icon {
            color: #515783;
            font-size: 24px;
            margin-right: 7px;
            float: left;
        }
        .button {
            background: #6394f8;
            color: white;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            display: block;
            border-radius: 3px;
            font-size: 16px;
            margin: 25px 0 15px 0;
        }
        .button:hover {
            background: #729ef9;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }


    </style>
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

    <div class="row header_col">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <ul class="list-group list-group-flush">
                        <?php

                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($con, $sql);
                        while ($category = mysqli_fetch_assoc($result)){

                            ?> <li class="list-group-item ">
                                <a class="link-dark text-decoration-none" href="category.php?id=<?php echo $category['category_id'] ?>&name=<?php echo $category['category_name'] ?>">
                                    <?php echo $category['category_name'] ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="carousel">
                <div class="slides">
                    <img src="../bannerse/1.png" alt="slide image" class="slide">
                    <img src="../bannerse/2.png" alt="slide image" class="slide">
                    <img src="../bannerse/3.png" alt="slide image" class="slide">
                </div>
                <!--            <div class="controls">-->
                <!--                <div class="control prev-slide">&#9668;</div>-->
                <!--                <div class="control next-slide">&#9658;</div>-->
                <!--            </div>-->
            </div>
        </div>
    </div>







    <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <?php
                $sql = "SELECT * FROM products LEFT JOIN category ON category.category_id = products.category";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0){
                while($product = mysqli_fetch_assoc($result)){
                ?>
                <div class="col-md-3">
                    <div class="card mb-4 product-wap rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="<?php echo WEBSITE_DOMAIN . $product['product_image']?>">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">

                            </div>
                        </div>

                        <form action="index.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                        <div class="card-body">
                            <span class="h3 text-decoration-none"><?php echo $product['product_name']?></span>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li class="fw-light"><a href="category.php?id=<?php echo $product['category']?>&name=<?php echo urlencode($product['category_name'])?>"><?php echo $product['category_name']?></a> </li>
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul>
                            <p class="text-center mb-0">₱<?php echo number_format($product['product_price'])?></p>
                            <div class="mb-2">
                                <label>How many?</label>
                                <input type="number" id="quantity" name="quantity" value="1" title="quantity" class="form-control">
                            </div>
                                <?php
                                  if (isset($_SESSION['isLoggedIn'])) {
                                  ?>
                            <input type="submit" name="addtocart" id="addtocart" class="btn btn-outline-dark btn-sm addtocart" value="Add to Cart">
                                <?php
                                } else {
                                  ?>
                              <button onclick="window.location='../login.php';" class="btn btn-outline-dark btn-sm" type="button">
                                  Add to Cart
                              </button>
                            <?php
                                  }
                              ?>
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
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $('#category_select').change(function() {
        window.location = $(this).val();
    });

    const delay = 3000; //ms

    const slides = document.querySelector(".slides");
    const slidesCount = slides.childElementCount;
    const maxLeft = (slidesCount - 1) * 100 * -1;

    let current = 0;

    function changeSlide(next = true) {
        if (next) {
            current += current > maxLeft ? -100 : current * -1;
        } else {
            current = current < 0 ? current + 100 : maxLeft;
        }

        slides.style.left = current + "%";
    }

    let autoChange = setInterval(changeSlide, delay);
    const restart = function() {
        clearInterval(autoChange);
        autoChange = setInterval(changeSlide, delay);
    };

    // Controls
    document.querySelector(".next-slide").addEventListener("click", function() {
        changeSlide();
        restart();
    });

    document.querySelector(".prev-slide").addEventListener("click", function() {
        changeSlide(false);
        restart();
    });

        $('#category_select').change(function() {
        window.location = $(this).val();
    });


</script>
</body>
</html>

