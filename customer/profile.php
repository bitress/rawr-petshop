<?php

include_once '../includes/connection.php';

if (isset($_SESSION['isLoggedIn'])){
    $id = $_SESSION['id'];


    $sql = "SELECT * FROM users WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

}


if (isset($_POST['submit'])){


    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $id = $row['id'];

    if ($password == ""){
        // Dont change password
        $newpassword = $row['password'];
    } else {
        $newpassword = md5($password);
    }


// Check if image file is a actual image or fake image
    if(!empty($_FILES["profile_picture"])) {

        // File upload
        $target_dir = "../images/pfp/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
//        if($check !== false) {
//            echo "File is an image - " . $check["mime"] . ".";
//            $uploadOk = 1;
//        } else {
//            echo "File is not an image.";
//            $uploadOk = 0;
//        }

//        Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
//            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
//            echo "Sorry, your file was not uploaded.";

    // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
//                echo "The file ". basename( $_FILES["profile_picture"]["name"]). " has been uploaded.";
            } else {
//                echo "Sorry, there was an error uploading your file.";
            }
     }
        $profile_picture = $_FILES["profile_picture"]["name"];
} else {
        $profile_picture = $_POST['original_pfp'];
    }




    $sql = "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', address='$address', username='$username', profile_picture='$profile_picture', password='$newpassword' WHERE id=$id";

    if (mysqli_query($con, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($con);
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
    <div class="row mb-4 g-4">

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="<?php echo WEBSITE_DOMAIN.'images/pfp/'. $row['profile_picture'] ?>" alt="Admin" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4><?php echo $row['firstname'] . ' ' .  $row['middlename'] .' '.  $row['lastname']; ?></h4>
                            <p class="text-secondary mb-1"><?php echo $row['address']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3>Update Profile</h3>
                    <form method="POST" action="profile.php" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-12">
                                <label class="mb-2 text-muted">Profile Picture</label>
                                <input type="file" id="profile_picture" class="form-control" name="profile_picture" ><br>
                            </div>

                            <input type="hidden" name="original_pfp" value="<?php echo $row['profile_picture']; ?>">

                            <div class="col-md-4">
                                <label class="mb-2 text-muted" for="username">Firstname</label>
                                <input id="username" type="text" class="form-control" name="firstname" value="<?php echo $row['firstname']; ?>" required autofocus>
                            </div>

                            <div class="col-md-4">
                                <label class="mb-2 text-muted" for="username">Middlename</label>
                                <input id="username" type="text" class="form-control" name="middlename" value="<?php echo $row['middlename']; ?>" required autofocus>
                            </div>

                            <div class="col-md-4">
                                <label class="mb-2 text-muted" for="username">Lastname</label>
                                <input id="username" type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']; ?>" required autofocus>
                            </div>

                        </div>


                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="username">Address</label>
                            <input id="username" type="text" class="form-control" name="address" value="<?php echo $row['address']; ?>" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="username">Username</label>
                            <input id="username" type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required autofocus>
                        </div>

                        <div class="mb-3">
                            <div class="mb-2 w-100">
                                <label class="text-muted" for="password">Password</label>
                            </div>
                            <input id="password" type="password" class="form-control" name="password" >
                        </div>


                        <div class="mb-3">
                            <div class="mb-2 w-100">
                                <label class="text-muted" for="repeat_password">Confirm Password</label>
                            </div>
                            <input id="repeat_password" type="password" class="form-control" name="repeat_password"     >
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" name="submit" class="btn btn-primary ms-auto">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </div>

</div>

<footer class="footer text-center bg-light p-4">
    Copyright &copy; 2023 - Rawr Pet Shop
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

</body>
</html>

