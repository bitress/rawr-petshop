<?php

include_once 'includes/connection.php';

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['repeat_password']);
    $profile_picture = $_FILES['profile_picture']['name'];
    $tmp_image = $_FILES['profile_picture']['tmp_name'];

    if (empty($username) ||  empty($firstname) || empty($lastname) || empty($password) || empty($confirm_password) || empty($profile_picture) || empty($address)) {
        header("Location: register.php?error=All fields are required!");

    } elseif ($password != $confirm_password) {
        header("Location: register.php?error=Password do not match!");
    } else {

            // Check if the username is already in use
            $username_check = mysqli_query($con, "SELECT `username` FROM `users` WHERE username = '$username'");
            $username_count = mysqli_num_rows($username_check);
            if ($username_count > 0) {
                header("Location: register.php?error=That username is already in use.");
            } else {

                $pass = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO `users` (`username`, `password`, `firstname`, `middlename`, `lastname`, `address`, `profile_picture`) VALUES ('$username', '$pass', '$firstname', '$middlename', '$lastname', '$address', '$profile_picture')";
                $stmt = mysqli_query($con, $sql);
                if ($stmt === true) {

                    $target = "images/pfp/" . basename($profile_picture);
                    move_uploaded_file($tmp_image, $target);

                    header("Location: login.php?success=You may now login");
                } else {
                    echo "Error: " . $stmt . "<br>" . mysqli_error($con);
                }
            }
        }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register - Rawr Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');

        body {
            font-family: 'DM Sans', sans-serif;

        }
    </style>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand" href="#">
            <img src="logo.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">
            Rawr PetShop
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">


            <ul class="navbar-nav ms-auto mb-lg-0 d-flex">
                <li class="nav-item">
                    <button onclick="window.location='login.php';"  href="#" class="btn btn-outline btn-sm" type="button">
                        <i class="bi bi-person"></i>
                        Login
                    </button>
                </li>
                <li class="nav-item">
                    <button onclick="window.location='register.php';" class="btn btn-outline btn-sm" type="button">
                        <i class="bi bi-box-arrow-right"></i>
                        Register
                    </button>
                </li>
            </ul>

        </div>
    </div>
</nav>
    <div class="container">
        <div class="row justify-content-sm-center my-5 py-5">

            <div class="col-6">
                <div class="text-center">
                    <img src="logo.png" alt="logo" width="200">
                </div>
                <div class="text-center">
                    <h1>Welcome to Rawr Pet Shop</h1>
                    <p>Unleash the love with a pet from our shop</p>
                </div>
            </div>

            <div class="col-6">

                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Rawr Pet Shop</h1>

                        <?php

                        if (isset($_GET['error'])){
                            $error = $_GET['error'];


                        ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Holy guacamole!</strong> <?php echo $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php
                        }
                        ?>

                        <form method="POST" action="register.php" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-md-12">
                                    <label class="mb-2 text-muted">Profile Picture</label>
                                    <input type="file" id="profile_picture" class="form-control" name="profile_picture" required><br>
                                </div>

                                <div class="col-md-4">
                                    <label class="mb-2 text-muted" for="username">Firstname</label>
                                    <input id="username" type="text" class="form-control" name="firstname" value="" required autofocus>
                                </div>

                                <div class="col-md-4">
                                    <label class="mb-2 text-muted" for="username">Middlename</label>
                                    <input id="username" type="text" class="form-control" name="middlename" value="" required autofocus>
                                </div>

                                <div class="col-md-4">
                                    <label class="mb-2 text-muted" for="username">Lastname</label>
                                    <input id="username" type="text" class="form-control" name="lastname" value="" required autofocus>
                                </div>

                            </div>


                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="username">Address</label>
                                <input id="username" type="text" class="form-control" name="address" value="" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                            </div>

                            <div class="mb-3">
                                <div class="mb-2 w-100">
                                    <label class="text-muted" for="password">Password</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>


                            <div class="mb-3">
                                <div class="mb-2 w-100">
                                    <label class="text-muted" for="repeat_password">Confirm Password</label>
                                </div>
                                <input id="repeat_password" type="password" class="form-control" name="repeat_password" required>
                            </div>

                            <p class="form-text text-muted" style="font-size: 12px">
                                By creating an account with our store, you will be able to move through the checkout process faster, store shipping addresses, view and track your orders in your account and more.
                            </p>

                            <div class="d-flex align-items-center">
                                <button type="submit" name="submit" class="btn btn-primary ms-auto">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Already have an account? <a href="index.php" class="text-dark">Login</a>                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<footer>
    <div class="text-center mt-5 text-muted">
        Copyright &copy; 2022 &mdash; ShopOn-it
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
