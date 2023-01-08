<?php

include_once 'includes/connection.php';

    if (isset($_POST['submit'])){


        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];
        $pass = md5($repeat_password);

        if (empty($firstname)){
            header("Location: register.php?error=Please enter your firstname!");
        }
        if (empty($middlename)){
            header("Location: register.php?error=Please enter your middlename!");
        }
        if (empty($lastname)){
            header("Location: register.php?error=Please enter your lastname!");
        }
        if (empty($address)){
            header("Location: register.php?error=Please enter your address!");
        }

        if (empty($username)){
            header("Location: register.php?error=Please enter your username!");
        }

        if (empty($password)){
            header("Location: register.php?error=Please enter your password!");
        }
        if (empty($repeat_password)){
            header("Location: register.php?error=Please repeat your password!");
        }

    $sql = "INSERT INTO `users` (`username`, `password`, `firstname`, `middlename`, `lastname`, `address`) VALUES ('$username', '$pass', '$firstname', '$middlename', '$lastname', '$address')";
        $stmt = mysqli_query($con, $sql);
        if ($stmt === true){
                header("Location: index.php?success=You may now login");
            } else {
                echo mysqli_error($con);
            }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register - Rawr Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');

        body {
            font-family: 'DM Sans', sans-serif;
        }

    </style>
<body>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-7 col-sm-9">
                <div class="text-center my-5">
                    <img src="logo.png" alt="logo" width="150">
                </div>
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

                        <form method="POST" action="register.php">
                            <div class="row">

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
                <div class="text-center mt-5 text-muted">
                    Copyright &copy; 2022 &mdash; ShopOn-it
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
