<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db-conn.php";
include "functions.php";

if (!isset($_GET['edit_product_details'])) {
    die("Product ID is missing from the URL.");
}

$product_id = intval($_GET['edit_product_details']);

// Fetch product details
$query = "SELECT * FROM products WHERE pro_id = $product_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
} else {
    die("Product not found.");
}

// Fetch categories
$category_query = "SELECT * FROM `categories`";
$categories_result = mysqli_query($conn, $category_query);

// Fetch current product's category and subcategory for pre-selection
$current_cate_id = $product['pro_cate'];
$current_sub_cate_id = $product['pro_sub_cate'];

// If product has a subcategory, fetch its details
if ($current_sub_cate_id) {
    $subcategory_query = "SELECT * FROM sub_categories WHERE cate_id = $current_sub_cate_id";
    $subcategory_result = mysqli_query($conn, $subcategory_query);
    $current_subcategory = mysqli_fetch_assoc($subcategory_result);
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Product</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>
    <!-- Add jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="crm_body_bg">
    <?php include "header.php"; ?>
    
    <section class="main_content dashboard_part large_header_bg">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <?php include "top_nav.php"; ?>
                </div>
            </div>
        </div>

        <div class="main_content_iner ">
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h2 class="m-0">Update Product Details</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="card-body">
                                    <form action="update-product.php" method="POST" enctype="multipart/form-data" id="productForm">
                                        <!-- Hidden Input for Product ID -->
                                        <input type="hidden" name="pro_id" value="<?= htmlspecialchars($product['pro_id']) ?>" />
                                        
                                        <!-- Hidden for slug URL generation -->
                                        <input type="hidden" name="slug_url" id="slug_url" value="<?= htmlspecialchars($product['slug_url']) ?>" />

                                        <div class="row mb-3">
                                            <!-- Product Name -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="pro_name">Product Name</label>
                                                <input type="text" class="form-control" name="pro_name" id="pro_name"
                                                    value="<?= htmlspecialchars($product['pro_name']) ?>"
                                                    placeholder="Product Name" />
                                            </div>
                                            
                                            <!-- Brand Name -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="brand_name">Brand Name</label>
                                                <input type="text" class="form-control" name="brand_name" id="brand_name"
                                                    value="<?= htmlspecialchars($product['brand_name'] ?? '') ?>"
                                                    placeholder="Brand Name" />
                                            </div>

                                            <!-- Parent Category -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="pro_cate">Parent Category Name</label>
                                                <select class="form-control" name="pro_cate" id="pro_cate" onchange="get_subcategory(this.value)">
                                                    <option value="">--select--</option>
                                                    <?php
                                                    if ($categories_result && mysqli_num_rows($categories_result) > 0) {
                                                        while ($category = mysqli_fetch_assoc($categories_result)) {
                                                            ?>
                                                                <option value="<?= $category['cate_id'] ?>" 
                                                                    <?= ($current_cate_id == $category['cate_id']) ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars(ucwords($category['categories'])) ?>
                                                                </option>
                                                        <?php
                                                        }
                                                        // Reset pointer for future use if needed
                                                        mysqli_data_seek($categories_result, 0);
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Sub Category -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="pro_sub_cate">Sub Category</label>
                                                <select class="form-control" name="pro_sub_cate" id="subcate_id">
                                                    <option value="">Select Sub Category</option>
                                                    <?php if (isset($current_subcategory)): ?>
                                                            <option value="<?= $current_sub_cate_id ?>" selected>
                                                                <?= htmlspecialchars($current_subcategory['categories']) ?>
                                                            </option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>

                                            <!-- Stock -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="stock">Stock</label>
                                                <input type="text" class="form-control" name="stock" id="stock"
                                                    value="<?= htmlspecialchars($product['stock']) ?>"
                                                    placeholder="Stock" />
                                            </div>

                                            <!-- Qty -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="qty">Quantity</label>
                                                <input type="text" class="form-control" name="qty" id="qty"
                                                    value="<?= htmlspecialchars($product['qty']) ?>"
                                                    placeholder="Quantity" />
                                            </div>

                                            <!-- Product Images -->
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="pro_img">Product Image(s)</label>
                                                <input type="file" class="form-control" name="pro_img[]" id="pro_img" multiple />
                                                <small class="text-muted">Leave empty to keep existing images</small>
                                                
                                                <?php
                                                // Display current images
                                                if (!empty($product['pro_img'])) {
                                                    $images = explode(',', $product['pro_img']);
                                                    echo '<div class="mt-2"><small>Current Images:</small><div class="d-flex flex-wrap mt-2">';
                                                    foreach ($images as $img) {
                                                        $img = trim($img);
                                                        if (!empty($img)) {
                                                            echo '<div class="me-3 mb-3" style="position:relative;">';
                                                            echo '<img src="assets/img/uploads/' . htmlspecialchars($img) . '" 
                                                                  style="height: 150px; width: 150px; object-fit: cover;" 
                                                                  alt="Product Image" class="img-thumbnail">';
                                                            echo '<button type="button" class="btn btn-sm btn-danger remove-image" 
                                                                  style="position:absolute; top:5px; right:5px;"
                                                                  data-image="' . htmlspecialchars($img) . '">×</button>';
                                                            echo '</div>';
                                                        }
                                                    }
                                                    echo '</div></div>';
                                                }
                                                ?>
                                                <!-- Hidden field to track removed images -->
                                                <input type="hidden" name="removed_images" id="removed_images" value="">
                                            </div>

                                            <!-- New Arrival -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="new_arrival">Is it New Arrival</label>
                                                <select id="new_arrival" name="new_arrival" class="form-control">
                                                    <option value="0" <?= ($product['new_arrival'] == 0) ? 'selected' : '' ?>>No</option>
                                                    <option value="1" <?= ($product['new_arrival'] == 1) ? 'selected' : '' ?>>Yes</option>
                                                </select>
                                            </div>

                                            <!-- Trending -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="trending">Is it Trending</label>
                                                <select id="trending" name="trending" class="form-control">
                                                    <option value="0" <?= ($product['trending'] == 0) ? 'selected' : '' ?>>No</option>
                                                    <option value="1" <?= ($product['trending'] == 1) ? 'selected' : '' ?>>Yes</option>
                                                </select>
                                            </div>

                                            <!-- Short Description -->
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="short_desc">Product Short Description</label>
                                                <textarea class="form-control" name="short_desc" id="short_desc" rows="3"><?= htmlspecialchars($product['short_desc']) ?></textarea>
                                            </div>
                                            
                                            <!-- Long Description -->
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="pro_desc">Product Long Description</label>
                                                <textarea class="form-control" name="pro_desc" id="pro_desc" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
                                            </div>

                                            <!-- MRP -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="mrp">MRP</label>
                                                <input type="text" class="form-control" name="mrp" id="mrp"
                                                    value="<?= htmlspecialchars($product['mrp']) ?>"
                                                    placeholder="MRP" />
                                            </div>

                                            <!-- Selling Price -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="selling_price">Selling Price</label>
                                                <input type="text" class="form-control" name="selling_price" id="selling_price"
                                                    value="<?= htmlspecialchars($product['selling_price']) ?>"
                                                    placeholder="Selling Price" />
                                            </div>

                                            <!-- Wholesale Selling Price -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="whole_sale_selling_price">Wholesale Price</label>
                                                <input type="text" class="form-control" name="whole_sale_selling_price" id="whole_sale_selling_price"
                                                    value="<?= htmlspecialchars($product['whole_sale_selling_price']) ?>"
                                                    placeholder="Wholesale Price" />
                                            </div>

                                            <!-- Meta Title -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta_title">Meta Title</label>
                                                <input type="text" class="form-control" name="meta_title" id="meta_title"
                                                    value="<?= htmlspecialchars($product['meta_title']) ?>"
                                                    placeholder="Meta Title" />
                                            </div>

                                            <!-- Meta Keywords -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta_key">Meta Keywords</label>
                                                <input type="text" class="form-control" name="meta_key" id="meta_key"
                                                    value="<?= htmlspecialchars($product['meta_key']) ?>"
                                                    placeholder="Meta Keywords (comma separated)" />
                                            </div>

                                            <!-- Meta Description -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta_desc">Meta Description</label>
                                                <textarea class="form-control" name="meta_desc" id="meta_desc" rows="2"><?= htmlspecialchars($product['meta_desc']) ?></textarea>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="status">Status</label>
                                                <select id="status" name="status" class="form-control">
                                                    <option value="1" <?= ($product['status'] == 1) ? 'selected' : '' ?>>Active</option>
                                                    <option value="0" <?= ($product['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="products.php" class="btn btn-secondary">Cancel</a>
                                            <button type="submit" name="update-product" class="btn btn-primary">
                                                Update Product
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>
    </section>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('pro_desc');
        CKEDITOR.replace('short_desc');
        
        // Auto-generate slug URL from product name
        document.getElementById('pro_name').addEventListener('blur', function() {
            var productName = this.value;
            if (productName) {
                var slug = productName.toLowerCase()
                    .replace(/[^\w\s]/gi, '')
                    .replace(/\s+/g, '-');
                document.getElementById('slug_url').value = slug;
            }
        });

        // Handle image removal
        var removedImages = [];
        document.querySelectorAll('.remove-image').forEach(button => {
            button.addEventListener('click', function() {
                var imageName = this.getAttribute('data-image');
                removedImages.push(imageName);
                document.getElementById('removed_images').value = removedImages.join(',');
                this.parentElement.remove();
            });
        });

        // AJAX function for loading subcategories
        function get_subcategory(cate_id) {
            if (!cate_id) {
                document.getElementById('subcate_id').innerHTML = '<option value="">Select Sub Category</option>';
                return;
            }
            
            $.ajax({
                url: 'functions.php',
                method: 'POST',
                data: { 
                    cate_id: cate_id,
                    action: 'get_subcategories'
                },
                success: function(response) {
                    $('#subcate_id').html(response);
                },
                error: function() {
                    alert("Error loading subcategories");
                    $('#subcate_id').html('<option value="">Error loading subcategories</option>');
                }
            });
        }

        // Form validation (optional fields)
        document.getElementById('productForm').addEventListener('submit', function(e) {
            // Remove any existing error messages
            document.querySelectorAll('.text-danger').forEach(el => el.remove());
            
            // Optional: Add custom validation here if needed
            // For example, check if selling price is less than MRP
            var mrp = parseFloat(document.getElementById('mrp').value);
            var sellingPrice = parseFloat(document.getElementById('selling_price').value);
            
            if (mrp && sellingPrice && sellingPrice > mrp) {
                e.preventDefault();
                alert('Selling price cannot be greater than MRP');
                return false;
            }
        });
    </script>
</body>
</html>