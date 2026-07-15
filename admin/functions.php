<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db-conn.php";

if (isset($_POST["add-categories"])) {
    // Initialize variables
    $errors = [];
    $cate_id = mt_rand(11111, 99999);
    $cate_name = mysqli_real_escape_string($conn, $_POST["cate_name"]);
    $meta_title = mysqli_real_escape_string($conn, $_POST["meta_title"]);
    $meta_key = mysqli_real_escape_string($conn, $_POST["meta_key"]);
    $meta_desc = mysqli_real_escape_string($conn, $_POST["meta_desc"]);
    $status = isset($_POST["status"]) ? (int) $_POST["status"] : 1;
    $slug_url = strtolower(str_replace(" ", "-", $cate_name));
    $image_name = "";

    // Image upload handling
    if (!empty($_FILES['imageUpload']['name'])) {
        $upload_dir = "uploads/category/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_name = time() . "_" . basename($_FILES["imageUpload"]["name"]);
        $target_file = $upload_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image
        $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
        if ($check === false) {
            $errors[] = "File is not an image.";
        }

        // Check file size (5MB max)
        if ($_FILES["imageUpload"]["size"] > 5000000) {
            $errors[] = "Image is too large (max 5MB).";
        }

        // Allow certain file formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($imageFileType, $allowed_types)) {
            $errors[] = "Only JPG, JPEG, PNG, GIF & WEBP files are allowed.";
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
                $image_name = $file_name;
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $errors[] = "Please select a category image.";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO `categories` (`cate_id`, `categories`, `meta_title`, `meta_desc`, `meta_key`, `image`, `slug_url`, `status`, `added_on`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssi", $cate_id, $cate_name, $meta_title, $meta_desc, $meta_key, $image_name, $slug_url, $status);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Category added successfully!";
            header("Location: view-categories.php");
            exit();
        } else {
            // Delete uploaded image if DB insert failed
            if (!empty($image_name) && file_exists($upload_dir . $image_name)) {
                unlink($upload_dir . $image_name);
            }
            $errors[] = "Database error: " . $conn->error;
        }
    }

    // If there were errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}



if (isset($_POST["add-sub-categories"])) {

    $uploadedImage = ''; // default empty value
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
        // File details
        $fileTmpPath = $_FILES['imageUpload']['tmp_name'];
        $fileName = $_FILES['imageUpload']['name'];
        // $fileSize and $fileType are retrieved but not used
        // $fileSize = $_FILES['imageUpload']['size'];
        // $fileType = $_FILES['imageUpload']['type'];

        // Get file extension
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        // Check if file type is allowed
        if (in_array($fileExtension, $allowedExtensions)) {
            // Create a unique filename
            $newFileName = uniqid('img_', true) . '.' . $fileExtension;

            // Define upload directory
            $uploadDir = 'uploads/sub-category/';

            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create with full permissions
            }

            // Final file destination
            $destPath = $uploadDir . $newFileName;

            // Move uploaded file
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                echo "✅ File uploaded successfully! <br>";
                echo "📂 Saved at: <a href='$destPath'>$destPath</a>";
                $uploadedImage = $newFileName; // use the new unique filename for database
            } else {
                echo "❌ Error: Could not move file!";
            }
        } else {
            echo "❌ Error: Only JPG, JPEG, PNG, GIF, and WEBP files are allowed!";
        }
    }

    // If no file was uploaded, you may want to set a default image filename or leave empty.
    if (empty($uploadedImage)) {
        // echo "<script>alert('Image is not uploaded!!')</script>";
        // $uploadedImage = 'default_image.jpg'; 
        // or empty string if you wish
    }

    $cate_id = mt_rand(11111, 99999);
    $cate_name = mysqli_real_escape_string($conn, $_POST["cate_name"]);
    $meta_title = mysqli_real_escape_string($conn, $_POST["meta_title"]);
    $meta_key = mysqli_real_escape_string($conn, $_POST["meta_key"]);
    $meta_desc = mysqli_real_escape_string($conn, $_POST["meta_desc"]);
    $added_on = date('M d, Y');
    $parent_id = mysqli_real_escape_string($conn, $_POST['parent_id']);
    $slug_url = strtolower(str_replace(" ", "-", $cate_name));

    $sql = "INSERT INTO `sub_categories`( `parent_id`,`cate_id`, `categories`, `meta_title`, `meta_desc`, `meta_key`, `sub_cat_img`, `slug_url`, `status`, `added_on`) 
            VALUES ('$parent_id','$cate_id','$cate_name','$meta_title','$meta_desc','$meta_key', '$uploadedImage', '$slug_url', 1, '$added_on')";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        ?>
        <script type="text/javascript">
            alert('Add sub category Successfully!');
            window.location.href = "view-sub-categories.php";
        </script>
        <?php
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
}
function get_Category()
{
    include "db-conn.php";

    // Search functionality
    $searchQuery = "";
    $params = [];
    $types = "";

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = "%" . $_GET['search'] . "%";
        $searchQuery = " WHERE categories LIKE ? OR slug_url LIKE ? OR cate_id LIKE ?";
        $params = [$search, $search, $search];
        $types = "sss";
    }

    // Optimized query
    $sql = "SELECT * FROM categories $searchQuery ORDER BY id DESC";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $sno = 1;
        $output = '';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Status with modern badge
                if ($row['status'] == '1') {
                    $status = '<span class="status-badge status-active">
                                <i class="fas fa-check-circle me-1"></i>Active
                              </span>';
                } else {
                    $status = '<span class="status-badge status-inactive">
                                <i class="fas fa-times-circle me-1"></i>Inactive
                              </span>';
                }

                // Format date with time
                $added_on = date('d M Y, h:i A', strtotime($row['added_on']));

                // Category with image if exists
                $categoryName = htmlspecialchars(ucwords($row['categories']));
                $categoryDisplay = !empty($row['image'])
                    ? '<div class="d-flex align-items-center">
                         <img src="uploads/category/' . htmlspecialchars($row['image']) . '" 
                              class="category-image me-3" 
                              alt="' . $categoryName . '"
                              data-bs-toggle="tooltip" 
                              title="' . $categoryName . '">
                         <div>
                           <div class="fw-semibold mb-1">' . $categoryName . '</div>
                           <small class="text-muted">ID: ' . htmlspecialchars($row['cate_id']) . '</small>
                         </div>
                       </div>'
                    : '<div>
                         <div class="fw-semibold mb-1">' . $categoryName . '</div>
                         <small class="text-muted">ID: ' . htmlspecialchars($row['cate_id']) . '</small>
                       </div>';

                // Truncate slug URL
                $slug_url = htmlspecialchars($row['slug_url']);
                $slug_display = strlen($slug_url) > 30
                    ? '<span data-bs-toggle="tooltip" title="' . $slug_url . '">'
                    . substr($slug_url, 0, 30) . '...</span>'
                    : $slug_url;

                $output .= "<tr>
                    <td class='text-center align-middle'>
                        <span class='text-muted fw-semibold'>" . $sno++ . "</span>
                    </td>
                    <td class='align-middle'>" . $categoryDisplay . "</td>
                    <td class='align-middle'>
                        <div class='d-flex align-items-center'>
                            <i class='fas fa-link text-muted me-2'></i>
                            <span class='text-truncate' style='max-width: 150px;'>
                                " . $slug_display . "
                            </span>
                        </div>
                    </td>
                    <td class='align-middle'>" . $status . "</td>
                    <td class='align-middle'>
                        <div class='small text-muted'>
                            <i class='far fa-calendar me-1'></i>" . $added_on . "
                        </div>
                    </td>
                    <td class='align-middle text-center'>
                        <div class='d-flex justify-content-center gap-2'>
                            <a href='edit_category.php?id=" . urlencode($row['cate_id']) . "' 
                               class='btn btn-primary action-btn'
                               data-bs-toggle='tooltip' 
                               title='Edit'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='cat-toggle_status.php?type=category&id=" . urlencode($row['cate_id']) . "&status=" . $row['status'] . "' 
                               class='btn btn-warning action-btn'
                               data-bs-toggle='tooltip' 
                               title='" . ($row['status'] == '1' ? 'Deactivate' : 'Activate') . "'>
                                <i class='fas fa-power-off'></i>
                            </a>
                            <a href='view-categories.php?id=" . urlencode($row['cate_id']) . "' 
                               class='btn btn-danger action-btn delete-btn'
                               data-id='" . urlencode($row['cate_id']) . "'
                               data-name='" . htmlspecialchars($row['categories']) . "'
                               data-bs-toggle='modal' 
                               data-bs-target='#deleteModal'
                               title='Delete'>
                                <i class='fas fa-trash'></i>
                            </a>
                        </div>
                    </td>
                </tr>";
            }
        } else {
            $output = "<tr>
                <td colspan='6' class='text-center py-5'>
                    <div class='empty-state'>
                        <div class='empty-state-icon'>
                            <i class='fas fa-layer-group'></i>
                        </div>
                        <h5 class='text-muted mb-2'>No Categories Found</h5>
                        <p class='text-muted small mb-4'>Get started by creating your first category</p>
                        <a href='add-categories.php' class='btn btn-primary'>
                            <i class='fas fa-plus me-2'></i>Add Category
                        </a>
                    </div>
                </td>
            </tr>";
        }

        mysqli_stmt_close($stmt);
        return $output;

    } else {
        return "<tr>
            <td colspan='6' class='text-center py-4 text-danger'>
                <div class='d-flex align-items-center justify-content-center'>
                    <i class='fas fa-exclamation-triangle me-2'></i>Error loading data
                </div>
            </td>
        </tr>";
    }

    // mysqli_close($conn);
}


