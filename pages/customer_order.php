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
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/jquery2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styleee.css">

    <style>
        .orders-wrapper {
            padding: 40px 80px;
        }

        .orders-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.06);
            padding: 24px;
        }

        .orders-title {
            margin-bottom: 10px;
            font-weight: 700;
        }

        .orders-subtitle {
            margin-bottom: 20px;
            color: #666;
        }

        .status-pill {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #fff3cd;
            color: #856404;
            font-size: 14px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        .empty-state a {
            text-decoration: none;
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

<section class="orders-wrapper">
    <div class="orders-card">
        <h2 class="orders-title">My Orders</h2>
        <p class="orders-subtitle">Welcome, <?php echo htmlspecialchars(
            $userName,
            ENT_QUOTES,
            "UTF-8",
        ); ?>. Here are the orders you have placed.</p>

        <?php if ($pageError !== null) { ?>
            <div class="alert alert-warning" role="alert">
                <?php echo htmlspecialchars($pageError, ENT_QUOTES, "UTF-8"); ?>
            </div>
        <?php } elseif ($orders->num_rows === 0) { ?>
            <div class="empty-state">
                <h4>No orders found</h4>
                <p>You have not placed any orders yet.</p>
                <a href="shop.php" class="btn btn-primary">Start Shopping</a>
            </div>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $orders->fetch_assoc()) { ?>
                            <tr>
                                <td>#<?php echo (int) $order[
                                    "order_id"
                                ]; ?></td>
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
                                <td>Rs <?php echo (int) $order[
                                    "order_price"
                                ]; ?></td>
                                <td>
                                    <span class="status-pill">
                                        <?php echo htmlspecialchars(
                                            $order["order_status"],
                                            ENT_QUOTES,
                                            "UTF-8",
                                        ); ?>
                                    </span>
                                </td>
                                <td>
                                    <a
                                        href="customer_order_detail.php?order_id=<?php echo (int) $order[
                                            "order_id"
                                        ]; ?>"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <p>Copyright &copy; 2024. All Rights Reserved.</p>
    </div>
</footer>

</body>
</html>
