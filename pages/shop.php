<?php
session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shop</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="shop_style.css">
    </head>
<body>
    <section id="header">
        <img src="/PROJECT/images/l3.png" height="40" width="38"><a>
            <div>
            <ul id="navbar">
                <li><a href="home.php">Home</a></li>
                <li><a class="active" href="shop.php">Shop</a></li>
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

                <li>
                    <?php if (isset($_SESSION["email"])) { ?>
                            <a href="customer_order.php">My Orders</a>
                            <?php } ?>
                </li>

                <li>
                    <?php if (isset($_SESSION["email"])) { ?>
                            <a href="logout.php"><i class="bi bi-box-arrow-right"  style="font-size: 22px;"></i> Logout</a>
                            <?php } else { ?>
                            <a href="login.html"><i class="bi bi-person-fill" style="font-size: 22px;"></i> Login</a>
                            <?php } ?>
                </li>
            </ul>
        </div>
    </section>

    <section id="hero">
        <h1>Our Shop</h1>
        <p class="content">Explore your fashion</p>
    </section>

    <!-- <section id="product1" class="section-p1">
        <h2>Summer Wear</h2>
        <p style="font-size: 18px;">Seasonal Collection</p>
        <div class="pro-container">

            <div class="pro">
                <form action="manage_cart.php" method="POST">
                    <img src="/PROJECT/images/a6.jpg" style="width: 70%;">
                    <div class="des">
                        <h5>One-piece with strap</h5>
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
                    <input type="hidden" name="item_name" value="One-piece with strap" />
                    <input type="hidden" name="Price" value="1500" />
                    <input type="hidden" name="item_image" value="/project/images/a6.jpg" />
                </form>
            </div>

            <div class="pro">
                <form action="manage_cart.php" method="POST">
                <img src="/PROJECT/images/a7.jpg" style="width: 70%;">
                <div class="des">
                    <h5>Frock</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs 1400</h4>
                </div>
                <button type="submit" name="Add_to_Cart">
                    <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                </button>
                <input type="hidden" name="item_name" value="Frock" />
                <input type="hidden" name="Price" value="1400" />
                <input type="hidden" name="item_image" value="/project/images/a7.jpg" />
            </form>
            </div>

            <div class="pro">
                <form action="manage_cart.php" method="POST">
                <img src="/PROJECT/images/a9.jpg" style="width: 70%;">
                <div class="des">
                    <h5>Skater Pink Dress</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs 2000</h4>
                </div>
                <button type="submit" name="Add_to_Cart">
                    <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                </button>
                <input type="hidden" name="item_name" value="Skater Pink Dress" />
                <input type="hidden" name="Price" value="2000" />
                <input type="hidden" name="item_image" value="/project/images/a9.jpg" />
            </form>
            </div>

            <div class="pro">
                <form action="manage_cart.php" method="POST">
                    <img src="/PROJECT/images/a10.jpg" style="width: 74%;">
                    <div class="des">
                        <h5>Blue Flare Dress</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 1200</h4>
                    </div>
                    <button type="submit" name="Add_to_Cart">
                        <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                    </button>
                    <input type="hidden" name="item_name" value="Blue Flare Dress" />
                    <input type="hidden" name="Price" value="1200" />
                    <input type="hidden" name="item_image" value="/project/images/a10.jpg" />
            </form>
            </div>

        </div>
    </section> -->

    <section id="product1" class="section-p1">
        <h2>Summer Wear</h2>
        <p style="font-size: 18px;">Seasonal Collection</p>
        <div class="pro-container">

        <?php include "summer_wear.php"; ?>

        <?php while ($row = $featured_products->fetch_assoc()) { ?>
            <div class="pro">
            <form action="manage_cart.php" method="POST">
            <a href="product_view.php?product_id=<?php echo $row["pid"]; ?>">
                <img src="../images/<?php echo $row[
                    "product_image"
                ]; ?>" style="width: 70%;">
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
        <h2>Trendy Dress</h2>
        <p style="font-size: 18px;">Seasonal Collection</p>
        <div class="pro-container">

            <div class="pro">
                <a href="product_view.php?product_id=13">
                <!-- <form action="manage_cart.php" method="POST"> -->
                    <img src="../images/d8.jpg" style="width: 70%;">
                    </a>
                    <div class="des">
                        <h5>Crop Laces Top</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 1000</h4>
                    </div>

                <form action="manage_cart.php" method="POST">
                        <button type="submit" name="Add_to_Cart">
                            <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                        </button>
                    <input type="hidden" name="item_name" value="Crop Laces Top" />
                    <input type="hidden" name="Price" value="1000" />
                    <input type="hidden" name="item_image" value="../images/d8.jpg" />
                </form>
            </div>

            <div class="pro">
                <a href="product_view.php?product_id=14">
                    <img src="../images/hoodie.jpg" style="width: 92%;">
                </a>
                <div class="des">
                    <h5>Hoodie</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs 2500</h4>
                </div>
                <form action="manage_cart.php" method="POST">
                    <button type="submit" name="Add_to_Cart">
                        <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                    </button>
                    <input type="hidden" name="item_name" value="Hoodie" />
                    <input type="hidden" name="Price" value="2500" />
                    <input type="hidden" name="item_image" value="../images/hoodie.jpg" />
                </form>
            </div>

            <div class="pro">
                <a href="product_view.php?product_id=15">
                    <img src="../images/a2.jpg" style="width: 70%;">
                </a>
                <div class="des">
                    <h5>Suspender Skirt</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs 1500</h4>
                </div>
                <form action="manage_cart.php" method="POST">
                    <button type="submit" name="Add_to_Cart">
                        <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                    </button>
                    <input type="hidden" name="item_name" value="Suspender Skirt" />
                    <input type="hidden" name="Price" value="1500" />
                    <input type="hidden" name="item_image" value="../images/a2.jpg" />
                </form>
            </div>

            <div class="pro">
                <a href="product_view.php?product_id=16">
                    <img src="../images/a3.jpg" style="width: 73%;">
                </a>
                    <div class="des">
                        <h5>Crop Jacket</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 2500</h4>
                    </div>
                    <form action="manage_cart.php" method="POST">
                        <button type="submit" name="Add_to_Cart">
                            <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                        </button>
                        <input type="hidden" name="item_name" value="Crop Jacket" />
                        <input type="hidden" name="Price" value="2500" />
                        <input type="hidden" name="item_image" value="../images/a3.jpg" />
                    </form>
            </div>

            <div class="pro">
                <a href="product_view.php?product_id=17">
                    <img src="../images/a4.jpg" style="width: 88%;">
                </a>
                    <div class="des">
                        <h5>T-shirt</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 1500</h4>
                    </div>
                    <form action="manage_cart.php" method="POST">
                        <button type="submit" name="Add_to_Cart">
                            <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                        </button>
                        <input type="hidden" name="item_name" value="T-shirt" />
                        <input type="hidden" name="Price" value="1500" />
                        <input type="hidden" name="item_image" value="../images/a4.jpg" />
                    </form>
            </div>

            <div class="pro">
                <a href="product_view.php?product_id=18">
                <!-- <form action="manage_cart.php" method="POST"> -->
                    <img src="../images/e2.jpg" style="width: 85%;">
                </a>
                    <div class="des">
                        <h5>Cardigan</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 1500</h4>
                    </div>
                    <form action="manage_cart.php" method="POST">
                        <button type="submit" name="Add_to_Cart">
                            <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                        </button>
                        <input type="hidden" name="item_name" value="Cardigan" />
                        <input type="hidden" name="Price" value="1500" />
                        <input type="hidden" name="item_image" value="../images/e2.jpg" />
                    </form>
            </div>

            <div class="pro">
                <a href="product_view.php?product_id=19">
                <!-- <form action="manage_cart.php" method="POST"> -->
                    <img src="../images/d9.jpg" style="width: 69%;">
                </a>
                    <div class="des">
                        <h5>Risoul Sweater</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 2000</h4>
                    </div>
                    <form action="manage_cart.php" method="POST">
                        <button type="submit" name="Add_to_Cart">
                            <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                        </button>
                        <input type="hidden" name="item_name" value="Risoul Sweater" />
                        <input type="hidden" name="Price" value="2000" />
                        <input type="hidden" name="item_image" value="../images/d9.jpg" />
                    </form>
            </div>

            <div class="pro">
                <a href="product_view.php?product_id=20">
                <!-- <form action="manage_cart.php" method="POST"> -->
                    <img src="../images/blazer.jpg" style="width: 60%;">
                </a>
                    <div class="des">
                        <h5>Blazer</h5>
                        <div class="star">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Rs 3500</h4>
                    </div>
                    <form action="manage_cart.php" method="POST">
                        <button type="submit" name="Add_to_Cart">
                            <i class="bi bi-cart2 cart" style="font-size:20px;"></i>
                        </button>
                        <input type="hidden" name="item_name" value="Blazer" />
                        <input type="hidden" name="Price" value="3500" />
                        <input type="hidden" name="item_image" value="../images/blazer.jpg" />
                    </form>
            </div>

        </div>
    </section>

    <!-- <section id="product1" class="section-p1">
        <h2>Trendy Dress</h2>
        <p style="font-size: 18px;">New Modern Collection</p>
        <div class="pro-container">

        <?php include "trendy_products.php"; ?>

        <?php while ($row = $featured_products->fetch_assoc()) { ?>
            <div class="pro">
            <form action="manage_cart.php" method="POST">
                <img src="../images/<?php echo $row[
                    "product_image"
                ]; ?>" style="width: 70%;">
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
                <input type="hidden" name="item_image" value="/project/images/<?php echo $row[
                    "product_image"
                ]; ?>" />
            </form>
            </div>

            <?php } ?>
        </div>
    </section> -->


    <footer class="footer">
        <div class="container">
            <p>Copyright &copy 2024. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
 </body>
 </html>
