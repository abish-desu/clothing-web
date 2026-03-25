<?php
session_start();

$cartItems = $_SESSION["cart"] ?? [];
$grandTotal = 0;

foreach ($cartItems as $item) {
    $price = isset($item["Price"]) ? (int) $item["Price"] : 0;
    $quantity = isset($item["Quantity"]) ? (int) $item["Quantity"] : 0;
    $grandTotal += $price * $quantity;
}

$_SESSION["gTotal"] = $grandTotal;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Cart</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="styleee.css">
        <style>
            .cart-table {
                width: 100%;
            }
            .cart-table th {
                height: 50px;
                background-color: lightblue;
                color: black;
            }
            .cart-table td {
                padding: 10px;
                vertical-align: middle;
            }
            .cart-table td img {
                width: 100px;
                height: 130px;
                object-fit: cover;
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
                    <?php if (isset($_SESSION["email"])) { ?>
                        <li><a href="customer_order.php">My Orders</a></li>
                    <?php } ?>
                    <li><a class="active" href="mycart.php"><i class="bi bi-cart-plus-fill" style="font-size: 22px;"></i></a></li>
                    <li>
                        <?php if (isset($_SESSION["email"])) { ?>
                            <a href="logout.php"><i class="bi bi-box-arrow-right" style="font-size: 22px;"></i> Logout</a>
                        <?php } else { ?>
                            <a href="login.html"><i class="bi bi-person-fill" style="font-size: 22px;"></i> Login</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </section>

        <div class="container my-5">
            <div class="row">
                <div class="col-lg-12 text-center border rounded bg-light mb-4">
                    <h2 class="py-3 mb-0">My Cart</h2>
                </div>

                <div class="col-lg-9">
                    <?php if (empty($cartItems)) { ?>
                        <div class="alert alert-info text-center">
                            Your cart is empty. <a href="shop.php">Continue shopping</a>.
                        </div>
                    <?php } else { ?>
                        <table class="table cart-table text-center align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">SN</th>
                                    <th scope="col">Product Image</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $key => $value) {

                                    $sr = $key + 1;
                                    $itemName = $value["item_name"] ?? "";
                                    $itemImage = $value["item_image"] ?? "";
                                    $price = isset($value["Price"])
                                        ? (int) $value["Price"]
                                        : 0;
                                    $quantity = isset($value["Quantity"])
                                        ? (int) $value["Quantity"]
                                        : 1;
                                    $total = $price * $quantity;
                                    ?>
                                    <tr>
                                        <td><?php echo $sr; ?></td>
                                        <td><img src="<?php echo htmlspecialchars(
                                            $itemImage,
                                        ); ?>" alt="<?php echo htmlspecialchars(
    $itemName,
); ?>"></td>
                                        <td><?php echo htmlspecialchars(
                                            $itemName,
                                        ); ?></td>
                                        <td>Rs <?php echo $price; ?></td>
                                        <td>
                                            <form action="manage_cart.php" method="POST" class="d-inline">
                                                <input
                                                    type="number"
                                                    class="text-center"
                                                    name="Mod_Quantity"
                                                    onchange="this.form.submit();"
                                                    value="<?php echo $quantity; ?>"
                                                    min="1"
                                                    max="10"
                                                >
                                                <input type="hidden" name="item_name" value="<?php echo htmlspecialchars(
                                                    $itemName,
                                                ); ?>">
                                            </form>
                                        </td>
                                        <td>Rs <?php echo $total; ?></td>
                                        <td>
                                            <form action="manage_cart.php" method="POST" class="d-inline">
                                                <button name="Remove_item" class="btn btn-sm btn-outline-danger">Remove</button>
                                                <input type="hidden" name="item_name" value="<?php echo htmlspecialchars(
                                                    $itemName,
                                                ); ?>">
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>

                <div class="col-lg-3">
                    <div class="border bg-light rounded p-4">
                        <h4>Grand Total: Rs <?php echo $grandTotal; ?></h4>
                        <br>

                        <?php if (!empty($cartItems)) { ?>
                            <?php if (isset($_SESSION["email"])) { ?>
                                <form action="checkout.php" method="POST">
                                    <button type="submit" name="checkout" class="btn btn-primary w-100">Checkout</button>
                                </form>
                            <?php } else { ?>
                                <a href="login.html" class="btn btn-primary w-100">Login to Checkout</a>
                            <?php } ?>
                        <?php } else { ?>
                            <a href="shop.php" class="btn btn-primary w-100">Go to Shop</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
