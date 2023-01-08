<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand" href="#">
            <img src="../logo.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">
          Rawr PetShop
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0 ms-lg-4 w-75">

                <form class="d-flex ms-auto me-auto w-100">
                    <div class="input-group">
                        <input class="form-control" id="searchbox" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

            </ul>

            <?php

            if (isset($_SESSION['isLoggedIn'])){

            ?>

            <ul class="navbar-nav ms-auto mb-lg-0 d-flex">
                <li class="nav-item">
                    <button data-bs-toggle="modal" data-bs-target="#myCart" href="#" class="btn btn-outline btn-sm" type="button">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo countCart($con, $row['id'])?></span>
                    </button>
                </li>
                <li class="nav-item">
                    <button data-bs-toggle="modal" data-bs-target="#myProfile" href="#" class="btn btn-outline btn-sm" type="button">
                        <i class="bi-person me-1"></i>
                        Profile
                    </button>
                </li>
                <button onclick="window.location='../logout.php';" class="btn btn-outline btn-sm" type="button">
                    <i class="bi bi-box-arrow-left"></i>
                    Logout
                </button>
            </ul>

            <?php

            } else {
            ?>


                <ul class="navbar-nav ms-auto mb-lg-0 d-flex">
                    <li class="nav-item">
                        <button onclick="window.location='../login.php';"  href="#" class="btn btn-outline btn-sm" type="button">
                            <i class="bi bi-person"></i>
                            Login
                        </button>
                    </li>
                    <li class="nav-item">
                    <button onclick="window.location='../register.php';" class="btn btn-outline btn-sm" type="button">
                        <i class="bi bi-box-arrow-right"></i>
                        Register
                    </button>
                    </li>
                </ul>

            <?php
            }
            ?>
        </div>
    </div>
</nav>

