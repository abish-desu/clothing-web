<?php

include_once "../pages/connect.php";

if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM products LIMIT 5");

    if ($stmt && $stmt->execute()) {
        $featured_products = $stmt->get_result() ?: $empty_db_result;
    } else {
        $featured_products = $empty_db_result;
    }
} else {
    $featured_products = $empty_db_result;
}

?>
