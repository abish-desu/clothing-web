<?php
require "../pages/connect.php";
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

if (isset($_GET["pid"]) && !empty($_GET["pid"])) {
    $product_id = (int) $_GET["pid"];

    if ($conn) {
        $stmt = $conn->prepare("SELECT * FROM all_products WHERE pid = ?");
        if ($stmt) {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
            $stmt->close();
        }
    }
} elseif (isset($_POST["edit_button"])) {
    $product_id = (int) ($_POST["product_id"] ?? 0);
    $product_name = trim($_POST["product_name"] ?? "");
    $product_category = trim($_POST["product_category"] ?? "");
    $price = (int) ($_POST["price"] ?? 0);

    if (!$conn) {
        header(
            "location: products.php?error_msg=Database connection unavailable",
        );
        exit();
    }

    $stmt = $conn->prepare(
        "UPDATE all_products SET product_name = ?, product_cat = ?, price = ? WHERE pid = ?",
    );

    if ($stmt) {
        $stmt->bind_param(
            "ssii",
            $product_name,
            $product_category,
            $price,
            $product_id,
        );

        if ($stmt->execute()) {
            $stmt->close();
            header(
                "location: products.php?success_msg=Product updated successfully...!!!",
            );
            exit();
        }

        $stmt->close();
    }

    header("location: products.php?error_msg=Error occured");
    exit();
} else {
    header("location: products.php");
    exit();
}
?>

<div class="mx-auto" style="max-width:580px;">
                    <form id="edit-form" method="POST" action="edit.php">
                        <p style="color: red;">
                            <?php if (isset($_GET["error"])) {
                                echo htmlspecialchars(
                                    $_GET["error"],
                                    ENT_QUOTES,
                                    "UTF-8",
                                );
                            } ?>
                        </p>

                        <?php if (empty($products)) { ?>
                            <div class="alert alert-danger">Product not found.</div>
                            <a href="products.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Products
                            </a>
                        <?php } else { ?>
                            <?php foreach ($products as $product) { ?>
                                <div class="form-group mt-2">
                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="<?php echo (int) $product[
                                            "pid"
                                        ]; ?>"
                                    >

                                    <label>Product Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="product-name"
                                        name="product_name"
                                        value="<?php echo htmlspecialchars(
                                            $product["product_name"],
                                            ENT_QUOTES,
                                            "UTF-8",
                                        ); ?>"
                                        placeholder="Title"
                                        required
                                    >
                                </div>

                                <div class="form-group mt-2">
                                    <label>Category</label>
                                    <select class="form-control" id="product-category" name="product_category" required>
                                        <option value="spring collection" <?php echo $product[
                                            "product_cat"
                                        ] === "spring collection"
                                            ? "selected"
                                            : ""; ?>>
                                            Spring Collection
                                        </option>
                                        <option value="new_arrival" <?php echo $product[
                                            "product_cat"
                                        ] === "new_arrival"
                                            ? "selected"
                                            : ""; ?>>
                                            New Arrival
                                        </option>
                                        <option value="summer_wear" <?php echo $product[
                                            "product_cat"
                                        ] === "summer_wear"
                                            ? "selected"
                                            : ""; ?>>
                                            Summer Wear
                                        </option>
                                        <option value="trendy_dress" <?php echo $product[
                                            "product_cat"
                                        ] === "trendy_dress"
                                            ? "selected"
                                            : ""; ?>>
                                            Trendy Dress
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Price</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="product-price"
                                        name="price"
                                        value="<?php echo (int) $product[
                                            "price"
                                        ]; ?>"
                                        placeholder="Price"
                                        required
                                    >
                                </div>

                                <button type="submit" name="edit_button" class="btn btn-primary mt-3">Save</button>
                            <?php } ?>
                        <?php } ?>
                    </form>
</div>

</div><!-- close admin-main -->

<?php include "./templates/footer.php"; ?>
