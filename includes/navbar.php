<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">ShopOn-it</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 w-75">

                <form class="d-flex ms-auto me-auto w-100">
                    <div class="input-group mb-3">
                        <input class="form-control" id="searchbox" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex">
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
                <button class="btn btn-outline btn-sm" type="button">
                    <i class="bi bi-box-arrow-left"></i>
                    Logout
                </button>
            </ul>

        </div>
    </div>
</nav>

