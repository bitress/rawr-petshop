<?php

include_once 'includes/connection.php';

if (isset($_SESSION['isLoggedIn'])){
    if (isset($_SESSION['admin'])) {
        header("Location: admin/index.php");
    } else {
        header("Location: customer/index.php");
    }
}

if (isset($_POST['submit'])) {

    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){

        if (password_verify($password, $row['password'])){
            if ($row['level'] == "customer") {

                $_SESSION['isLoggedIn'] = true;
                $_SESSION['id'] = $row['id'];

                header("Location: customer/index.php");
            } else if ($row['level'] == "admin") {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['admin'] = true;
                $_SESSION['id'] = $row['id'];
                header("Location: admin/index.php");
            } else {
                header("Location: login.php?error=failed");
            }
        } else {
            header("Location: login.php?error=Incorrect Password");
        }
    } else {

        header("Location: login.php?error=No user found with that username");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Rawr Pet Shop</title>
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



<div class="container ">
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
                        <h1 class="fs-4 card-title fw-bold mb-4">Login</h1>

                        <?php
                        if (isset($_GET['error'])){
                            $error = $_GET['error'];
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Holy guacamole!</strong> <?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <?php
                        if (isset($_GET['success'])){
                            $success = $_GET['success'];
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Nice!</strong> <?= $success ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <form method="POST" action="login.php">
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

                            <div class="d-flex align-items-center">
                                <button type="submit" name="submit" class="btn btn-primary ms-auto">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Don't have an account? <a href="register.php" class="text-dark">Create One</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<footer>
    <div class="text-center mt-5 mb-1">Copyright &copy; 2023 &mdash; Rawr Pet Shop.</div>

</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>