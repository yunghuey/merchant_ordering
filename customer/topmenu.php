<div class="top-bar">
    <div class="container">
        <div class="text-center pt-3"><h2><a href="index.php" class="logo">FARM TREASURE</a></h2></div>
    </div>
    <div class="float-end mx-4">
        <div class="dropdown">
            <a href="#" class="dropdown-toggle side-nav" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="far fa-user"></i>
                <?php echo $_SESSION['username']; ?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="editprofile.php">View Profile</a></li>
                <li><a class="dropdown-item" href="../forgotpassword.php">Reset password</a></li>
                <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <nav class="navbar navbar-expand-md mx-4">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="http://localhost/merchant_ordering/customer/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://localhost/merchant_ordering/customer/productdisplay.php">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://localhost/merchant_ordering/customer/cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://localhost/merchant_ordering/customer/history.php">History</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
