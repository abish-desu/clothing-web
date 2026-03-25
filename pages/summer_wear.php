<?php

include_once "../pages/connect.php";

if (!$conn) {
    $featured_products = $empty_db_result;
    return;
}

$stmt = $conn->prepare(
    "SELECT * FROM all_products WHERE product_cat = 'summer_wear'",
);

if (!$stmt) {
    $featured_products = $empty_db_result;
    return;
}

if ($stmt->execute()) {
    $featured_products = $stmt->get_result() ?: $empty_db_result;
} else {
    $featured_products = $empty_db_result;
}

?>