function get_Sub_Category()
{
    include "db-conn.php";

    // Search functionality with parameterized query for security
    $searchQuery = "";
    $params = [];
    $types = "";

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = "%" . $_GET['search'] . "%";
        $searchQuery = " WHERE sc.categories LIKE ? 
                        OR sc.slug_url LIKE ? 
                        OR c.categories LIKE ?";
        $params = [$search, $search, $search];
        $types = "sss";
    }

    // Optimized query with JOIN and prepared statement
    $sql = "SELECT 
                sc.id,
                sc.cate_id,
                sc.categories,
                sc.slug_url,
                sc.status,
                sc.added_on,
                sc.sub_cat_img,
                c.categories as parent_category,
                c.cate_id as parent_cate_id
            FROM sub_categories sc
            LEFT JOIN categories c ON sc.parent_id = c.cate_id
            $searchQuery 
            ORDER BY sc.added_on DESC, sc.categories ASC";

    // Use prepared statement for security
    if ($stmt = mysqli_prepare($conn, $sql)) {
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $sno = 1;
        $output = '';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Status with better styling
                if ($row['status'] == '1') {
                    $status = '<span class="badge bg-success bg-opacity-20 text-success fw-semibold">
                                <i class="fas fa-check-circle me-1"></i>Active
                              </span>';
                } else {
                    $status = '<span class="badge bg-danger bg-opacity-20 text-danger fw-semibold">
                                <i class="fas fa-times-circle me-1"></i>Inactive
                              </span>';
                }

                // Format date with time
                $added_on = date('d M Y, h:i A', strtotime($row['added_on']));

                // Sub Category with optional image
                $subCategoryName = htmlspecialchars(ucwords($row['categories']));
                $subCategoryDisplay = $row['sub_cat_img']
                    ? '<div class="d-flex align-items-center">
                         <img src="' . 'uploads/sub-category/' . htmlspecialchars($row['sub_cat_img']) . '" 
                              class="rounded me-2" 
                              width="30" 
                              height="30" 
                              style="object-fit: cover">
                         <div>
                           <div class="fw-semibold">' . $subCategoryName . '</div>
                           <small class="text-muted">' . htmlspecialchars($row['cate_id']) . '</small>
                         </div>
                       </div>'
                    : '<div>
                         <div class="fw-semibold">' . $subCategoryName . '</div>
                         <small class="text-muted">' . htmlspecialchars($row['cate_id']) . '</small>
                       </div>';

                // Parent category with link
                $parentCategory = $row['parent_category']
                    ? '<a href="#" class="text-decoration-none text-primary">
                         <i class="fas fa-folder me-1"></i>' . htmlspecialchars($row['parent_category']) . '
                       </a>'
                    : '<span class="text-muted"><i class="fas fa-times me-1"></i>Unassigned</span>';

                $output .= "<tr>
                    <td class='text-center align-middle'>
                        <span class='text-muted'>" . $sno++ . "</span>
                    </td>
                    <td class='align-middle'>" . $subCategoryDisplay . "</td>
                    <td class='align-middle'>" . $parentCategory . "</td>
                    <td class='align-middle'>
                        <div class='text-truncate' style='max-width: 200px;' 
                             data-bs-toggle='tooltip' 
                             title='" . htmlspecialchars($row['slug_url']) . "'>
                            <i class='fas fa-link text-muted me-1'></i>
                            " . htmlspecialchars($row['slug_url']) . "
                        </div>
                    </td>
                    <td class='align-middle'>" . $status . "</td>
                    <td class='align-middle'>
                        <div class='small text-muted'>
                            <i class='far fa-calendar me-1'></i>" . $added_on . "
                        </div>
                    </td>
                    <td class='align-middle text-center'>
                        <div class='btn-group' role='group'>
                            <a href='edit_sub_category.php?id=" . urlencode($row['cate_id']) . "' 
                               class='btn btn-sm btn-outline-primary px-3'
                               data-bs-toggle='tooltip' 
                               title='Edit'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='toggle_status.php?type=sub_category&id=" . urlencode($row['cate_id']) . "&status=" . $row['status'] . "' 
                               class='btn btn-sm btn-outline-warning px-3'
                               data-bs-toggle='tooltip' 
                               title='" . ($row['status'] == '1' ? 'Deactivate' : 'Activate') . "'>
                                <i class='fas fa-power-off'></i>
                            </a>
                            <a href='view-sub-categories.php?id=" . $row['cate_id'] . "' 
                               class='btn btn-sm btn-outline-danger px-3 delete-btn'
                               data-id='" . urlencode($row['cate_id']) . "'
                               data-name='" . htmlspecialchars($row['categories']) . "'
                               data-bs-toggle='modal' 
                               data-bs-target='#deleteModal'
                               title='Delete'>
                                <i class='fas fa-trash'></i>
                            </a>
                        </div>
                    </td>
                </tr>";
            }
        } else {
            $output = "<tr>
                <td colspan='7' class='text-center py-5'>
                    <div class='empty-state'>
                        <i class='fas fa-layer-group fs-1 text-muted mb-3'></i>
                        <h5 class='text-muted mb-2'>No Sub Categories Found</h5>
                        <p class='text-muted small mb-4'>Get started by adding your first sub category</p>
                        <a href='add-sub-category.php' class='btn btn-primary btn-sm'>
                            <i class='fas fa-plus me-2'></i>Add Sub Category
                        </a>
                    </div>
                </td>
            </tr>";
        }

        mysqli_stmt_close($stmt);
        return $output;

    } else {
        return "<tr>
            <td colspan='7' class='text-center py-4 text-danger'>
                <i class='fas fa-exclamation-triangle me-2'></i>Error loading data
            </td>
        </tr>";
    }

    // mysqli_close($conn);
}


