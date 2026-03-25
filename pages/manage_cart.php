<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: home.php");
    exit();
}

function sync_user_cart(): void
{
    if (isset($_SESSION["user_id"]) && is_array($_SESSION["cart"] ?? null)) {
        if (
            !isset($_SESSION["user_carts"]) ||
            !is_array($_SESSION["user_carts"])
        ) {
            $_SESSION["user_carts"] = [];
        }

        $_SESSION["user_carts"][(string) $_SESSION["user_id"]] = array_values(
            $_SESSION["cart"],
        );
    }
}

$redirectPage = "home.php";

if (isset($_POST["redirect_to"]) && is_string($_POST["redirect_to"])) {
    $candidate = basename(trim($_POST["redirect_to"]));

    $allowedPages = [
        "home.php",
        "shop.php",
        "mycart.php",
        "product_view.php",
        "profile.php",
    ];

    if (in_array($candidate, $allowedPages, true)) {
        $redirectPage = $candidate;
    }
}

function redirect_with_alert(string $message, string $page): void
{
    echo "<script>
        alert(" .
        json_encode($message) .
        ");
        window.location.href = " .
        json_encode($page) .
        ";
    </script>";
    exit();
}

if (isset($_POST["Add_to_Cart"])) {
    if (!isset($_SESSION["email"]) || !isset($_SESSION["user_id"])) {
        redirect_with_alert(
            "Please login first to add products to your cart.",
            "login.html",
        );
    }

    $itemName = isset($_POST["item_name"]) ? trim($_POST["item_name"]) : "";
    $price = isset($_POST["Price"]) ? (int) $_POST["Price"] : 0;
    $itemImage = isset($_POST["item_image"]) ? trim($_POST["item_image"]) : "";

    if ($itemName === "" || $price <= 0 || $itemImage === "") {
        redirect_with_alert("Invalid product details.", $redirectPage);
    }

    if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    $existingItems = array_column($_SESSION["cart"], "item_name");

    if (in_array($itemName, $existingItems, true)) {
        redirect_with_alert("Item already in cart.", $redirectPage);
    }

    $_SESSION["cart"][] = [
        "item_name" => $itemName,
        "Price" => $price,
        "Quantity" => 1,
        "item_image" => $itemImage,
    ];

    sync_user_cart();
    redirect_with_alert("Item added to cart.", $redirectPage);
}

if (isset($_POST["Remove_item"])) {
    if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $key => $value) {
            if (($value["item_name"] ?? "") === ($_POST["item_name"] ?? "")) {
                unset($_SESSION["cart"][$key]);
                $_SESSION["cart"] = array_values($_SESSION["cart"]);
                break;
            }
        }
    }

    sync_user_cart();
    redirect_with_alert("Item removed from cart.", "mycart.php");
}

if (isset($_POST["Mod_Quantity"])) {
    $newQuantity = isset($_POST["Mod_Quantity"])
        ? (int) $_POST["Mod_Quantity"]
        : 1;

    if ($newQuantity < 1) {
        $newQuantity = 1;
    }

    if ($newQuantity > 10) {
        $newQuantity = 10;
    }

    if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $key => $value) {
            if (($value["item_name"] ?? "") === ($_POST["item_name"] ?? "")) {
                $_SESSION["cart"][$key]["Quantity"] = $newQuantity;
                break;
            }
        }
    }

    sync_user_cart();
    header("Location: mycart.php");
    exit();
}

header("Location: home.php");
exit();
?>
