<?php
session_start();

$adminEmail = "admin@gmail.com";
$adminPassword = "admin@12";

if (
    isset($_SESSION["admin_logged_in"]) &&
    $_SESSION["admin_logged_in"] === true
) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if ($email !== $adminEmail) {
        echo "<script>
            alert('Invalid email');
            window.location.href='login.php';
        </script>";
        exit();
    }

    if ($password !== $adminPassword) {
        echo "<script>
            alert('Invalid password');
            window.location.href='login.php';
        </script>";
        exit();
    }

    $_SESSION["admin_logged_in"] = true;
    $_SESSION["admin_email"] = $email;
    $_SESSION["admin_name"] = "Admin";

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.12);
            width: 320px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 12px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Panel Login</h2>
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <a class="back-link" href="../pages/home.php">Back to Site</a>
    </div>
</body>
</html>
