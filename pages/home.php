<?php
require "connect.php";
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>Home</title>

        <link rel="stylesheet" href="styleee.css">
    </head>

<body>

    <header id="header">
        <a href="home.php" class="nav-logo">
            <img src="/PROJECT/images/l3.png" alt="Royal Butterfly">
        </a>
        <ul id="navbar">
                <li><a class="active" href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION["email"])) { ?>
                <li><a href="customer_order.php">My Orders</a></li>
                <?php } ?>
                <li>
                    <?php
                    $count = 0;
                    if (isset($_SESSION["cart"])) {
                        $count = count($_SESSION["cart"]);
                    }
                    ?>
                    <a href="mycart.php" class="cart-link">
                        <i class="bi bi-cart3"></i>
                        <?php if (
                            $count > 0
                        ): ?><span class="cart-count"><?php echo $count; ?></span><?php endif; ?>
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

    <section id="hero">
        <h4>Escape The Ordinary</h4>
        <h2>Comfy Dresses To Try</h2>
        <h1>This Season.</h1>
        <p>Get up to 30% OFF on New Arrivals</p>
        <button><a href="shop.php">SHOP NOW</a></button>
    </section>

    <!-- <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p style="font-size: 18px;">Spring Collection</p>
        <div class="pro-container">

            <div class="pro">
                <form action="manage_cart.php" method="POST">
                    <img src="/PROJECT/images/fr.png" style="width: 65%;">
                    <div class="des">
                        <h5>Sleeveless Gown</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 3000</h4>
                    </div>
                        <button type="submit" name="Add_to_Cart">
                            <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                        </button>
                    <input type="hidden" name="item_name" value="Sleeveless Gown" />
                    <input type="hidden" name="Price" value="3000" />
                    <input type="hidden" name="item_image" value="/project/images/fr.png" />
                </form>
            </div>


            <div class="pro">
                <form action="manage_cart.php" method="POST">
                <img src="/PROJECT/images/f2.jpg" style="width: 92%;">
                <div class="des">
                    <h5>Party Wear Frock</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs 4000</h4>
                </div>
                <button type="submit" name="Add_to_Cart">
                    <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                </button>
                <input type="hidden" name="item_name" value="Party Wear Frock" />
                <input type="hidden" name="Price" value="4000" />
                <input type="hidden" name="item_image" value="/project/images/f2.jpg" />
            </form>
            </div>

            <div class="pro">
                <form action="manage_cart.php" method="POST">
                <img src="/PROJECT/images/a8.jpg" style="width: 63%;">
                <div class="des">
                    <h5>Skirt Sets</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs 1500</h4>
                </div>
                <button type="submit" name="Add_to_Cart">
                    <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                </button>
                <input type="hidden" name="item_name" value="Skirt Sets" />
                <input type="hidden" name="Price" value="1500" />
                <input type="hidden" name="item_image" value="/project/images/a8.jpg" />
            </form>
            </div>

            <div class="pro">
                <form action="manage_cart.php" method="POST">
                    <img src="/PROJECT/images/gown.jpg" style="width: 92%;">
                    <div class="des">
                        <h5>Beads Prom Dress</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 2500</h4>
                    </div>
                    <button type="submit" name="Add_to_Cart">
                        <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                    </button>
                    <input type="hidden" name="item_name" value="Beads Prom Dress" />
                    <input type="hidden" name="Price" value="2500" />
                    <input type="hidden" name="item_image" value="/project/images/gown.jpg" />
            </form>
            </div>

        </div>
    </section> -->

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p style="font-size: 18px;">Spring Collection</p>
        <div class="pro-container">

        <?php include "featured.php"; ?>

        <?php while ($row = $featured_products->fetch_assoc()) { ?>
            <div class="pro">
            <form action="manage_cart.php" method="POST">
            <a href="product_view.php?product_id=<?php echo $row["pid"]; ?>">
                <img src="../images/<?php echo $row[
                    "product_image"
                ]; ?>" style="width: 65%;">
            </a>
                <div class="des">
                    <h5><?php echo $row["product_name"]; ?></h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs <?php echo $row["price"]; ?> </h4>
                </div>
                <button type="submit" name="Add_to_Cart">
                <i class="bi bi-cart2 cart" onclick="addToCart()"></i>
                </button>
                <input type="hidden" name="item_name" value="<?php echo $row[
                    "product_name"
                ]; ?>" />
                <input type="hidden" name="Price" value="<?php echo $row[
                    "price"
                ]; ?>" />
                <input type="hidden" name="item_image" value="../images/<?php echo $row[
                    "product_image"
                ]; ?>" />
            </form>
            </div>

            <?php } ?>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrivals</h2>
        <p style="font-size: 18px;">New Modern Collection</p>
        <div class="pro-container">

        <?php include "new_arrival.php"; ?>

        <?php while ($row = $featured_products->fetch_assoc()) { ?>
            <div class="pro">
            <form action="manage_cart.php" method="POST">
            <a href="product_view.php?product_id=<?php echo $row["pid"]; ?>">
                <img src="../images/<?php echo $row[
                    "product_image"
                ]; ?>" style="width: 80%;">
            </a>
                <div class="des">
                    <h5><?php echo $row["product_name"]; ?></h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs <?php echo $row["price"]; ?> </h4>
                </div>
                <button type="submit" name="Add_to_Cart">
                <i class="bi bi-cart2 cart" onclick="addToCart()"></i>
                </button>
                <input type="hidden" name="item_name" value="<?php echo $row[
                    "product_name"
                ]; ?>" />
                <input type="hidden" name="Price" value="<?php echo $row[
                    "price"
                ]; ?>" />
                <input type="hidden" name="item_image" value="../images/<?php echo $row[
                    "product_image"
                ]; ?>" />
            </form>
            </div>

            <?php } ?>
        </div>
    </section>

    <section id="holder">
        <div class="box">
            <h2>Party Wear</h2>
            <h3>Limited Products</h3>
        </div>

        <div class="box box1">
            <h2>Trendy Dress</h2>
            <h3>Seasonal Collection</h3>
        </div>

    </section>


    <?php include "footer.html"; ?>

</body>

</html>
