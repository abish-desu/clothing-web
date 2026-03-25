<?php
require "../pages/connect.php";

$conn = $conn ?? null;
$empty_db_result = $empty_db_result ?? null;

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

$orders = [];
$pageError = null;

if (!isset($conn) || !$conn) {
    $pageError = "Database connection is unavailable.";
} else {
    $stmt = $conn->prepare(
        "SELECT * FROM orders ORDER BY order_date DESC, order_id DESC",
    );

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        $stmt->close();
    } else {
        $pageError = "Unable to load customer orders.";
    }
}
?>

<h3>Customers Orders</h3>

<?php if ($pageError !== null) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($pageError, ENT_QUOTES, "UTF-8"); ?>
    </div>
<?php } else { ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Order Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">User Id</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Address</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)) { ?>
                    <tr>
                        <td colspan="8" class="text-center">No orders found.</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td><?php echo (int) $order["order_id"]; ?></td>
                            <td><?php echo htmlspecialchars(
                                $order["name"],
                                ENT_QUOTES,
                                "UTF-8",
                            ); ?></td>
                            <td><?php echo (int) $order["uid"]; ?></td>
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
                            <td><?php echo htmlspecialchars(
                                $order["order_date"],
                                ENT_QUOTES,
                                "UTF-8",
                            ); ?></td>
                            <td><?php echo htmlspecialchars(
                                $order["order_status"],
                                ENT_QUOTES,
                                "UTF-8",
                            ); ?></td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="order_details.php?order_id=<?php echo (int) $order[
                                        "order_id"
                                    ]; ?>"
                                >
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>

<?php include "./templates/footer.php"; ?>
