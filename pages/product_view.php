<?php
include "connect.php";
session_start();

$product_id = isset($_GET["product_id"]) ? (int) $_GET["product_id"] : 0;
$product = [
    "product_name" => "",
    "product_image" => "",
    "description" => "",
    "price" => 0,
];
$page_error = null;

if ($product_id <= 0) {
    $page_error = "Invalid product ID.";
} elseif (!isset($conn) || !$conn) {
    $page_error =
        "Database connection is unavailable. Configure MySQL to view product details.";
} else {
    $stmt = $conn->prepare("SELECT * FROM all_products WHERE pid = ?");

    if ($stmt) {
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $product = $result->fetch_assoc();
            } else {
                $page_error = "Product not found.";
            }
        } else {
            $page_error = "Unable to load this product right now.";
        }

        $stmt->close();
    } else {
        $page_error = "Unable to prepare the product query.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Details</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <script src="js/jquery2.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="main.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="styleee.css">

        <style>
            .pr-img {
                width: 100%;
                max-width: 400px;
                margin-right: 150px;
                padding-left: 30px;
            }
            .product-title {
                color: black;
                margin-top: 28px;
                margin-left: 12px;
                font-size: 36px;
                font-weight: bold;
            }
            .product-description {
                font-size: 19px;
                line-height: 28px;
                margin-bottom: 5px;
                font-style: italic;
            }
            .product-price {
                font-size: 28px;
                font-weight: normal;
                color: black;
            }
            .btn {
                margin-left: 12px;
            }
        </style>
    </head>

<body>

    <section id="header">
        <img src="/PROJECT/images/l3.png" height="40" width="38"><a href="home.php"></a>
        <div>
            <ul id="navbar">
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li>
                    <?php
                    $count = 0;
                    if (isset($_SESSION["cart"])) {
                        $count = count($_SESSION["cart"]);
                    }
                    ?>
                    <a href="mycart.php"><i class="bi bi-cart-plus-fill" style="font-size: 22px;">(<?php echo $count; ?>)</i></a>
                </li>
                <?php if (isset($_SESSION["email"])) { ?>
                    <li><a href="customer_order.php">My Orders</a></li>
                    <li>
                        <a href="logout.php"><i class="bi bi-box-arrow-right" style="font-size: 22px;"></i> Logout</a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="login.html"><i class="bi bi-person-fill" style="font-size: 22px;"></i> Login</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </section>

    <div class="container my-5">
        <?php if ($page_error !== null): ?>
            <div class="alert alert-warning" role="alert">
                <?php echo htmlspecialchars(
                    $page_error,
                    ENT_QUOTES,
                    "UTF-8",
                ); ?>
            </div>
            <a href="shop.php" class="btn btn-primary">Back to Shop</a>
        <?php else: ?>
            <div class="row">
                <div class="pr-img col-lg-6">
                    <img
                        src="../images/<?php echo htmlspecialchars(
                            $product["product_image"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>"
                        alt="<?php echo htmlspecialchars(
                            $product["product_name"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>"
                        class="img-fluid"
                    >
                </div>
                <div class="col-lg-6">
                    <h3 class="product-title"><?php echo htmlspecialchars(
                        $product["product_name"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></h3>
                    <p class="product-description"><?php echo htmlspecialchars(
                        $product["description"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <p class="product-price">Rs <?php echo htmlspecialchars(
                        (string) $product["price"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?></p>
                    <form action="manage_cart.php" method="POST">
                        <button type="submit" name="Add_to_Cart" class="btn btn-primary">Add to Cart</button>
                        <input type="hidden" name="item_name" value="<?php echo htmlspecialchars(
                            $product["product_name"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>" />
                        <input type="hidden" name="Price" value="<?php echo htmlspecialchars(
                            (string) $product["price"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>" />
                        <input type="hidden" name="item_image" value="../images/<?php echo htmlspecialchars(
                            $product["product_image"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>" />
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
