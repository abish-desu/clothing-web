<?php
session_start();

if (isset($_SESSION["admin_logged_in"])) {
    unset($_SESSION["admin_logged_in"]);
    unset($_SESSION["admin_id"]);
    unset($_SESSION["admin_name"]);
    unset($_SESSION["admin_email"]);

    header("Location: login.php");
    exit();
}

header("Location: index.php");
exit();
?>
