<?php

include_once '../includes/connection.php';

if (isset($_SESSION['isLoggedIn'])){
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
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
            <h5>About Us</h5>
            <p>We offer a wide selection of adorable and healthy puppies, kittens, birds, reptiles, and small animals. All of our pets are well-cared for and come from reputable breeders. Our friendly and knowledgeable staff can help you find the perfect furry friend to join your family. Stop by today to meet your new best friend!"</p>
        </div>



    </div>
</div>

<footer class="footer text-center bg-light p-4">
    Copyright &copy; 2023 - Rawr Pet Shop
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="../js/jquery.spinner.min.js"></script>
<script>

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

</script>
</body>
</html>

