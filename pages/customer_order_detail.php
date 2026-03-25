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
    <title>My Order Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleee.css">
    <style>
        .order-summary-card,
        .order-items-card {
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        }

        .order-page-title {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .order-meta-label {
            font-weight: 600;
            color: #444;
        }

        .order-status-badge {
            text-transform: capitalize;
            font-size: 14px;
        }

        .item-thumb {
            width: 90px;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .back-link {
            text-decoration: none;
            color: #ac5930;
            font-weight: 600;
        }

        .back-link:hover {
            color: #8c4724;
        }
    </style>
</head>
<body>
    <section id="header">
        <img src="/PROJECT/images/l3.png" height="40" width="38" alt="Logo"><a href="home.php"></a>
        <div>
            <ul id="navbar">
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a class="active" href="customer_order.php">My Orders</a></li>
                <li>
                    <a href="mycart.php">
                        <i class="bi bi-cart-plus-fill" style="font-size: 22px;">(<?php echo $cartCount; ?>)</i>
                    </a>
                </li>
                <li>
                    <?php if (isset($_SESSION["email"])) { ?>
                        <a href="logout.php"><i class="bi bi-box-arrow-right" style="font-size: 22px;"></i> Logout</a>
                    <?php } else { ?>
                        <a href="login.html"><i class="bi bi-person-fill" style="font-size: 22px;"></i> Login</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </section>

    <div class="container py-5">
        <div class="mb-4">
            <a class="back-link" href="customer_order.php">
                <i class="bi bi-arrow-left"></i> Back to My Orders
            </a>
        </div>

        <?php if ($pageError !== null) { ?>
            <div class="alert alert-warning"><?php echo htmlspecialchars(
                $pageError,
            ); ?></div>
        <?php } elseif ($order !== null) { ?>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="order-summary-card p-4">
                        <h2 class="order-page-title">Order #<?php echo (int) $order[
                            "order_id"
                        ]; ?></h2>
                        <p class="text-muted mb-4">Placed on <?php echo htmlspecialchars(
                            $order["order_date"],
                        ); ?></p>

                        <p class="mb-3">
                            <span class="order-meta-label">Status:</span>
                            <span class="badge bg-primary order-status-badge">
                                <?php echo htmlspecialchars(
                                    $order["order_status"],
                                ); ?>
                            </span>
                        </p>

                        <p class="mb-3">
                            <span class="order-meta-label">Customer:</span><br>
                            <?php echo htmlspecialchars($order["name"]); ?>
                        </p>

                        <p class="mb-3">
                            <span class="order-meta-label">Phone:</span><br>
                            <?php echo htmlspecialchars($order["u_phone"]); ?>
                        </p>

                        <p class="mb-3">
                            <span class="order-meta-label">Address:</span><br>
                            <?php echo htmlspecialchars(
                                $order["user_address"],
                            ); ?>
                        </p>

                        <hr>

                        <p class="mb-0">
                            <span class="order-meta-label">Total:</span>
                            <strong>Rs <?php echo (int) $order[
                                "order_price"
                            ]; ?></strong>
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="order-items-card p-4">
                        <h3 class="mb-4">Ordered Items</h3>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while (
                                        $item = $orderItems->fetch_assoc()
                                    ) {

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
                                                    ); ?>"
                                                    alt="<?php echo htmlspecialchars(
                                                        $item["product_name"],
                                                    ); ?>"
                                                    class="item-thumb"
                                                >
                                            </td>
                                            <td><?php echo htmlspecialchars(
                                                $item["product_name"],
                                            ); ?></td>
                                            <td>Rs <?php echo $price; ?></td>
                                            <td><?php echo $quantity; ?></td>
                                            <td>Rs <?php echo $subtotal; ?></td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <h5 class="mb-0">Grand Total: Rs <?php echo (int) $order[
                                "order_price"
                            ]; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
