<?php
session_start();

if (
    !isset($_SESSION["admin_logged_in"]) ||
    $_SESSION["admin_logged_in"] !== true
) {
    header("Location: ../login.php");
    exit();
}

require "../../pages/connect.php";

$conn = $conn ?? null;
$empty_db_result = $empty_db_result ?? null;

if (!$conn) {
    header(
        "Location: ../products.php?add_error=Database connection unavailable",
    );
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["add_product"])) {
    header("Location: ../add_products.php?error=Invalid request");
    exit();
}

$product_name = trim($_POST["product_name"] ?? "");
$product_category = trim($_POST["product_category"] ?? "");
$product_price = (int) ($_POST["price"] ?? 0);
$product_description = trim($_POST["product_description"] ?? "");

if ($product_name === "" || $product_category === "" || $product_price <= 0) {
    header(
        "Location: ../add_products.php?error=Please fill all required fields",
    );
    exit();
}

if (
    !isset($_FILES["image"]) ||
    !is_uploaded_file($_FILES["image"]["tmp_name"])
) {
    header("Location: ../add_products.php?error=Please upload a valid image");
    exit();
}

$product_image = $_FILES["image"]["tmp_name"];
$original_name = $_FILES["image"]["name"] ?? "";
$extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

if ($extension === "") {
    $extension = "jpeg";
}

$safe_name = preg_replace("/[^a-zA-Z0-9_-]/", "_", $product_name);
$image_name = $safe_name . "." . $extension;
$image_path = "../../images/" . $image_name;

if (!move_uploaded_file($product_image, $image_path)) {
    header("Location: ../products.php?add_error=Unable to upload image");
    exit();
}

$stmt = $conn->prepare(
    "INSERT INTO all_products (product_name, product_cat, price, description, product_image) VALUES (?, ?, ?, ?, ?)",
);

if (!$stmt) {
    header(
        "Location: ../products.php?add_error=Unable to prepare product insert",
    );
    exit();
}

$stmt->bind_param(
    "ssiss",
    $product_name,
    $product_category,
    $product_price,
    $product_description,
    $image_name,
);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: ../products.php?add_success=Product added successfully");
    exit();
}

$stmt->close();
header(
    "Location: ../products.php?add_error=Error occurred while adding product",
);
exit();
?>
