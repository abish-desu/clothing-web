<?php
session_start();

if (isset($_SESSION["email"])) {
    if (isset($_SESSION["user_id"])) {
        if (
            !isset($_SESSION["user_carts"]) ||
            !is_array($_SESSION["user_carts"])
        ) {
            $_SESSION["user_carts"] = [];
        }

        $_SESSION["user_carts"][$_SESSION["user_id"]] = $_SESSION["cart"] ?? [];
    }

    unset($_SESSION["user_id"]);
    unset($_SESSION["name"]);
    unset($_SESSION["email"]);
    unset($_SESSION["gTotal"]);
    unset($_SESSION["order_id"]);

    header("Location: login.html");
    exit();
}

header("Location: home.php");
exit();
?>
