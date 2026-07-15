<?php
session_start();
include "db-conn.php";
include "functions.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $type = $_POST['type'];
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $price = (float)$_POST['price'];
    $price_note = mysqli_real_escape_string($conn, $_POST['price_note']);
    $suitable_for = mysqli_real_escape_string($conn, $_POST['suitable_for']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $border_color = $_POST['border_color'];
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../uploads/packages/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $target_file = $target_dir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = 'uploads/packages/' . $filename;
        }
    }
    
    // Insert package
    $sql = "INSERT INTO packages (title, slug, type, duration, price, price_note, suitable_for, short_description, image, border_color, featured) 
            VALUES ('$title', '$slug', '$type', '$duration', $price, '$price_note', '$suitable_for', '$short_description', '$image', '$border_color', $featured)";
    
    if (mysqli_query($conn, $sql)) {
        $package_id = mysqli_insert_id($conn);
        
        // Insert highlights
        if (!empty($_POST['highlights'])) {
            foreach ($_POST['highlights'] as $index => $highlight) {
                if (!empty($highlight)) {
                    $highlight = mysqli_real_escape_string($conn, $highlight);
                    mysqli_query($conn, "INSERT INTO package_highlights (package_id, highlight, display_order) VALUES ($package_id, '$highlight', $index)");
                }
            }
        }
        
        // Insert inclusions
        if (!empty($_POST['inclusions'])) {
            foreach ($_POST['inclusions'] as $index => $inclusion) {
                if (!empty($inclusion)) {
                    $inclusion = mysqli_real_escape_string($conn, $inclusion);
                    mysqli_query($conn, "INSERT INTO package_inclusions (package_id, inclusion, display_order) VALUES ($package_id, '$inclusion', $index)");
                }
            }
        }
        
        // Insert itinerary
        if (!empty($_POST['itinerary_day']) && !empty($_POST['itinerary_title']) && !empty($_POST['itinerary_desc'])) {
            foreach ($_POST['itinerary_day'] as $index => $day) {
                if (!empty($day) && !empty($_POST['itinerary_title'][$index]) && !empty($_POST['itinerary_desc'][$index])) {
                    $day = (int)$day;
                    $title = mysqli_real_escape_string($conn, $_POST['itinerary_title'][$index]);
                    $desc = mysqli_real_escape_string($conn, $_POST['itinerary_desc'][$index]);
                    mysqli_query($conn, "INSERT INTO package_itinerary (package_id, day_number, title, description, display_order) VALUES ($package_id, $day, '$title', '$desc', $index)");
                }
            }
        }
        
        // Insert notes
        if (!empty($_POST['notes'])) {
            foreach ($_POST['notes'] as $index => $note) {
                if (!empty($note)) {
                    $note = mysqli_real_escape_string($conn, $note);
                    mysqli_query($conn, "INSERT INTO package_notes (package_id, note, display_order) VALUES ($package_id, '$note', $index)");
                }
            }
        }
        
        $_SESSION['success'] = "Package added successfully!";
        header("Location: packages.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Add Package | Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>
    
    <style>
        .dynamic-field {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            position: relative;
        }
        .remove-field {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            color: #dc3545;
        }
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
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

        <div class="main_content_iner">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="card-header bg-white border-0 py-3">
                                <h2 class="mb-0">Add New Package</h2>
                            </div>
                            
                            <div class="white_card_body">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?= $error ?></div>
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data">
                                    <!-- Basic Information -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Basic Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-8">
                                                    <label class="form-label">Package Title *</label>
                                                    <input type="text" name="title" class="form-control" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Type *</label>
                                                    <select name="type" class="form-select" required>
                                                        <option value="domestic">Domestic</option>
                                                        <option value="international">International</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Duration *</label>
                                                    <input type="text" name="duration" class="form-control" placeholder="e.g., 5N/6D" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Price (USD) *</label>
                                                    <input type="number" step="0.01" name="price" class="form-control" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Price Note</label>
                                                    <input type="text" name="price_note" class="form-control" placeholder="e.g., (2 People)">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Suitable For</label>
                                                    <input type="text" name="suitable_for" class="form-control" placeholder="e.g., Family, Couples">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Border Color</label>
                                                    <select name="border_color" class="form-select">
                                                        <option value="green">Green</option>
                                                        <option value="red">Red</option>
                                                        <option value="blue">Blue</option>
                                                        <option value="orange">Orange</option>
                                                        <option value="purple">Purple</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">&nbsp;</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="featured" class="form-check-input" id="featured">
                                                        <label class="form-check-label" for="featured">Featured Package</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Short Description</label>
                                                    <textarea name="short_description" class="form-control" rows="3"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Package Image</label>
                                                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                                                    <img class="preview-image" id="imagePreview" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Highlights -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Highlights</h5>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addField('highlights')">
                                                <i class="fas fa-plus"></i> Add Highlight
                                            </button>
                                        </div>
                                        <div class="card-body" id="highlights-container">
                                            <div class="dynamic-field">
                                                <input type="text" name="highlights[]" class="form-control" placeholder="Enter highlight">
                                                <span class="remove-field" onclick="removeField(this)">×</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Inclusions -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Inclusions</h5>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addField('inclusions')">
                                                <i class="fas fa-plus"></i> Add Inclusion
                                            </button>
                                        </div>
                                        <div class="card-body" id="inclusions-container">
                                            <div class="dynamic-field">
                                                <input type="text" name="inclusions[]" class="form-control" placeholder="Enter inclusion">
                                                <span class="remove-field" onclick="removeField(this)">×</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Itinerary -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Itinerary</h5>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addItinerary()">
                                                <i class="fas fa-plus"></i> Add Day
                                            </button>
                                        </div>
                                        <div class="card-body" id="itinerary-container">
                                            <div class="dynamic-field">
                                                <div class="row g-2">
                                                    <div class="col-md-2">
                                                        <input type="number" name="itinerary_day[]" class="form-control" placeholder="Day" min="1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="itinerary_title[]" class="form-control" placeholder="Title">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <textarea name="itinerary_desc[]" class="form-control" rows="2" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <span class="remove-field" onclick="removeField(this)">×</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Important Notes</h5>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addField('notes')">
                                                <i class="fas fa-plus"></i> Add Note
                                            </button>
                                        </div>
                                        <div class="card-body" id="notes-container">
                                            <div class="dynamic-field">
                                                <textarea name="notes[]" class="form-control" rows="2" placeholder="Enter note"></textarea>
                                                <span class="remove-field" onclick="removeField(this)">×</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <a href="packages.php" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Save Package</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>
    </section>

    <script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addField(containerId) {
        const container = document.getElementById(containerId + '-container');
        const field = container.querySelector('.dynamic-field').cloneNode(true);
        
        // Clear input values
        field.querySelectorAll('input, textarea').forEach(input => {
            input.value = '';
        });
        
        container.appendChild(field);
    }

    function addItinerary() {
        const container = document.getElementById('itinerary-container');
        const field = container.querySelector('.dynamic-field').cloneNode(true);
        
        // Clear input values
        field.querySelectorAll('input, textarea').forEach(input => {
            input.value = '';
        });
        
        container.appendChild(field);
    }

    function removeField(element) {
        const container = element.closest('.dynamic-field');
        const parentContainer = container.parentNode;
        
        // Don't remove if it's the last field
        if (parentContainer.children.length > 1) {
            container.remove();
        } else {
            // Just clear the values
            container.querySelectorAll('input, textarea').forEach(input => {
                input.value = '';
            });
        }
    }
    </script>
</body>

</html>