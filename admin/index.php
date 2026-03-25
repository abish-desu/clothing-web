<?php
include "./templates/top.php";
include "./templates/navbar.php";
include "./templates/sidebar.php";

if (
    !isset($_SESSION["admin_logged_in"]) ||
    $_SESSION["admin_logged_in"] !== true
) {
    header("location:login.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row" style="min-height: 1000px">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h3>Admin Dashboard</h3>

            <div class="alert alert-success mt-3" role="alert">
                Welcome back, <?php echo htmlspecialchars(
                    $_SESSION["admin_email"] ?? "Admin",
                    ENT_QUOTES,
                    "UTF-8",
                ); ?>.
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Quick Links</h5>
                    <p class="card-text">Use the admin panel to manage products and view customer orders.</p>
                    <a href="products.php" class="btn btn-primary mr-2">Manage Products</a>
                    <a href="customer_orders.php" class="btn btn-outline-primary">View Orders</a>
                </div>
            </div>
        </main>
    </div>
</div>
