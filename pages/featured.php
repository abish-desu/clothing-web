<?php

include_once "../pages/connect.php";

if ($conn) {
    $stmt = $conn->prepare(
        "SELECT * FROM all_products WHERE product_cat = 'spring collection'",
    );

    if ($stmt && $stmt->execute()) {
        $featured_products = $stmt->get_result() ?: $empty_db_result;
    } else {
        $featured_products = $empty_db_result;
    }
} else {
    $featured_products = $empty_db_result;
}
?>
