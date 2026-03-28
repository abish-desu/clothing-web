<?php
include "connect.php";
session_start();

$product_id = isset($_GET["product_id"]) ? (int) $_GET["product_id"] : 0;
$product = null;
$page_error = null;

if ($product_id <= 0) {
    $page_error = "Invalid product ID.";
} elseif (!isset($conn) || !$conn) {
    $page_error = "Database connection is unavailable.";
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

$count = 0;
if (isset($_SESSION["cart"])) {
    $count = count($_SESSION["cart"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product
        ? htmlspecialchars($product["product_name"], ENT_QUOTES, "UTF-8") .
            " — "
        : ""; ?>Product Details</title>
    <link rel="stylesheet" href="styleee.css">
    <style>
        /* ── product page layout ─────────────────────── */
        .product-page {
            max-width: 1100px;
            margin: 48px auto;
            padding: 0 32px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #b67352;
            text-decoration: none;
            margin-bottom: 28px;
            transition: color 0.2s;
        }
        .back-btn:hover { color: #8c4520; }

        /* two-column layout */
        .product-layout {
            display: flex;
            gap: 56px;
            align-items: flex-start;
        }

        /* left — image */
        .product-image-col {
            flex: 0 0 420px;
        }

        .product-image-col img {
            width: 100%;
            max-width: 420px;
            height: 480px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.10);
            display: block;
        }

        /* right — details */
        .product-details-col {
            flex: 1;
            min-width: 0;
            padding-top: 8px;
        }

        .product-category {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #b67352;
            margin-bottom: 10px;
        }

        .product-name {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .product-price {
            font-size: 26px;
            font-weight: 700;
            color: #b67352;
            margin-bottom: 20px;
        }

        .product-divider {
            border: none;
            border-top: 1px solid #f0ebe6;
            margin: 20px 0;
        }

        .product-description {
            font-size: 15px;
            color: #555;
            line-height: 1.75;
            margin-bottom: 32px;
            padding: 0;
        }

        .add-cart-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: #b67352;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
            font-family: inherit;
            text-decoration: none;
        }
        .add-cart-btn:hover {
            background: #9e5f3e;
            transform: translateY(-1px);
        }

        /* error / not found state */
        .product-error {
            text-align: center;
            padding: 80px 20px;
        }
        .product-error i {
            font-size: 52px;
            color: #ddd;
            display: block;
            margin-bottom: 16px;
        }
        .product-error h3 {
            font-size: 22px;
            color: #444;
            margin-bottom: 8px;
        }
        .product-error p {
            font-size: 14px;
            color: #888;
            padding: 0;
            margin-bottom: 24px;
        }

        /* responsive */
        @media (max-width: 768px) {
            .product-layout {
                flex-direction: column;
                gap: 28px;
            }
            .product-image-col {
                flex: none;
                width: 100%;
            }
            .product-image-col img {
                max-width: 100%;
                height: 320px;
            }
            .product-name  { font-size: 24px; }
        }
    </style>
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
        <?php if (isset($_SESSION["email"])): ?>
            <li><a href="customer_order.php">My Orders</a></li>
        <?php endif; ?>
        <li>
            <a href="mycart.php" class="cart-link">
                <i class="bi bi-cart3"></i>
                <?php if ($count > 0): ?>
                    <span class="cart-count"><?php echo $count; ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li>
            <?php if (isset($_SESSION["email"])): ?>
                <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
            <?php else: ?>
                <a href="login.html"><i class="bi bi-person-fill"></i> Login</a>
            <?php endif; ?>
        </li>
    </ul>
</header>

<div class="product-page">

    <a href="shop.php" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back to Shop
    </a>

    <?php if ($page_error !== null): ?>

        <div class="product-error">
            <i class="bi bi-exclamation-circle"></i>
            <h3>Oops!</h3>
            <p><?php echo htmlspecialchars(
                $page_error,
                ENT_QUOTES,
                "UTF-8",
            ); ?></p>
            <a href="shop.php" class="add-cart-btn">Browse Shop</a>
        </div>

    <?php else: ?>

        <div class="product-layout">

            <!-- Image -->
            <div class="product-image-col">
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
                >
            </div>

            <!-- Details -->
            <div class="product-details-col">

                <?php if (!empty($product["product_cat"])): ?>
                    <div class="product-category">
                        <?php echo htmlspecialchars(
                            $product["product_cat"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>
                    </div>
                <?php endif; ?>

                <h1 class="product-name">
                    <?php echo htmlspecialchars(
                        $product["product_name"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?>
                </h1>

                <div class="product-price">
                    Rs <?php echo htmlspecialchars(
                        (string) $product["price"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?>
                </div>

                <hr class="product-divider">

                <?php if (!empty($product["description"])): ?>
                    <p class="product-description">
                        <?php echo htmlspecialchars(
                            $product["description"],
                            ENT_QUOTES,
                            "UTF-8",
                        ); ?>
                    </p>
                <?php endif; ?>

                <form action="manage_cart.php" method="POST">
                    <input type="hidden" name="item_name"  value="<?php echo htmlspecialchars(
                        $product["product_name"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?>">
                    <input type="hidden" name="Price"      value="<?php echo htmlspecialchars(
                        (string) $product["price"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?>">
                    <input type="hidden" name="item_image" value="../images/<?php echo htmlspecialchars(
                        $product["product_image"],
                        ENT_QUOTES,
                        "UTF-8",
                    ); ?>">
                    <button type="submit" name="Add_to_Cart" class="add-cart-btn">
                        <i class="bi bi-cart-plus"></i> Add to Cart
                    </button>
                </form>

            </div>
        </div>

    <?php endif; ?>

</div>

<footer class="footer">
    <p>Copyright &copy; 2024. All Rights Reserved.</p>
</footer>

</body>
</html>
