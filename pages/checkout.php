<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.html");
    exit();
}

if (empty($_SESSION["cart"])) {
    header("Location: mycart.php");
    exit();
}

$grandTotal = 0;
foreach ($_SESSION["cart"] as $item) {
    $price = isset($item["Price"]) ? (int) $item["Price"] : 0;
    $quantity = isset($item["Quantity"]) ? (int) $item["Quantity"] : 0;
    $grandTotal += $price * $quantity;
}

$_SESSION["gTotal"] = $grandTotal;

$name = isset($_SESSION["name"]) ? $_SESSION["name"] : "";
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="styleee.css">
        <style>
            h2 {
                text-align: center;
                margin-top: 20px;
            }
            .wrapper {
                width: 100%;
                border: 1px solid black;
                border-radius: 10px;
            }
            .container {
                width: 40%;
                margin: 0 auto;
                padding: 20px;
            }
            #form .form-group {
                display: inline-block;
                width: 100%;
                margin: 10px auto;
            }
            #form .form-group label {
                padding-left: 12px;
            }
            .form-group input {
                width: 100%;
                background: transparent;
                outline: none;
                margin: 5px;
                border: 1px solid gray;
                border-radius: 12px;
                font-size: 15px;
                padding: 20px 45px 20px 20px;
            }
            .btn-container {
                margin: 10px;
                text-align: right;
            }
            .footer {
                margin-top: 60px;
            }
        </style>
    </head>
    <body>

        <section id="header">
            <img src="/PROJECT/images/l3.png" height="40" width="38"><a></a>
            <div>
                <ul id="navbar">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="mycart.php"><i class="bi bi-cart-plus" style="font-size: 23px;"></i></a></li>
                    <?php if (isset($_SESSION["email"])) { ?>
                        <li><a href="customer_order.php">My Orders</a></li>
                        <li>
                            <a href="logout.php"><i class="bi bi-box-arrow-right" style="font-size: 21px;"></i> Logout</a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="login.html"><i class="bi bi-person-fill" style="font-size: 21px;"></i> Login</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </section>

        <section class="wrapper">
            <div class="heading">
                <h2>Checkout</h2>
            </div>

            <div class="container">
                <form id="form" name="formlogin" method="post" action="place_order.php" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars(
                            $name,
                        ); ?>">
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" class="form-control" name="phone" placeholder="98xxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo htmlspecialchars(
                            $email,
                        ); ?>">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Address">
                    </div>

                    <label>Payment Method</label><br>
                    <input type="radio" name="payment" id="cash">
                    <label for="cash"><span style="font-size:18px;">Cash on Delivery</span></label>

                    <div class="btn-container">
                        <h4>Grand Total: Rs <?php echo $grandTotal; ?></h4>
                        <button type="submit" name="order-btn" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </section>

        <script>
            function validateForm() {
                var form = document.forms["formlogin"];
                var fullName = form["name"].value.trim();
                var phoneNumber = form["phone"].value.trim();
                var email = form["email"].value.trim();
                var address = form["address"].value.trim();
                var cashRadioButton = document.getElementById("cash");

                if (fullName === "" || phoneNumber === "" || email === "" || address === "") {
                    alert("Please fill out all fields.");
                    return false;
                }

                if (phoneNumber.length !== 10 || isNaN(phoneNumber)) {
                    alert("Phone number should be exactly 10 digits.");
                    return false;
                }

                if (!cashRadioButton.checked) {
                    alert("Please select payment method.");
                    return false;
                }

                return true;
            }
        </script>

        <footer class="footer">
            <div class="container">
                <p>Copyright &copy; 2024. All Rights Reserved.</p>
            </div>
        </footer>
    </body>
</html>
