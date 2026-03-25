<?php
require "../pages/connect.php";

$conn = $conn ?? null;

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

$products = [];

if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM all_products ORDER BY pid DESC");

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        $stmt->close();
    }
}
?>

<h3>Products</h3>

<?php if (isset($_GET["success_msg"])) { ?>
    <p style="color:green;text-align:center;"><?php echo htmlspecialchars(
        $_GET["success_msg"],
        ENT_QUOTES,
        "UTF-8",
    ); ?></p>
<?php } ?>

<?php if (isset($_GET["error_msg"])) { ?>
    <p style="color:red;text-align:center;"><?php echo htmlspecialchars(
        $_GET["error_msg"],
        ENT_QUOTES,
        "UTF-8",
    ); ?></p>
<?php } ?>

<?php if (isset($_GET["add_success"])) { ?>
    <p style="color:green; text-align:center;"><?php echo htmlspecialchars(
        $_GET["add_success"],
        ENT_QUOTES,
        "UTF-8",
    ); ?></p>
<?php } ?>

<?php if (isset($_GET["add_error"])) { ?>
    <p style="color:red; text-align:center;"><?php echo htmlspecialchars(
        $_GET["add_error"],
        ENT_QUOTES,
        "UTF-8",
    ); ?></p>
<?php } ?>

<?php if (isset($_GET["delete_success"])) { ?>
    <p style="color:green; text-align:center;"><?php echo htmlspecialchars(
        $_GET["delete_success"],
        ENT_QUOTES,
        "UTF-8",
    ); ?></p>
<?php } ?>

<?php if (isset($_GET["delete_error"])) { ?>
    <p style="color:red; text-align:center;"><?php echo htmlspecialchars(
        $_GET["delete_error"],
        ENT_QUOTES,
        "UTF-8",
    ); ?></p>
<?php } ?>

<div class="table-responsive">
    <table class="table table-striped table-sm align-middle">
        <thead>
            <tr>
                <th scope="col">Product Id</th>
                <th scope="col">Product Image</th>
                <th scope="col">Product Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)) { ?>
                <tr>
                    <td colspan="7" class="text-center">No products found.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?php echo (int) $product["pid"]; ?></td>
                        <td>
                            <img
                                src="<?php echo htmlspecialchars(
                                    "../images/" . $product["product_image"],
                                    ENT_QUOTES,
                                    "UTF-8",
                                ); ?>"
                                alt="<?php echo htmlspecialchars(
                                    $product["product_name"],
                                    ENT_QUOTES,
                                    "UTF-8",
                                ); ?>"
                                style="width:75px; height:75px; object-fit:cover;"
                            />
                        </td>
                        <td><?php echo htmlspecialchars(
                            $product["product_name"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $product["product_cat"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?></td>
                        <td><?php echo "Rs " . (int) $product["price"]; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="edit.php?pid=<?php echo (int) $product[
                                "pid"
                            ]; ?>">
                                Edit
                            </a>
                        </td>
                        <td>
                            <form
                                method="POST"
                                action="actions/delete_product.php"
                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                style="display:inline-block;"
                            >
                                <input type="hidden" name="pid" value="<?php echo (int) $product[
                                    "pid"
                                ]; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include "./templates/footer.php"; ?>
