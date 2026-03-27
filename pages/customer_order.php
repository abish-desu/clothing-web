<?php
require "connect.php";
session_start();

$conn = $conn ?? null;
$empty_db_result = $empty_db_result ?? new EmptyDbResult();

if (!isset($_SESSION["email"]) || !isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$userId = (int) $_SESSION["user_id"];
$userName = $_SESSION["name"] ?? "User";
$orders = $empty_db_result;
$pageError = null;

if (!isset($conn) || !$conn) {
    $pageError = "Database connection is unavailable. Please try again later.";
} else {
    $stmt = $conn->prepare(
        "SELECT order_id, name, order_price, order_status, u_phone, user_address, order_date
         FROM orders
         WHERE uid = ?
         ORDER BY order_date DESC, order_id DESC",
    );

    if ($stmt) {
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result) {
                $orders = $result;
            }
        } else {
            $pageError = "Unable to load your orders right now.";
        }

        $stmt->close();
    } else {
        $pageError = "Unable to prepare the orders query.";
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
    <title>My Orders</title>
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

<div class="orders-wrapper">

    <div class="orders-page-header">
        <h2>My Orders</h2>
        <p>Welcome back, <?php echo htmlspecialchars(
            $userName,
            ENT_QUOTES,
            "UTF-8",
        ); ?>. Here are your placed orders.</p>
    </div>

    <?php if ($pageError !== null) { ?>
        <div class="orders-error">
            <i class="bi bi-exclamation-circle"></i>
            <?php echo htmlspecialchars($pageError, ENT_QUOTES, "UTF-8"); ?>
        </div>

    <?php } elseif ($orders->num_rows === 0) { ?>
        <div class="orders-empty">
            <i class="bi bi-bag-x"></i>
            <h4>No orders yet</h4>
            <p>You haven't placed any orders. Start shopping to see them here.</p>
            <a href="shop.php" class="btn">Browse Shop</a>
        </div>

    <?php } else { ?>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()) {
                    $status = strtolower(
                        htmlspecialchars(
                            $order["order_status"],
                            ENT_QUOTES,
                            "UTF-8",
                        ),
                    ); ?>
                    <tr>
                        <td><strong>#<?php echo (int) $order[
                            "order_id"
                        ]; ?></strong></td>
                        <td><?php echo htmlspecialchars(
                            $order["order_date"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $order["u_phone"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $order["user_address"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?></td>
                        <td><strong>Rs <?php echo (int) $order[
                            "order_price"
                        ]; ?></strong></td>
                        <td>
                            <span class="status-pill <?php echo $status; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td>
                            <a href="customer_order_detail.php?order_id=<?php echo (int) $order[
                                "order_id"
                            ]; ?>"
                               class="view-order-link">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    <?php } ?>

</div>

<footer class="footer">
    <p>Copyright &copy; 2024. All Rights Reserved.</p>
</footer>

</body>
</html>
