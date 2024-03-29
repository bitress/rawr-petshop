<?php

include_once '../includes/connection.php';

if (isset($_GET['query'])){
    $query = $_GET['query'];
} else {
    header("Location: products.php");
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Search | Rawr PetShop</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/icons/favicon-16x16.png">
    <link rel="manifest" href="../assets/icons/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">
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
</head>
<body>

<?php
include '../includes/navbar.php';
?>

<div class="container py-5">
    <div class="row mb-4">



        <div class="col-12">
            <div class="carousel mb-4">
                <div class="slides">
                    <img src="../bannerse/1.png" alt="slide image" class="slide">
                    <img src="../bannerse/2.png" alt="slide image" class="slide">
                    <img src="../bannerse/3.png" alt="slide image" class="slide">
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class=" lh-1 fs-1 text-center mb-2 p-2">
                <h3 class="text-center">Search Results For '<span style="color: red"><?php echo $query; ?></span>' </h3>
            </div>

            <div class="row g-0">
                <div class="splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            <?php
                            $sql = "SELECT * FROM category";
                            $result = mysqli_query($con, $sql);
                            while ($category = mysqli_fetch_assoc($result)){

                                ?>
                                <div class="col-sm-2 splide__slide m-2">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <img src="../images/category/<?php echo $category['category_image'] ?>" width="100px" class="float-end">
                                            <h5 class="card-title"><?php echo $category['category_name'] ?></h5>
                                            <a class="btn btn-outline-dark btn-sm" href="category.php?id=<?php echo $category['category_id'] ?>&name=<?php echo $category['category_name'] ?>">Show Products</a>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="bg-light lh-1 fs-1 mb-2">
                <div class="row">
                    <div class="col">
                        <h3 class="text-center">Products</h3>
                    </div>
                </div>

            </div>

            <div class="row">
                <?php
                $sql = "SELECT * FROM products LEFT JOIN category ON category.category_id = products.category WHERE `product_name` LIKE '%$query%' OR `category_name` LIKE '%$query%'";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0){
                    while($product = mysqli_fetch_assoc($result)){
                        ?>
                        <div class="col-sm-3 col-6 mb-2">
                            <div class="card product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid" src="<?php echo WEBSITE_DOMAIN . $product['product_image']?>">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">

                                    </div>
                                </div>

                                <form action="index.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                                    <div class="card-body">
                                        <span class="h6"><a href="#" class="text-decoration-none"><?php echo substr($product['product_name'], 0, 50 ) . "...";?></a> </span>
                                        <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                            <li class="fw-light"><a href="category.php?id=<?php echo $product['category']?>&name=<?php echo urlencode($product['category_name'])?>"><?php echo $product['category_name']?></a> </li>
                                        </ul>
                                        <p class="text-center mb-0">₱<?php echo number_format($product['product_price'])?></p>
                                        <div class="bottom d-flex flex-row justify-content-center">
                                            <div class="quantity buttons_added" data-trigger="spinner" >
                                                <input type="button" value="-" class="minus btn-outline-dark" data-spin="down">
                                                <input type="text" class="input-text qty text" name="quantity" value="1" title="quantity">
                                                <input type="button" value="+" class="plus" data-spin="up">
                                            </div>
                                            <?php
                                            if (isset($_SESSION['isLoggedIn'])) {
                                                ?>
                                                <button name="addtocart"  class="btn btn-outline-dark add btn-sm addtocart" type="submit">
                                                    <i class="bi bi-cart"></i>                                    </button>
                                                <?php
                                            } else {
                                                ?>
                                                <button onclick="window.location='../login.php';" class="btn btn-outline-dark add btn-sm" type="button">
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
<script src="../js/jquery.spinner.min.js"></script>
<script>

    var splide = new Splide('.splide', {
        type: 'loop',
        perPage: 3,
        rewind: true,
        breakpoints: {
            640: {
                perPage: 2,
                gap: '.7rem',
                height: '12rem',
            },
            480: {
                perPage: 1,
                gap: '.7rem',
                height: '12rem',
            },
        },
    });
    splide.mount();

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

