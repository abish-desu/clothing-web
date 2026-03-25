<?php
require "connect.php";

session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.html");
    exit();
}

if (!isset($_POST["order-btn"])) {
    header("Location: home.php");
    exit();
}

if (!isset($conn) || !$conn) {
    echo "<script>
        alert('Database connection is unavailable. Please try again later.');
        window.location.href='checkout.php';
    </script>";
    exit();
}

if (empty($_SESSION["cart"])) {
    echo "<script>
        alert('Your cart is empty.');
        window.location.href='mycart.php';
    </script>";
    exit();
}

if (empty($_POST["name"])) {
    echo "<script>alert('Name is required'); window.location.href='checkout.php';</script>";
    exit();
}

if (!preg_match('/^[0-9]{10}$/', $_POST["phone"] ?? "")) {
    echo "<script>alert('Phone number is invalid'); window.location.href='checkout.php';</script>";
    exit();
}

if (!filter_var($_POST["email"] ?? "", FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Valid email is required'); window.location.href='checkout.php';</script>";
    exit();
}

if (empty($_POST["address"])) {
    echo "<script>alert('Address is required'); window.location.href='checkout.php';</script>";
    exit();
}

$sessionEmail = $_SESSION["email"];
$userStmt = $conn->prepare(
    "SELECT id, name, phone, email FROM users WHERE email = ? LIMIT 1",
);

if (!$userStmt) {
    echo "<script>
        alert('Unable to verify your account.');
        window.location.href='checkout.php';
    </script>";
    exit();
}

$userStmt->bind_param("s", $sessionEmail);
$userStmt->execute();
$userResult = $userStmt->get_result();

if (!$userResult || $userResult->num_rows !== 1) {
    echo "<script>
        alert('Logged-in user could not be found.');
        window.location.href='login.html';
    </script>";
    exit();
}

$user = $userResult->fetch_assoc();

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$email = trim($_POST["email"]);
$address = trim($_POST["address"]);
$order_price = isset($_SESSION["gTotal"]) ? (int) $_SESSION["gTotal"] : 0;
$order_status = "pending";
$user_id = (int) $user["id"];
$order_date = date("Y-m-d H:i:s");

if (strcasecmp($email, $sessionEmail) !== 0) {
    echo "<script>
        alert('Checkout email must match your logged-in account.');
        window.location.href='checkout.php';
    </script>";
    exit();
}

if ($order_price <= 0) {
    foreach ($_SESSION["cart"] as $cartItem) {
        $order_price +=
            ((int) $cartItem["Price"]) * ((int) $cartItem["Quantity"]);
    }
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare(
        "INSERT INTO orders (name, order_price, order_status, uid, u_phone, user_address, order_date) VALUES (?,?,?,?,?,?,?)",
    );

    if (!$stmt) {
        throw new Exception("Could not prepare order statement.");
    }

    $stmt->bind_param(
        "sisiiss",
        $name,
        $order_price,
        $order_status,
        $user_id,
        $phone,
        $address,
        $order_date,
    );
    $stmt->execute();

    $order_id = $stmt->insert_id;

    $stmt1 = $conn->prepare(
        "INSERT INTO order_items (order_id, product_name, product_image, price, quantity, uid, order_date) VALUES (?,?,?,?,?,?,?)",
    );

    if (!$stmt1) {
        throw new Exception("Could not prepare order items statement.");
    }

    foreach ($_SESSION["cart"] as $product) {
        $product_name = $product["item_name"];
        $product_price = (int) $product["Price"];
        $product_image = $product["item_image"];
        $quantity = (int) $product["Quantity"];

        $stmt1->bind_param(
            "issiiis",
            $order_id,
            $product_name,
            $product_image,
            $product_price,
            $quantity,
            $user_id,
            $order_date,
        );
        $stmt1->execute();
    }

    $conn->commit();

    $_SESSION["order_id"] = $order_id;
    $_SESSION["gTotal"] = $order_price;

    header(
        "Location: payment.php?order_status=" .
            urlencode("Your item has been successfully ordered"),
    );
    exit();
} catch (Throwable $e) {
    $conn->rollback();

    echo "<script>
        alert('Unable to place order right now. Please try again.');
        window.location.href='checkout.php';
    </script>";
    exit();
}
?>
