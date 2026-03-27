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

<h3 style="font-size:18px; font-weight:700; color:#1e293b; margin-bottom:18px;">Dashboard Overview</h3>

<div class="alert alert-success">
    Welcome back, <strong><?php echo htmlspecialchars(
        $_SESSION["admin_email"] ?? "Admin",
        ENT_QUOTES,
        "UTF-8",
    ); ?></strong>. You are logged in to the admin panel.
</div>

<div class="row" style="gap:16px; margin-bottom:24px;">
    <a href="products.php" style="flex:1; min-width:180px; text-decoration:none;">
        <div class="card" style="padding:20px 22px; display:flex; align-items:center; gap:16px; cursor:pointer; transition:box-shadow 0.2s ease;">
            <div style="width:46px; height:46px; border-radius:10px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-box" style="font-size:20px; color:#3b82f6;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.6px;">Products</div>
                <div style="font-size:15px; font-weight:700; color:#1e293b; margin-top:2px;">Manage</div>
            </div>
        </div>
    </a>

    <a href="customer_orders.php" style="flex:1; min-width:180px; text-decoration:none;">
        <div class="card" style="padding:20px 22px; display:flex; align-items:center; gap:16px; cursor:pointer; transition:box-shadow 0.2s ease;">
            <div style="width:46px; height:46px; border-radius:10px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-clipboard-list" style="font-size:20px; color:#22c55e;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.6px;">Orders</div>
                <div style="font-size:15px; font-weight:700; color:#1e293b; margin-top:2px;">View All</div>
            </div>
        </div>
    </a>

    <a href="add_products.php" style="flex:1; min-width:180px; text-decoration:none;">
        <div class="card" style="padding:20px 22px; display:flex; align-items:center; gap:16px; cursor:pointer; transition:box-shadow 0.2s ease;">
            <div style="width:46px; height:46px; border-radius:10px; background:#fefce8; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-plus-circle" style="font-size:20px; color:#f59e0b;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.6px;">New Product</div>
                <div style="font-size:15px; font-weight:700; color:#1e293b; margin-top:2px;">Add</div>
            </div>
        </div>
    </a>
</div>

<div class="card">
    <div class="card-header">Quick Actions</div>
    <div class="card-body">
        <p class="card-text">Use the sidebar to navigate between sections, or use the buttons below.</p>
        <a href="products.php" class="btn btn-primary mr-2">
            <i class="fas fa-box"></i> Manage Products
        </a>
        <a href="customer_orders.php" class="btn btn-outline-primary">
            <i class="fas fa-clipboard-list"></i> View Orders
        </a>
    </div>
</div>

</div><!-- close admin-main -->

<?php include "./templates/footer.php"; ?>
