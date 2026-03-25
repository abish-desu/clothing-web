<?php
require "../../pages/connect.php";
session_start();

if (
    !isset($_SESSION["admin_logged_in"]) ||
    $_SESSION["admin_logged_in"] !== true
) {
    header("Location: ../login.php");
    exit();
}

if (!isset($conn) || !$conn) {
    header(
        "Location: ../products.php?error_msg=Database connection unavailable",
    );
    exit();
}

if (!isset($_POST["pid"]) || !is_numeric($_POST["pid"])) {
    header("Location: ../products.php?error_msg=Invalid product selected");
    exit();
}

$productId = (int) $_POST["pid"];

$imageName = null;
$selectStmt = $conn->prepare(
    "SELECT product_image FROM all_products WHERE pid = ? LIMIT 1",
);

if (!$selectStmt) {
    header(
        "Location: ../products.php?error_msg=Unable to prepare product lookup",
    );
    exit();
}

$selectStmt->bind_param("i", $productId);
$selectStmt->execute();
$result = $selectStmt->get_result();

if (!$result || $result->num_rows !== 1) {
    $selectStmt->close();
    header("Location: ../products.php?error_msg=Product not found");
    exit();
}

$product = $result->fetch_assoc();
$imageName = $product["product_image"] ?? null;
$selectStmt->close();

$deleteStmt = $conn->prepare("DELETE FROM all_products WHERE pid = ?");

if (!$deleteStmt) {
    header(
        "Location: ../products.php?error_msg=Unable to prepare delete action",
    );
    exit();
}

$deleteStmt->bind_param("i", $productId);

if ($deleteStmt->execute()) {
    $deleteStmt->close();

    if (!empty($imageName)) {
        $imagePath = "../../images/" . $imageName;

        if (is_file($imagePath)) {
            @unlink($imagePath);
        }
    }

    header(
        "Location: ../products.php?success_msg=Product deleted successfully",
    );
    exit();
}

$errorMessage = $deleteStmt->error;
$deleteStmt->close();

header(
    "Location: ../products.php?error_msg=" .
        urlencode("Delete failed: " . $errorMessage),
);
exit();
?>