// if(isset($_POST["add-product"])){
//     $pro_id = mt_rand(11111, 99999);
//     $pro_name = $_POST['pro_name'];
//     $pro_cate = $_POST['pro_cate'];
//     $pro_sub_cate = $_POST['pro_sub_cate'];
//     $description = $_POST['pro_desc'];
//     $new_arrival = $_POST['new_arrival'];
//     $mrp = $_POST['mrp'];
//     $selling_price = $_POST['selling_price'];
//     $stock = $_POST['stock'];
//     $status = $_POST['status'];

//     $filename = $_FILES['pro_img']['name'];
//     $tmepname = $_FILES['pro_img']['tmp_name'];
//     $destination = 'assests/img/uploads/'.$filename;
//     move_uploaded_file($tmepname,$destination);

//     $meta_title = $_POST["meta_title"];
//     $meta_key = $_POST["meta_key"];
//     $meta_desc = $_POST["meta_desc"];
//     $added_on = date('M d, Y');
//     $slug_url = SlugUrl($pro_name); 


//     $sql ="INSERT INTO `products`(`pro_id`, `pro_name`, `pro_cate`, `pro_sub_cate`, `short_desc`, `description`,`new_arrival`, `mrp`, `selling_price`, `stock`, `pro_img`, `status`,`slug_url`, `meta_title`, `meta_desc`, `meta_key`, `added_on`) VALUES ('$pro_id','$pro_name','$pro_cate','$pro_sub_cate','$description','$new_arrival','$mrp','$selling_price','$stock','$status','$slug_url','$filename','$meta_title','$meta_key','$meta_desc','$added_on','$added_on')";

