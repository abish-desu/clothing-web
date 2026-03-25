<?php
        require 'connect.php';
session_start();
    if (empty($_POST["name"])){
        echo "<script>alert('Name is required');</script>";
    }
    if(!(preg_match("/^[0-9]{10}$/", $_POST["phone"])))
    {
        echo "<script>alert('Phone number is invalid');</script>";
    }

    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Valid email is required');</script>";
    }

    if(empty($_POST["address"])){
        echo "<script>alert('Address is required');</script>";
    }

// Check if the cart is not empty and the checkout button is clicked
if (!empty($_SESSION['cart']) && isset($_POST['order-btn'])) {
    // Proceed with placing the order
    // For now, let's assume the order is successfully placed

    // Clear the cart after placing the order
    unset($_SESSION['cart']);

    // Get order details
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $grandTotal = $_SESSION['gTotal']; // Assuming you have stored the grand total in session


    // Display order confirmation message and details
    $orderMessage = "Thank you for your order, $name! Your order has been placed successfully.";
} else {
    // Redirect the user to the home page if the cart is empty or the checkout button is not clicked
    header('Location: home.php');
    exit(); // Ensure that the script stops executing after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Order Confirmation</h2>
        <p><?php echo $orderMessage; ?></p>

        <h3>Order Details:</h3>
        <ul>
            <li><strong>Name:</strong> <?php echo $name; ?></li>
            <li><strong>Phone:</strong> <?php echo $phone; ?></li>
            <li><strong>Email:</strong> <?php echo $email; ?></li>
            <li><strong>Address:</strong> <?php echo $address; ?></li>
            <li><strong>Grand Total:</strong> Rs <?php echo $grandTotal; ?></li>
        </ul>

    </div>
</body>
</html>
