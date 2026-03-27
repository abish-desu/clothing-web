<?php
require "../pages/connect.php";

$conn = $conn ?? null;
$empty_db_result = $empty_db_result ?? new EmptyDbResult();

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

$order = null;
$orderItems = [];
$error = null;
$orderId = isset($_GET["order_id"]) ? (int) $_GET["order_id"] : 0;

if ($orderId <= 0) {
    $error = "Invalid order selected.";
} elseif (!isset($conn) || !$conn) {
    $error = "Database connection is unavailable.";
} else {
    $orderStmt = $conn->prepare(
        "SELECT * FROM orders WHERE order_id = ? LIMIT 1",
    );

    if ($orderStmt) {
        $orderStmt->bind_param("i", $orderId);
        $orderStmt->execute();
        $orderResult = $orderStmt->get_result();

        if ($orderResult && $orderResult->num_rows === 1) {
            $order = $orderResult->fetch_assoc();
        } else {
            $error = "Order not found.";
        }

        $orderStmt->close();
    } else {
        $error = "Unable to load order details.";
    }

    if ($order) {
        $itemsStmt = $conn->prepare(
            "SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC",
        );

        if ($itemsStmt) {
            $itemsStmt->bind_param("i", $orderId);
            $itemsStmt->execute();
            $itemsResult = $itemsStmt->get_result();

            if ($itemsResult) {
                while ($row = $itemsResult->fetch_assoc()) {
                    $orderItems[] = $row;
                }
            }

            $itemsStmt->close();
        } else {
            $error = "Unable to load ordered items.";
        }
    }
}
?>

<h3>Order Details</h3>

<?php if ($error !== null) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?>
    </div>
    <a href="customer_orders.php" class="btn btn-secondary">Back to Orders</a>
<?php } else { ?>
    <div class="mb-4">
        <a href="customer_orders.php" class="btn btn-secondary">Back to Orders</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Order #<?php echo htmlspecialchars(
                (string) $order["order_id"],
                ENT_QUOTES,
                "UTF-8",
            ); ?></strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars(
                        $order["name"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <p><strong>User ID:</strong> <?php echo htmlspecialchars(
                        (string) $order["uid"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars(
                        $order["u_phone"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars(
                        $order["user_address"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Status:</strong> <?php echo htmlspecialchars(
                        $order["order_status"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <p><strong>Order Date:</strong> <?php echo htmlspecialchars(
                        $order["order_date"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <p><strong>Total Price:</strong> Rs <?php echo htmlspecialchars(
                        (string) $order["order_price"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <p><strong>Total Items:</strong> <?php echo count(
                        $orderItems,
                    ); ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4>Ordered Items</h4>
    <div class="table-responsive">
        <table class="table table-striped table-sm align-middle">
            <thead>
                <tr>
                    <th scope="col">SN</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orderItems)) { ?>
                    <tr>
                        <td colspan="6" class="text-center">No items found for this order.</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($orderItems as $index => $item) {

                        $price = (int) $item["price"];
                        $quantity = (int) $item["quantity"];
                        $subtotal = $price * $quantity;
                        $imagePath = $item["product_image"];

                        if (strpos($imagePath, "../") === 0) {
                            $imagePath = $imagePath;
                        } elseif (strpos($imagePath, "/") === 0) {
                            $imagePath = $imagePath;
                        } else {
                            $imagePath = "../images/" . $imagePath;
                        }
                        ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <img
                                    src="<?php echo htmlspecialchars(
                                        $imagePath,
                                        ENT_QUOTES,
                                        "UTF-8",
                                    ); ?>"
                                    alt="<?php echo htmlspecialchars(
                                        $item["product_name"],
                                        ENT_QUOTES,
                                        "UTF-8",
                                    ); ?>"
                                    style="width: 80px; height: 100px; object-fit: cover;"
                                >
                            </td>
                            <td><?php echo htmlspecialchars(
                                $item["product_name"],
                                ENT_QUOTES,
                                "UTF-8",
                            ); ?></td>
                            <td>Rs <?php echo htmlspecialchars(
                                (string) $price,
                                ENT_QUOTES,
                                "UTF-8",
                            ); ?></td>
                            <td><?php echo htmlspecialchars(
                                (string) $quantity,
                                ENT_QUOTES,
                                "UTF-8",
                            ); ?></td>
                            <td>Rs <?php echo htmlspecialchars(
                                (string) $subtotal,
                                ENT_QUOTES,
                                "UTF-8",
                            ); ?></td>
                        </tr>
                    <?php
                    } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>

</div><!-- close admin-main -->

<?php include "./templates/footer.php"; ?>