//     $check = mysqli_query($conn, $sql);
//     if($check){
//         


if (isset($_POST["add-product"])) {
    $pro_id = mt_rand(11111, 99999);
    $pro_name = mysqli_real_escape_string($conn, $_POST['pro_name']);
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $pro_cate = mysqli_real_escape_string($conn, $_POST['pro_cate']);
    $pro_sub_cate = mysqli_real_escape_string($conn, $_POST['pro_sub_cate']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $description = mysqli_real_escape_string($conn, $_POST['pro_desc']);
    $new_arrival = mysqli_real_escape_string($conn, $_POST['new_arrival']);
    $trending = mysqli_real_escape_string($conn, $_POST['trending']);
    $whole_sale_selling_price = mysqli_real_escape_string($conn, $_POST['whole_selling_price']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $mrp = mysqli_real_escape_string($conn, $_POST['mrp']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Ensure the folder exists and is writable
    $folder = 'assets/img/uploads/';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    // Loop through each uploaded file
    foreach ($_FILES['pro_img']['tmp_name'] as $key => $tempname) {
        // Get the original file name for the current image
        $filename = $_FILES['pro_img']['name'][$key];
        $destination = $folder . $filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tempname, $destination)) {
            echo "Image uploaded successfully: " . $filename . "<br>";
        } else {
            echo "Failed to upload image: " . $filename . "<br>";
        }
    }



    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_key = mysqli_real_escape_string($conn, $_POST["meta_key"]);
    $meta_desc = mysqli_real_escape_string($conn, $_POST["meta_desc"]);
    $added_on = date('M d, Y');
    $slug_url = strtolower(str_replace(" ", "-", $pro_name));
    // $slug_url = SlugUrl($pro_name); 
    // Assuming this function generates a valid slug

    // Corrected SQL query
    $sql = $sql = "INSERT INTO `products`(`pro_id`, `pro_name`,`brand_name` , `pro_cate`, `pro_sub_cate`, `short_desc`, `description`, `new_arrival`,`trending`, `qty`, `mrp`, `selling_price`, `whole_sale_selling_price`, `stock`, `pro_img`, `status`, `slug_url`, `meta_title`, `meta_desc`, `meta_key`, `added_on`) 
VALUES ('$pro_id', '$pro_name', '$brand_name','$pro_cate', '$pro_sub_cate', '$short_description', '$description', '$new_arrival', '$trending', '$qty','$mrp', '$selling_price', '$whole_sale_selling_price', '$stock', '$filename', '$status', '$slug_url', '$meta_title', '$meta_desc', '$meta_key', '$added_on')";


    // Execute the query
    $check = mysqli_query($conn, $sql);
    if ($check) {
        ?>
        <script type="text/javascript">
            alert('Inserted Successfully!');
            window.location.href = "add-products.php";
        </script>
        <?php
    } else {
        echo "Error: " . mysqli_error($conn);  // Optional: Display any error message from MySQL
    }
}
function get_Inquiries()
{
    include "db-conn.php";

    // Search and filter parameters
    $searchQuery = "";
    $params = [];
    $types = "";

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = "%" . $_GET['search'] . "%";
        $searchQuery = " WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?";
        $params = [$search, $search, $search, $search];
        $types = "ssss";
    }

    // Status filter
    if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] != 'all') {
        $searchQuery .= empty($searchQuery) ? " WHERE" : " AND";
        $searchQuery .= " status = ?";
        $params[] = $_GET['status'];
        $types .= "s";
    }

    // Date filter
    if (isset($_GET['date']) && !empty($_GET['date'])) {
        $searchQuery .= empty($searchQuery) ? " WHERE" : " AND";
        $searchQuery .= " DATE(created_at) = ?";
        $params[] = $_GET['date'];
        $types .= "s";
    }

    $sql = "SELECT * FROM inquiries $searchQuery ORDER BY 
            CASE 
                WHEN status = 'unread' THEN 1
                WHEN status = 'pending' THEN 2
                WHEN status = 'read' THEN 3
                ELSE 4
            END, 
            created_at DESC";

    // Use prepared statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $sno = 1;
        $output = '';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Status badge
                $statusBadge = getInquiryStatusBadge($row['status']);

                // Format date
                $created_at = date('d M Y, h:i A', strtotime($row['created_at']));

                // Truncate message for table view
                $shortMessage = strlen($row['message']) > 100
                    ? substr($row['message'], 0, 100) . '...'
                    : $row['message'];

                $output .= "<tr data-status='" . htmlspecialchars($row['status']) . "' 
                                   data-date='" . date('Y-m-d', strtotime($row['created_at'])) . "'>
                    <td class='text-center align-middle'>
                        <span class='text-muted'>" . $sno++ . "</span>
                    </td>
                    <td class='align-middle'>
                        <div class='fw-semibold'>" . htmlspecialchars($row['name']) . "</div>
                        <small class='text-muted'>ID: " . htmlspecialchars($row['id']) . "</small>
                    </td>
                    <td class='align-middle'>
                        <div>
                            <div><i class='fas fa-envelope text-muted me-1'></i>" . htmlspecialchars($row['email']) . "</div>
                            <div><i class='fas fa-phone text-muted me-1'></i>" . htmlspecialchars($row['phone']) . "</div>
                        </div>
                    </td>
                    <td class='align-middle'>
                        <div class='fw-semibold'>" . htmlspecialchars($row['subject']) . "</div>
                        <small class='text-muted'>" . $created_at . "</small>
                    </td>
                    <td class='align-middle'>
                        <div class='text-truncate' style='max-width: 300px;'>
                            " . htmlspecialchars($shortMessage) . "
                        </div>
                    </td>
                    <td class='align-middle'>" . $statusBadge . "</td>
                    <td class='align-middle text-center'>
                        <div class='btn-group' role='group'>
                            <button type='button' 
                                    class='btn btn-sm btn-outline-primary px-3 view-inquiry'
                                    data-id='" . htmlspecialchars($row['id']) . "'
                                    data-bs-toggle='modal' 
                                    data-bs-target='#inquiryModal'
                                    data-bs-toggle='tooltip' 
                                    title='View Details'>
                                <i class='fas fa-eye'></i>
                            </button>
                            <a href='mailto:" . htmlspecialchars($row['email']) . "?subject=Re: " . urlencode($row['subject']) . "' 
                               class='btn btn-sm btn-outline-success px-3'
                               data-bs-toggle='tooltip' 
                               title='Reply'>
                                <i class='fas fa-reply'></i>
                            </a>
                            <a href='delete_inquiry.php?id=" . urlencode($row['id']) . "' 
                               class='btn btn-sm btn-outline-danger px-3 delete-inquiry'
                               data-bs-toggle='tooltip' 
                               title='Delete'
                               onclick='return confirm(\"Are you sure you want to delete this inquiry?\")'>
                                <i class='fas fa-trash'></i>
                            </a>
                        </div>
                    </td>
                </tr>";
            }
        } else {
            $output = "<tr>
                <td colspan='7' class='text-center py-5'>
                    <div class='empty-state'>
                        <i class='fas fa-inbox fs-1 text-muted mb-3'></i>
                        <h5 class='text-muted mb-2'>No Inquiries Found</h5>
                        <p class='text-muted small'>All customer inquiries will appear here</p>
                    </div>
                </td>
            </tr>";
        }

        mysqli_stmt_close($stmt);
        return $output;

    } else {
        return "<tr>
            <td colspan='7' class='text-center py-4 text-danger'>
                <i class='fas fa-exclamation-triangle me-2'></i>Error loading inquiries
            </td>
        </tr>";
    }
}

