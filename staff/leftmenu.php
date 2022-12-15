<nav>
    <ul class="navigate">
        <li>
            <a href="http://localhost/merchant_ordering/staff/index.php" class="side-nav logo">
                <span class="nav-item">staff</span>
            </a>
        </li>
        <li><div class="dropdown">
            <a href="#" class="dropdown-toggle side-nav" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-box"></i>
                <span class="nav-item">Product</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../product/newproduct.php">Add Product</a></li>
                <li><a class="dropdown-item" href="">View All Product</a></li>
            </ul>
        </div></li>
        <li>
            <a href="#" class="side-nav">
                <i class="fas fa-chart-line"></i>
                <span class="nav-item">Sales</span>
            </a>
        </li>
        <li>
            <a href="#" class="side-nav">
                <i class="fas fa-sticky-note"></i>
                <span class="nav-item">Order</span>
            </a>
        </li>
        <li><div class="dropdown">
            <a href="#" class="dropdown-toggle side-nav" data-bs-toggle="dropdown" aria-expanded="false"> 
                <i class="fas fa-briefcase"></i>
                <span class="nav-item">Staff</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="http://localhost/merchant_ordering/staff/newstaff.php">Create New</a></li>
                <li><a class="dropdown-item" href="http://localhost/merchant_ordering/staff/stafflist.php">View All</a></li>
                <li><a class="dropdown-item" href="http://localhost/merchant_ordering/staff/archivelist.php">View archive</a></li>
            </ul>
        </div></li>
        <li><div class="dropdown">
            <a href="#" class="dropdown-toggle side-nav" data-bs-toggle="dropdown" aria-expanded="false"> 
                <i class="fas fa-user-friends"></i>
                <span class="nav-item">Customer</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Create New</a></li>
                <li><a class="dropdown-item" href="#">View All</a></li>
            </ul>
        </div></li>
        <li>
            <a href="../forgotpassword.php" class="side-nav">
                <i class="fas fa-lock"></i>
                <span class="nav-item">Reset password</span>
            </a>
        </li>
    </ul>
</nav>
<div class="top-bar">    
    <div class="float-end">
        <div class="dropdown">
            <a href="#" class="dropdown-toggle side-nav" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="far fa-user"></i>
                <?php echo $_SESSION['username']; ?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
        
    </div>
</div>