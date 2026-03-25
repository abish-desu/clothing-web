<?php

function get_cart_owner_key(): string
{
    if (isset($_SESSION["user_id"]) && (int) $_SESSION["user_id"] > 0) {
        return "user_" . (int) $_SESSION["user_id"];
    }

    return "guest";
}

function ensure_cart_store_initialized(): void
{
    if (!isset($_SESSION["user_carts"]) || !is_array($_SESSION["user_carts"])) {
        $_SESSION["user_carts"] = [];
    }

    $ownerKey = get_cart_owner_key();

    if (!isset($_SESSION["user_carts"][$ownerKey]) || !is_array($_SESSION["user_carts"][$ownerKey])) {
        $_SESSION["user_carts"][$ownerKey] = [];
    }

    if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
        $_SESSION["cart"] = $_SESSION["user_carts"][$ownerKey];
    }
}

function sync_cart_from_store(): void
{
    ensure_cart_store_initialized();

    $ownerKey = get_cart_owner_key();
    $_SESSION["cart"] = $_SESSION["user_carts"][$ownerKey];
}

function sync_cart_to_store(): void
{
    ensure_cart_store_initialized();

    $ownerKey = get_cart_owner_key();
    $_SESSION["user_carts"][$ownerKey] = isset($_SESSION["cart"]) && is_array($_SESSION["cart"])
        ? array_values($_SESSION["cart"])
        : [];
}

function clear_current_cart(): void
{
    ensure_cart_store_initialized();

    $_SESSION["cart"] = [];
    sync_cart_to_store();
}

function get_current_cart(): array
{
    sync_cart_from_store();
    return $_SESSION["cart"];
}

function get_current_cart_count(): int
{
    $cart = get_current_cart();
    return count($cart);
}

function get_current_cart_total(): int
{
    $cart = get_current_cart();
    $total = 0;

    foreach ($cart as $item) {
        $price = isset($item["Price"]) ? (int) $item["Price"] : 0;
        $quantity = isset($item["Quantity"]) ? (int) $item["Quantity"] : 0;
        $total += $price * $quantity;
    }

    return $total;
}

function set_logged_in_user_cart(int $userId): void
{
    if ($userId <= 0) {
        return;
    }

    if (!isset($_SESSION["user_id"])) {
        $_SESSION["user_id"] = $userId;
    }

    ensure_cart_store_initialized();
    sync_cart_from_store();
}

function store_cart_before_logout(): void
{
    if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
        sync_cart_to_store();
    }
}
?>