function getInquiryStatusBadge($status)
{
    switch ($status) {
        case 'unread':
            return '<span class="badge bg-warning bg-opacity-20 text-warning fw-semibold">
                    <i class="fas fa-envelope me-1"></i>Unread</span>';
        case 'read':
            return '<span class="badge bg-info bg-opacity-20 text-info fw-semibold">
                    <i class="fas fa-envelope-open me-1"></i>Read</span>';
        case 'replied':
            return '<span class="badge bg-success bg-opacity-20 text-success fw-semibold">
                    <i class="fas fa-reply me-1"></i>Replied</span>';
        case 'pending':
            return '<span class="badge bg-secondary bg-opacity-20 text-secondary fw-semibold">
                    <i class="fas fa-clock me-1"></i>Pending</span>';
        default:
            return '<span class="badge bg-light text-muted fw-semibold">' . $status . '</span>';
    }
}

if (isset($_POST['cate_id'])) {
    $p_id = $_POST['cate_id'];
    $sql = "SELECT * FROM `sub_categories` where `parent_id` = '$p_id' ORDER BY id DESC";
    $check = mysqli_query($conn, $sql);
    ?>
    <option value="">Select</option>
    <?php
    while ($result = mysqli_fetch_assoc($check)) {
        echo "<option value=" . $result['cate_id'] . ">" . $result['categories'] . "</option>";
    }
}

