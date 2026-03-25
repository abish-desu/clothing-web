<?php

require "connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit();
}

if (!$conn) {
    echo "<script>
        alert('Database connection is unavailable. Please try again later.');
        window.location.href = 'login.html';
    </script>";
    exit();
}

$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

if ($email === "" || $password === "") {
    echo "<script>
        alert('Email and password are required');
        window.location.href = 'login.html';
    </script>";
    exit();
}

$stmt = $conn->prepare(
    "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1",
);

if (!$stmt) {
    echo "<script>
        alert('Unable to process login right now');
        window.location.href = 'login.html';
    </script>";
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row["password"])) {
        $userId = (int) $row["id"];

        if (
            !isset($_SESSION["user_carts"]) ||
            !is_array($_SESSION["user_carts"])
        ) {
            $_SESSION["user_carts"] = [];
        }

        if (
            isset($_SESSION["cart"]) &&
            is_array($_SESSION["cart"]) &&
            isset($_SESSION["user_id"])
        ) {
            $_SESSION["user_carts"][$_SESSION["user_id"]] = $_SESSION["cart"];
        }

        $_SESSION["user_id"] = $userId;
        $_SESSION["name"] = $row["name"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["cart"] = $_SESSION["user_carts"][$userId] ?? [];

        header("Location: home.php");
        exit();
    }

    echo "<script>
        alert('Incorrect password');
        window.location.href = 'login.html';
    </script>";
    exit();
}

echo "<script>
    alert('Email does not exist');
    window.location.href = 'login.html';
</script>";
exit();
?>
