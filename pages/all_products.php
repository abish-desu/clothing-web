<?php

include_once "../pages/connect.php";

if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM all_products");

    if ($stmt && $stmt->execute()) {
        $all_products = $stmt->get_result() ?: $empty_db_result;
    } else {
        $all_products = $empty_db_result;
    }
} else {
    $all_products = $empty_db_result;
}
?>
