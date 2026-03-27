<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.html");
    exit();
}

$totalAmount = isset($_SESSION["gTotal"]) ? (int) $_SESSION["gTotal"] : 0;

if (isset($_SESSION["cart"])) {
    unset($_SESSION["cart"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="styleee.css">
</head>
<body>

    <header id="header">
        <a href="home.php" class="nav-logo">
            <img src="/PROJECT/images/l3.png" alt="Royal Butterfly">
        </a>
        <ul id="navbar">
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION["email"])) { ?>
                    <li><a href="customer_order.php">My Orders</a></li>
                <?php } ?>
                <li>
                    <a href="mycart.php" class="cart-link">
                        <i class="bi bi-cart3"></i>
                    </a>
                </li>
                <li>
                    <?php if (isset($_SESSION["email"])) { ?>
                        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    <?php } else { ?>
                        <a href="login.html"><i class="bi bi-person-fill"></i> Login</a>
                    <?php } ?>
                </li>
            </ul>
    </header>

    <section class="my-3 py-3">
        <div class="container text-center mt-2 pt-3">
            <h2 style="color: antiquewhite; background-color: black;" class="form-weight-bold">Order Details</h2>
            <br><br>
            <h3>Thank You!</h3>
            <br>
        </div>

        <div class="mx-auto container text-center">
            <p style="font-size:20px;">
                Your order has been placed successfully.
                <a href="shop.php">Click here</a> to purchase any other item.
            </p>

            <h5>Total amount to be paid:</h5>
            <h3>RS <?php echo $totalAmount; ?></h3>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <form name="verified" action="home.php" method="get">
                    <input type="submit" class="btn btn-primary" name="payment" value="Go Back">
                </form>
                <form action="customer_order.php" method="get">
                    <input type="submit" class="btn btn-outline-primary" value="My Orders">
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>Copyright &copy; 2024. All Rights Reserved.</p>
        </div>
    </footer>


</body>
</html>
