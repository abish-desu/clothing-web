<?php
require "connect.php";
session_start();

$conn = $conn ?? null;
$empty_db_result = $empty_db_result ?? new EmptyDbResult();

if (!isset($_SESSION["email"]) || !isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$orderId = isset($_GET["order_id"]) ? (int) $_GET["order_id"] : 0;
$userId = (int) $_SESSION["user_id"];

if ($orderId <= 0) {
    header("Location: customer_order.php");
    exit();
}

$order = null;
$orderItems = $empty_db_result;
$pageError = null;

if (!$conn) {
    $pageError = "Database connection is unavailable.";
} else {
    $orderStmt = $conn->prepare(
        "SELECT order_id, name, order_price, order_status, uid, u_phone, user_address, order_date
         FROM orders
         WHERE order_id = ? AND uid = ?
         LIMIT 1",
    );

    if ($orderStmt) {
        $orderStmt->bind_param("ii", $orderId, $userId);
        $orderStmt->execute();
        $orderResult = $orderStmt->get_result();

        if ($orderResult && $orderResult->num_rows === 1) {
            $order = $orderResult->fetch_assoc();

            $itemsStmt = $conn->prepare(
                "SELECT product_name, product_image, price, quantity
                 FROM order_items
                 WHERE order_id = ? AND uid = ?
                 ORDER BY id ASC",
            );

            if ($itemsStmt) {
                $itemsStmt->bind_param("ii", $orderId, $userId);
                $itemsStmt->execute();
                $itemsResult = $itemsStmt->get_result();
                $orderItems =
                    $itemsResult ?: $empty_db_result ?? new EmptyDbResult();
                $itemsStmt->close();
            } else {
                $pageError = "Unable to load ordered items.";
            }
        } else {
            $pageError = "Order not found.";
        }

        $orderStmt->close();
    } else {
        $pageError = "Unable to load order details.";
    }
}

$cartCount = 0;
if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
    $cartCount = count($_SESSION["cart"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?php echo $orderId; ?> — Details</title>
    <link rel="stylesheet" href="styleee.css">
</head>
<body>

<header id="header">
    <a href="home.php" class="nav-logo">
        <img src="/PROJECT/images/l3.png" alt="Royal Butterfly">
    </a>
    <ul id="navbar">
        <li><a href="home.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a class="active" href="customer_order.php">My Orders</a></li>
        <li>
            <a href="mycart.php" class="cart-link">
                <i class="bi bi-cart3"></i>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-count"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li>
            <?php if (isset($_SESSION["email"])) { ?>
                <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
            <?php } else { ?>
                <a href="login.html"><i class="bi bi-person-fill"></i> Login</a>
            <?php } ?>
        </li>
    </ul>
</header>

<div class="order-detail-wrapper">

    <a href="customer_order.php" class="order-back-link">
        <i class="bi bi-arrow-left"></i> Back to My Orders
    </a>

    <?php if ($pageError !== null) { ?>
        <div class="order-detail-error">
            <i class="bi bi-exclamation-circle"></i>
            <?php echo htmlspecialchars($pageError); ?>
        </div>

    <?php } elseif ($order !== null) {

        $status = strtolower(
            htmlspecialchars($order["order_status"], ENT_QUOTES, "UTF-8"),
        );
        $badgeClass = "badge-" . $status;
        ?>
        <div class="order-detail-layout">

            <!-- ── Left: Order Summary ── -->
            <div class="order-summary-panel">
                <h3>Order #<?php echo (int) $order["order_id"]; ?></h3>
                <span class="order-date-text">
                    Placed on <?php echo htmlspecialchars(
                        $order["order_date"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?>
                </span>

                <div class="order-meta-row">
                    <span class="order-meta-label">Status</span>
                    <span class="<?php echo $badgeClass; ?>">
                        <?php echo ucfirst($status); ?>
                    </span>
                </div>

                <div class="order-meta-row">
                    <span class="order-meta-label">Customer</span>
                    <span class="order-meta-value">
                        <?php echo htmlspecialchars(
                            $order["name"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>
                    </span>
                </div>

                <div class="order-meta-row">
                    <span class="order-meta-label">Phone</span>
                    <span class="order-meta-value">
                        <?php echo htmlspecialchars(
                            $order["u_phone"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>
                    </span>
                </div>

                <div class="order-meta-row">
                    <span class="order-meta-label">Delivery Address</span>
                    <span class="order-meta-value">
                        <?php echo htmlspecialchars(
                            $order["user_address"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>
                    </span>
                </div>

                <hr class="order-divider">

                <div class="order-meta-row order-total-row">
                    <span class="order-meta-label">Order Total</span>
                    <span class="order-meta-value">
                        Rs <?php echo (int) $order["order_price"]; ?>
                    </span>
                </div>
            </div>

            <!-- ── Right: Ordered Items ── -->
            <div class="order-items-panel">
                <h3>Ordered Items</h3>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $orderItems->fetch_assoc()) {

                            $price = isset($item["price"])
                                ? (int) $item["price"]
                                : 0;
                            $quantity = isset($item["quantity"])
                                ? (int) $item["quantity"]
                                : 0;
                            $subtotal = $price * $quantity;
                            ?>
                            <tr>
                                <td>
                                    <img
                                        src="<?php echo htmlspecialchars(
                                            $item["product_image"],
                                            ENT_QUOTES,
                                            "UTF-8",
                                        ); ?>"
                                        alt="<?php echo htmlspecialchars(
                                            $item["product_name"],
                                            ENT_QUOTES,
                                            "UTF-8",
                                        ); ?>"
                                        class="item-thumb"
                                    >
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars(
                                        $item["product_name"],
                                        ENT_QUOTES,
                                        "UTF-8",
                                    ); ?></strong>
                                </td>
                                <td>Rs <?php echo $price; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><strong>Rs <?php echo $subtotal; ?></strong></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>

                <div class="items-grand-total">
                    Grand Total: <strong>Rs <?php echo (int) $order[
                        "order_price"
                    ]; ?></strong>
                </div>
            </div>

        </div>
    <?php
    } ?>

</div>

<footer class="footer">
    <p>Copyright &copy; 2024. All Rights Reserved.</p>
</footer>

</body>
</html>
