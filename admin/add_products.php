<?php
include "./templates/top.php";
include "./templates/navbar.php";
include "./templates/sidebar.php";

if (
    !isset($_SESSION["admin_logged_in"]) ||
    $_SESSION["admin_logged_in"] !== true
) {
    header("Location: login.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row" style="min-height: 1000px">
        <main class="col-md-9 ms-sm-auto col-lg-18 px-md-4">
            <h3>Add Product</h3>
            <div class="table-responsive">
                <div class="mx-auto container">
                    <form id="edit-form" enctype="multipart/form-data" method="POST" action="actions/create_products.php">
                        <p style="color: red;">
                            <?php if (isset($_GET["error"])) {
                                echo htmlspecialchars(
                                    $_GET["error"],
                                    ENT_QUOTES,
                                    "UTF-8",
                                );
                            } ?>
                        </p>

                        <div class="form-group mt-2">
                            <label>Product Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="product-name"
                                name="product_name"
                                placeholder="Title"
                                required
                            />
                        </div>

                        <div class="form-group mt-2">
                            <label>Category</label>
                            <select class="form-control" id="product-category" name="product_category" required>
                                <option value="spring collection">Spring Collection</option>
                                <option value="new_arrival">New arrival</option>
                                <option value="summer_wear">Summer Wear</option>
                                <option value="trendy_dress">Trendy Dress</option>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label>Price</label>
                            <input
                                type="number"
                                class="form-control"
                                id="product-price"
                                name="price"
                                placeholder="Price"
                                required
                            />
                        </div>

                        <div class="form-group mt-2">
                            <label>Description</label>
                            <input
                                type="text"
                                class="form-control"
                                id="product-description"
                                name="product_description"
                                placeholder="Enter the product description"
                            />
                        </div>

                        <div class="form-group mt-2">
                            <label>Image</label>
                            <input
                                type="file"
                                class="form-control"
                                id="image"
                                name="image"
                                placeholder="Image"
                                required
                            />
                        </div>

                        <div class="form-group mt-3">
                            <input type="submit" name="add_product" class="btn btn-primary" value="Add Product" />
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
