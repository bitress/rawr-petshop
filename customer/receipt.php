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
    <title>Home | Rawr PetShop</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/icons/favicon-16x16.png">
    <link rel="manifest" href="../assets/icons/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">
</head>
<body>

<?php
include '../includes/navbar.php';
?>

<div class="container py-5">

    <div class="row">
        <div class="col-md-12">

            <h2>Rawr PetShop</h2>

            <?php

            $id = $_GET['id'];

            $sql = "SELECT * FROM checkout INNER JOIN cart ON cart.cart_id = checkout.cart_id INNER JOIN products ON products.id = cart.product_id WHERE checkout.cart_id = '$id'";
            $result = mysqli_query($con, $sql);
            $res = mysqli_fetch_assoc($result);

            ?>

            <div class="bg-light mb-4 p-4">
                <h6>Invoice #<?php echo $res['checkout_id'] ?></h6>
                <h3>Invoice Date: 1/16/2022</h3>
            </div>


            <div class="bg-light p-4">
                <h3>Invoiced To</h3>
                <p><?php echo $row['firstname'] . ' ' . $row['middlename'] . ' '. $row['lastname'] ?><br>
                    Bio
                </p>
            </div>


            <div class="table-responsive mt-2">
                <table class="table table-bordered">
                    <thead>
                        <th width="80%">Description</th>
                        <th>Quantity</th>
                        <th >Total</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $res['product_name']; ?></td>
                            <td><?php echo $res['quantity'] ?></td>
                            <td><?php echo $res['product_price'] * $res['quantity'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
</body>
</html>

