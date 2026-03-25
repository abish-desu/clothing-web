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
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/jquery2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styleee.css">
</head>
<body>

    <section id="header">
        <img src="/PROJECT/images/l3.png" height="40" width="38" alt="Logo"><a></a>
        <div>
            <ul id="navbar">
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION["email"])) { ?>
                    <li><a href="customer_order.php">My Orders</a></li>
                <?php } ?>
                <li><a class="active" href="mycart.php"><i class="bi bi-cart-plus" style="font-size: 21px;"></i></a></li>
                <li>
                    <?php if (isset($_SESSION["email"])) { ?>
                        <a href="logout.php"><i class="bi bi-box-arrow-right" style="font-size: 21px;"></i> Logout</a>
                    <?php } else { ?>
                        <a href="login.html"><i class="bi bi-person-fill" style="font-size: 21px;"></i> Login</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </section>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
