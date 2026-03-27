<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$uri = $_SERVER["REQUEST_URI"] ?? "";
$parts = explode("/", $uri);
$page = end($parts);
$page = strtok($page, "?"); // strip query string

function nav_active(string $target, string $current): string
{
    return $current === $target ? "active" : "";
}
?>

<aside class="admin-sidebar">
    <div class="admin-sidebar-section">Menu</div>
    <ul>
        <li>
            <a href="index.php" class="<?php echo nav_active(
                "index.php",
                $page,
            ) ?:
                nav_active("", $page); ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="customer_orders.php" class="<?php echo nav_active(
                "customer_orders.php",
                $page,
            ); ?>">
                <i class="fas fa-clipboard-list"></i> Orders
            </a>
        </li>
        <li>
            <a href="products.php" class="<?php echo nav_active(
                "products.php",
                $page,
            ); ?>">
                <i class="fas fa-box"></i> Products
            </a>
        </li>
        <li>
            <a href="add_products.php" class="<?php echo nav_active(
                "add_products.php",
                $page,
            ); ?>">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
        </li>
    </ul>
</aside>

<div class="admin-main">
    <div class="admin-page-header">
        <h1 class="admin-page-title">
            <?php
            $titles = [
                "index.php" => "Dashboard",
                "" => "Dashboard",
                "customer_orders.php" => "Customer Orders",
                "products.php" => "Products",
                "add_products.php" => "Add Product",
                "edit.php" => "Edit Product",
                "order_details.php" => "Order Details",
            ];
            echo htmlspecialchars(
                $titles[$page] ??
                    ucfirst(str_replace([".php", "_"], ["", " "], $page)),
                ENT_QUOTES,
                "UTF-8",
            );
            ?>
        </h1>
    </div>
