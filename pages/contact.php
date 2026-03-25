<?php
session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8" >
        <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
        <title>Contact</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="shop_style.css">
        <style>

    #hero{
    background-image: url("/PROJECT/images/cont.jpg");
    height: 90vh;
    width: 100%;
    background-size: certain;
    background-position: top 10% right 0%;
    padding: 0 80px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    margin-bottom: 100px;
}
#hero h1{
    padding: 10px;
    font-size: 45px;
    font-weight: 200px;
    color:#ac5930;
}
#hero .content{
    padding: 10px;
    font-size: 18px;
    font-weight: bold;
    font-style: italic;
    text-align: center;
    font-family:Arial, Helvetica, sans-serif;
    color: rgb(66, 66, 66);
}
#contact-details{
    display: flex;
    align-items: center;
    justify-content: space-between;
}
#contact-details .details{
    width: 40%;
    padding: 30px;
    box-shadow: 0 0 10px rgba(0, 0,0, 0.2);
    border-radius: 10px;
    margin-left: 10px;
}
#contact-details .details span,
#contact-details .container{
    font-size: 16px;
}
#contact-details .details h2,
#contact-details .container h2{
    font-size: 28px;
    line-height: 34px;
    padding:20px 0;
}
div li{
    /* justify-content: center; */
    align-items: center;
}
#contact-details .details li{
    list-style: none;
    display: flex;
    padding: 10px 0;
}
#contact-details .details li i{
    font-size: 20px;
    padding-right: 22px;
}
#contact-details .details li p{
    margin: 0;
    font-size: 20px;
}

#contact-details .container {
        width: 40%;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
form label {
	display: block;
	margin-bottom: 5px;
}

input,
textarea {
	width: 100%;
	padding: 10px;
	margin-bottom: 20px;
	border: 1px solid #ccc;
	border-radius: 5px;
}
textarea {
	width: 100%;
    height: 50px;
	padding: 10px;
	margin-bottom: 20px;
	border: 1px solid #ccc;
	border-radius: 5px;
}
 input[type="submit"] {
	background-color: rgb(5, 101, 244);
    height: 25%;
	color: white;
	cursor: pointer;
}

form input[type="submit"]:hover {
	background-color: #0056b3;
}
    </style>
</head>

    <body>
        <section id="header">
        <img src="/PROJECT/images/l3.png" height="40" width="40"><a>
            <!-- <h>Royal Butterfly</h> -->
                <div>
                <ul id="navbar">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a class="active" href="contact.php">Contact</a></li>
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
                        <a href="mycart.php"><i class="bi bi-cart-plus-fill" style="font-size: 22px;">(<?php echo $count; ?>)</i></a>
                    </li>
                    <!-- <li><i class="bi bi-search-heart" style="font-size: 20px;"></i></a></li> -->
                    <!-- <li><a href="mycart.php"><i class="bi bi-cart-plus" style="font-size: 21px;"></i></a></li> -->
                    <!-- <li><a href="logout.php"><i class="bi bi-person-heart" style="font-size: 20px;"></i></a></li> -->
                    <li>
                        <?php if (isset($_SESSION["email"])) { ?>
                            <!-- <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li> -->
                            <!-- <li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li> -->
                            <a href="logout.php"><i class="bi bi-box-arrow-right"  style="font-size: 22px;"></i></span> Logout</a>
                            <?php } else { ?>
                                <!-- <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
                            <a href="login.html"><i class="bi bi-person-fill" style="font-size: 22px;"></i> Login</a>
                            <?php } ?>
                </li>
                </ul>
            </div>
        </section>

        <section id="hero">
            <h1>Contact Us</h1>
            <!-- <p class="content">Let's have a talk</p> -->
        </section>

        <section id="contact-details" class="section-p1">
            <div class="details">
                <span>GET IN TOUCH</span>
                <h2>Contact Us </h2>
                <div>
                    <li>
                        <i class="bi bi-geo-alt"></i>
                        <p>Thimi, Bhaktapur</p>
                    </li>
                    <li>
                        <i class="bi bi-envelope"></i>
                        <p>shop@us.com</p>
                    </li>
                    <li>
                        <i class="bi bi-telephone"></i>
                        <p>01-6631245, 01-6632154</p>
                    </li>
                </div>
            </div>

            <div class="container">
                <span>LEAVE A MESSAGE</span>
                <h2>We love to hear from you</h2>
                <form action="contact-submit.php" method="post">

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>

                    <label for="name">Subject:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>

                    <input type="submit" value="Submit">
                </form>
            </div>


        </section>

        <footer class="footer" style="margin-top: 200px;">
            <div class="container">
                <p>Copyright &copy 2024. All Rights Reserved.</p>
            </div>
        </footer>
    </body>
</html>
