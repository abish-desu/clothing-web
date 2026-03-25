<?php
require "connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: signup.html");
    exit();
}

if (!$conn) {
    echo "<script>
        alert('Database connection is not available right now. Please try again later.');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

if (empty($_POST["name"])) {
    echo "<script>
        alert('Please enter your name');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

if (!preg_match("/^[0-9]{10}$/", $_POST["phone"] ?? "")) {
    echo "<script>
        alert('Enter the valid phone number');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

if (!filter_var($_POST["email"] ?? "", FILTER_VALIDATE_EMAIL)) {
    echo "<script>
        alert('Valid email is required');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

if (strlen($_POST["password"] ?? "") < 6) {
    echo "<script>
        alert('Password must be at least 6 characters');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    echo "<script>
        alert('Password must contain at least one letter');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    echo "<script>
        alert('Password must contain at least one number');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

if (($_POST["password"] ?? "") !== ($_POST["password_confirm"] ?? "")) {
    echo "<script>
        alert('Password does not match');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");

if (!$checkStmt) {
    echo "<script>
        alert('Unable to validate your account right now. Please try again.');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult && $checkResult->num_rows > 0) {
    $checkStmt->close();
    echo "<script>
        alert('Email already exists');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

$checkStmt->close();

$insertStmt = $conn->prepare(
    "INSERT INTO users(name, phone, email, password) VALUES(?, ?, ?, ?)",
);

if (!$insertStmt) {
    echo "<script>
        alert('Unable to create your account right now. Please try again.');
        window.location.href = 'signup.html';
    </script>";
    exit();
}

$insertStmt->bind_param("ssss", $name, $phone, $email, $hashedPassword);

if ($insertStmt->execute()) {
    $insertStmt->close();
    $conn->close();
    header("Location: signup-success.html");
    exit();
}

$errorMessage = $insertStmt->error;
$insertStmt->close();
$conn->close();

echo "<script>
    alert('Signup failed: " .
    addslashes($errorMessage) .
    "');
    window.location.href = 'signup.html';
</script>";
exit();
?>
