<?php
include('connect.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cart</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="styleee.css">
        <style>
            .container table{width: 100%;border:1px;}
            .container th{height:50px;background-color:lightblue;color:black;}
            .container td{height: 20px;padding: 10px;20px;}
            .container td img{width: 100px;height:100px;margin-right:20px;}
        </style>
    </head>

    <body>

        <section id="header">
            <img src="/PROJECT/images/l3.png" height="40" width="38"><a>
            <!-- <h>Royal Butterfly</h> -->
                <div>
                <ul id="navbar">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="shop.html">Shop</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a class="active" href="mycart.php"><i class="bi bi-cart-plus" style="font-size: 23px;"></i></a></li>
                    <li><a href="logout.php"><i class="bi bi-person-heart" style="font-size: 20px;"></i></a></li>

                    </li>
                </ul>
            </div>  
        </section>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center border rounded bg-light my-5">
                    <h2>My Cart</h2>
                </div>

                <div class="col-lg-9">
                    <table class="t1">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">SN</th>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            <?php
                            //  include('get_products.php');
                            // $total = 0;
                            if(isset($_SESSION['cart']))
                            {
                                foreach ($_SESSION['cart'] as $key => $value)
                                {
                                    $sr=$key+1;
                                    // $total=$total+$value['Price'];
                                    echo"
                                        <tr>
                                            <td>$sr</td>    
                                            <td>$value[item_name]</td>
                                            <td><img src='/PROJECT/images/a1.jpg'>$value[item_name]</td>
                                            <td><span>Rs </span>$value[Price]<input type='hidden' class='iprice' value='$value[Price]'></td>
                                            <td>
                                                <form action='manage_cart.php' method='POST'>
                                                    <input type='number' class='text-center iquantity' name='Mod_Quantity' onchange='this.form.submit();' value='$value[Quantity]' min='1' max='10'>
                                                    <input type='hidden' name='item_name' value='$value[item_name]'>
                                                </form>
                                            </td>
                                            
                                            <td class='itotal'></td>
                                            <td>
                                                <form action='manage_cart.php' method='POST'>
                                                    <button name='Remove_item' class='btn btn-sm btn-outline-danger'>Remove</button>
                                                    <input type='hidden' name='item_name' value='$value[item_name]'>
                                            </form>
                                            </td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-3">
                    <div class="border bg-light rounded p-4">
                        <h4>Grand Total: (Rs)</h4>
                        <h5 class="text-right" id="gtotal"></h5>
                        <br>

                        <form name="checkout" action="checkout.html" method="POST">
                            <button type="submit" class="btn btn-primary">Checkout</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- <div class="col-lg-3">
            <div class="border bg-light rounded p-4">
                <h4>Grand Total</h4>
                <h5 class="text-right" id="gtotal"></h5>
            
                <form>
                    <button type="button" class="btn btn-primary">Checkout</button>
                </form>
            </div>
        </div> -->

        <script>
            var gt=0;
            var iprice=document.getElementsByClassName('iprice');
            var iquantity=document.getElementsByClassName('iquantity');
            var itotal=document.getElementsByClassName('itotal');
            var gtotal = document.getElementById('gtotal');

            function subTotal()
            {
                gt=0;
                for(i=0;i<iprice.length;i++)
                {
                    
                    itotal[i].innerText=(iprice[i].value)*(iquantity[i].value);
                    gt=gt+(iprice[i].value)*(iquantity[i].value);
                }
                gtotal.innerText=gt;
            }
            subTotal();
        </script>

    </body>
</html>