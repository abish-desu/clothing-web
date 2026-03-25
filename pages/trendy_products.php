<?php

include_once "../pages/connect.php";

if (!isset($empty_db_result) || !($empty_db_result instanceof EmptyDbResult)) {
    $empty_db_result = new EmptyDbResult();
}

$featured_products = $empty_db_result;

if (isset($conn) && $conn) {
    $stmt = $conn->prepare(
        "SELECT * FROM all_products WHERE product_cat = 'trendy_dress'",
    );

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $featured_products = $result;
        }
    }
}
?>