function SlugUrl($string)
{
    $slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $string);
    $slug = str_replace('', '-', $slug);
    $slug = strtolower($slug);
    return ($slug);
}



// Get a single category by ID
function get_category_by_id($cat_id)
{
    global $conn;
    $cat_id = mysqli_real_escape_string($conn, $cat_id);
    $sql = "SELECT * FROM `categories` WHERE cate_id = '$cat_id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Update a category



function get_sub_category_by_id($cat_id)
{
    global $conn;
    $cat_id = mysqli_real_escape_string($conn, $cat_id);
    $sql = "SELECT * FROM `sub_categories` WHERE cate_id = '$cat_id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}


function get_testimonial_by_id($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function update_testimonial(
    $id,
    $client_name,
    $client_title,
    $client_company,
    $client_photo,
    $testimonial_text,
    $rating,
    $project_name,
    $project_date,
    $featured,
    $display_order
) {
    global $conn;
    $stmt = $conn->prepare("UPDATE testimonials SET 
                           client_name = ?, 
                           client_title = ?, 
                           client_company = ?, 
                           client_photo = ?, 
                           testimonial_text = ?, 
                           rating = ?, 
                           project_name = ?, 
                           project_date = ?, 
                           featured = ?, 
                           display_order = ?, 
                           updated_at = NOW() 
                           WHERE id = ?");
    $stmt->bind_param(
        "sssssisssii",
        $client_name,
        $client_title,
        $client_company,
        $client_photo,
        $testimonial_text,
        $rating,
        $project_name,
        $project_date,
        $featured,
        $display_order,
        $id
    );
    return $stmt->execute();
}



// Handle add testimonial
if (isset($_POST['add-testimonial'])) {
    // Validate and sanitize input
    $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
    $client_title = mysqli_real_escape_string($conn, $_POST['client_title']);
    $client_company = mysqli_real_escape_string($conn, $_POST['client_company']);
    $testimonial_text = mysqli_real_escape_string($conn, $_POST['testimonial_text']);
    $rating = intval($_POST['rating']);
    $project_name = mysqli_real_escape_string($conn, $_POST['project_name']);
    $project_date = mysqli_real_escape_string($conn, $_POST['project_date']);
    $featured = isset($_POST['featured']) ? 1 : 0;
    $display_order = intval($_POST['display_order']);

    // Handle file upload
    $client_photo = '';
    if (isset($_FILES['client_photo']) && $_FILES['client_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/testimonials/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_name = time() . '_' . basename($_FILES['client_photo']['name']);
        $target_path = $upload_dir . $file_name;

        // Check if image file is an actual image
        $check = getimagesize($_FILES['client_photo']['tmp_name']);
        if ($check !== false) {
            // Move the uploaded file
            if (move_uploaded_file($_FILES['client_photo']['tmp_name'], $target_path)) {
                $client_photo = $file_name;
            }
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO testimonials (
        client_name, 
        client_title, 
        client_company, 
        client_photo, 
        testimonial_text, 
        rating, 
        project_name, 
        project_date, 
        featured, 
        display_order,
        created_at,
        updated_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

    $stmt->bind_param(
        "sssssisssi",
        $client_name,
        $client_title,
        $client_company,
        $client_photo,
        $testimonial_text,
        $rating,
        $project_name,
        $project_date,
        $featured,
        $display_order
    );

    if ($stmt->execute()) {
        $testimonial_id = $stmt->insert_id;
        $_SESSION['success'] = "Testimonial added successfully!";
        header("Location: testimonials.php?edit=" . $testimonial_id);
        exit();
    } else {
        $_SESSION['error'] = "Error adding testimonial: " . $conn->error;
        header("Location: add-testimonial.php");
        exit();
    }
}

// Handle update testimonial
if (isset($_POST['update-testimonial'])) {
    $testimonial_id = intval($_POST['testimonial_id']);

    // Validate and sanitize input (same as above)
    $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
    // ... [all other fields same as above]

    // First get current photo
    $current_photo = '';
    $stmt = $conn->prepare("SELECT client_photo FROM testimonials WHERE id = ?");
    $stmt->bind_param("i", $testimonial_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $current_photo = $row['client_photo'];
    }

    // Handle file upload
    $client_photo = $current_photo;
    if (isset($_FILES['client_photo']) && $_FILES['client_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/testimonials/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Delete old photo if exists
        if (!empty($current_photo)) {
            $old_file = $upload_dir . $current_photo;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }

        $file_name = time() . '_' . basename($_FILES['client_photo']['name']);
        $target_path = $upload_dir . $file_name;

        $check = getimagesize($_FILES['client_photo']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['client_photo']['tmp_name'], $target_path)) {
                $client_photo = $file_name;
            }
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE testimonials SET 
        client_name = ?, 
        client_title = ?, 
        client_company = ?, 
        client_photo = ?, 
        testimonial_text = ?, 
        rating = ?, 
        project_name = ?, 
        project_date = ?, 
        featured = ?, 
        display_order = ?,
        updated_at = NOW()
        WHERE id = ?");

    $stmt->bind_param(
        "sssssisssii",
        $client_name,
        $client_title,
        $client_company,
        $client_photo,
        $testimonial_text,
        $rating,
        $project_name,
        $project_date,
        $featured,
        $display_order,
        $testimonial_id
    );

    if ($stmt->execute()) {
        $_SESSION['success'] = "Testimonial updated successfully!";
        header("Location: testimonials.php?edit=" . $testimonial_id);
        exit();
    } else {
        $_SESSION['error'] = "Error updating testimonial: " . $conn->error;
        header("Location: testimonials.php?edit=" . $testimonial_id);
        exit();
    }
}

function handleTestimonialSubmission($conn)
{
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return ['status' => 'error', 'message' => 'Invalid request method'];
    }

    // Initialize variables with sanitized input
    $client_name = trim(filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_STRING));
    $client_title = trim(filter_input(INPUT_POST, 'client_title', FILTER_SANITIZE_STRING));
    $client_company = trim(filter_input(INPUT_POST, 'client_company', FILTER_SANITIZE_STRING));
    $testimonial_text = trim(filter_input(INPUT_POST, 'testimonial_text', FILTER_SANITIZE_STRING));
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 5]]);
    $project_name = trim(filter_input(INPUT_POST, 'project_name', FILTER_SANITIZE_STRING));
    $project_date = trim(filter_input(INPUT_POST, 'project_date', FILTER_SANITIZE_STRING));
    $featured = isset($_POST['featured']) ? 1 : 0;
    $display_order = filter_input(INPUT_POST, 'display_order', FILTER_VALIDATE_INT);
    $testimonial_id = filter_input(INPUT_POST, 'testimonial_id', FILTER_VALIDATE_INT);
    $is_edit = isset($_POST['update-testimonial']);

    // Validate required fields
    if (empty($client_name) || empty($client_title) || empty($testimonial_text) || !$rating) {
        return ['status' => 'error', 'message' => 'Please fill all required fields'];
    }

    // Handle file upload
    $client_photo = null;
    $upload_dir = '../uploads/testimonials/';

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (isset($_FILES['client_photo']) && $_FILES['client_photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['client_photo'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            return ['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG, GIF are allowed'];
        }

        if ($file['size'] > 5242880) { // 5MB
            return ['status' => 'error', 'message' => 'File size exceeds 5MB limit'];
        }

        // Generate unique filename
        $client_photo = uniqid('testimonial_', true) . '.' . $file_ext;
        $destination = $upload_dir . $client_photo;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['status' => 'error', 'message' => 'Failed to upload file'];
        }

        // If editing, delete old photo
        if ($is_edit && !empty($_POST['existing_photo'])) {
            $old_photo = $upload_dir . $_POST['existing_photo'];
            if (file_exists($old_photo)) {
                unlink($old_photo);
            }
        }
    } elseif ($is_edit) {
        // Keep existing photo if not uploading new one during edit
        $client_photo = $_POST['existing_photo'] ?? null;
    }

    // Prepare data for database
    $current_time = date('Y-m-d H:i:s');
    $project_date = !empty($project_date) ? $project_date : null;
    $display_order = $display_order !== false ? $display_order : 0;

    try {
        if ($is_edit && $testimonial_id) {
            // Update existing testimonial
            $stmt = $conn->prepare("UPDATE testimonials SET 
                client_name = ?, 
                client_title = ?, 
                client_company = ?, 
                client_photo = COALESCE(?, client_photo), 
                testimonial_text = ?, 
                rating = ?, 
                project_name = ?, 
                project_date = ?, 
                featured = ?, 
                display_order = ?, 
                updated_at = ?
                WHERE id = ?");

            $stmt->bind_param(
                "sssssisssisi",
                $client_name,
                $client_title,
                $client_company,
                $client_photo,
                $testimonial_text,
                $rating,
                $project_name,
                $project_date,
                $featured,
                $display_order,
                $current_time,
                $testimonial_id
            );
        } else {
            // Insert new testimonial
            $stmt = $conn->prepare("INSERT INTO testimonials (
                client_name, 
                client_title, 
                client_company, 
                client_photo, 
                testimonial_text, 
                rating, 
                project_name, 
                project_date, 
                featured, 
                display_order, 
                created_at, 
                updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                "sssssisssiss",
                $client_name,
                $client_title,
                $client_company,
                $client_photo,
                $testimonial_text,
                $rating,
                $project_name,
                $project_date,
                $featured,
                $display_order,
                $current_time,
                $current_time
            );
        }

        if ($stmt->execute()) {
            return [
                'status' => 'success',
                'message' => $is_edit ? 'Testimonial updated successfully' : 'Testimonial added successfully',
                'testimonial_id' => $is_edit ? $testimonial_id : $stmt->insert_id
            ];
        } else {
            return ['status' => 'error', 'message' => 'Database error: ' . $stmt->error];
        }
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
    }
}

// Handle form submission
if (isset($_POST['add-testimonial']) || isset($_POST['update-testimonial'])) {
    $result = handleTestimonialSubmission($conn);

    // Return JSON response for AJAX or redirect for normal form submission
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    } else {
        // Store result in session for display after redirect
        session_start();
        $_SESSION['form_result'] = $result;

        $redirect_url = isset($_POST['update-testimonial']) ?
            'testimonials.php?edit=' . $_POST['testimonial_id'] :
            'testimonials.php';

        header('Location: ' . $redirect_url);
        exit;
    }
}



function displayInquiries() {
    global $conn;
    
    $sql = "SELECT * FROM inquiries ORDER BY 
            CASE status 
                WHEN 'unread' THEN 1 
                WHEN 'read' THEN 2 
                ELSE 3 
            END, 
            created_at DESC";
    
    $result = mysqli_query($conn, $sql);
    $html = '';
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $status_class = '';
            $status_text = '';
            
            switch($row['status']) {
                case 'unread':
                    $status_class = 'status-unread';
                    $status_text = 'Unread';
                    break;
                case 'read':
                    $status_class = 'status-read';
                    $status_text = 'Read';
                    break;
                case 'replied':
                    $status_class = 'status-replied';
                    $status_text = 'Replied';
                    break;
                default:
                    $status_class = 'status-unread';
                    $status_text = 'Unread';
            }
            
            $html .= '<tr data-id="' . $row['id'] . '" 
                           data-status="' . $row['status'] . '"
                           data-destination="' . $row['destination'] . '"
                           data-date="' . $row['created_at'] . '">';
            $html .= '<td>' . $row['id'] . '</td>';
            $html .= '<td>';
            $html .= '<div class="fw-bold">' . $row['name'] . '</div>';
            $html .= '<small class="text-muted">' . $row['email'] . '</small>';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<div><i class="fas fa-calendar me-1 text-muted"></i>' . date('d M Y', strtotime($row['travel_date'] ?? '')) . '</div>';
            $html .= '<div><i class="fas fa-users me-1 text-muted"></i>' . $row['adults'] . ' Adults, ' . $row['children'] . ' Children</div>';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<div class="fw-bold">' . htmlspecialchars($row['destination'] ?? '') . '</div>';
            $html .= '<small class="text-muted">' . htmlspecialchars($row['timeline']?? '') . '</small>';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<div class="text-truncate" style="max-width: 200px;">' . htmlspecialchars($row['message']) . '</div>';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<span class="status-badge ' . $status_class . '">' . $status_text . '</span>';
            $html .= '</td>';
            $html .= '<td>' . date('d M Y', strtotime($row['created_at'])) . '</td>';
            $html .= '<td>';
            $html .= '<div class="btn-group" role="group">';
            $html .= '<button class="btn btn-sm btn-outline-info" onclick="viewInquiry(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-eye"></i>';
            $html .= '</button>';
            $html .= '<a href="mailto:' . $row['email'] . '?subject=Re: Travel Inquiry for ' . urlencode($row['destination'] ?? '') . '" class="btn btn-sm btn-outline-primary">';
            $html .= '<i class="fas fa-reply"></i>';
            $html .= '</a>';
            $html .= '<button class="btn btn-sm btn-outline-danger" onclick="deleteInquiry(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-trash"></i>';
            $html .= '</button>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="8" class="text-center py-4">No inquiries found</td></tr>';
    }
    
    return $html;
}

function getDestinationOptions() {
    global $conn;
    
    $sql = "SELECT DISTINCT destination FROM inquiries ORDER BY destination";
    $result = mysqli_query($conn, $sql);
    $options = '';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . htmlspecialchars($row['destination']) . '">' . htmlspecialchars($row['destination']) . '</option>';
    }
    
    return $options;
}

function getInquiryStats() {
    global $conn;
    
    $stats = ['total' => 0, 'unread' => 0, 'read' => 0, 'replied' => 0, 'today' => 0];
    
    // Total
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM inquiries");
    $stats['total'] = mysqli_fetch_assoc($result)['count'];
    
    // Unread
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM inquiries WHERE status = 'unread'");
    $stats['unread'] = mysqli_fetch_assoc($result)['count'];
    
    // Read
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM inquiries WHERE status = 'read'");
    $stats['read'] = mysqli_fetch_assoc($result)['count'];
    
    // Replied
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM inquiries WHERE status = 'replied'");
    $stats['replied'] = mysqli_fetch_assoc($result)['count'];
    
    // Today
    $today = date('Y-m-d');
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM inquiries WHERE DATE(created_at) = '$today'");
    $stats['today'] = mysqli_fetch_assoc($result)['count'];
    
    return $stats;
}

// API endpoint to get inquiry details
function getInquiryDetails($id) {
    global $conn;
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM inquiries WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $row['total_travelers'] = $row['adults'] + $row['children'];
        $row['success'] = true;
        return json_encode($row);
    }
    
    return json_encode(['success' => false, 'error' => 'Inquiry not found']);
}
?>