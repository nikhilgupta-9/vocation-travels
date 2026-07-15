<?php
session_start();
include "db-conn.php";
include "functions.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Get package ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch package details
$package_query = "SELECT * FROM packages WHERE id = $id";
$package_result = mysqli_query($conn, $package_query);

if (mysqli_num_rows($package_result) == 0) {
    $_SESSION['error'] = "Package not found!";
    header("Location: packages.php");
    exit();
}

$package = mysqli_fetch_assoc($package_result);

// Fetch related data
$highlights = mysqli_query($conn, "SELECT * FROM package_highlights WHERE package_id = $id ORDER BY display_order");
$inclusions = mysqli_query($conn, "SELECT * FROM package_inclusions WHERE package_id = $id ORDER BY display_order");
$itinerary = mysqli_query($conn, "SELECT * FROM package_itinerary WHERE package_id = $id ORDER BY display_order");
$notes = mysqli_query($conn, "SELECT * FROM package_notes WHERE package_id = $id ORDER BY display_order");

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
    $status = isset($_POST['status']) ? 1 : 0;
    
    // Handle image upload
    $image = $package['image']; // Keep existing image by default
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../uploads/packages/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $target_file = $target_dir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Delete old image if exists
            if (!empty($package['image']) && file_exists("../" . $package['image'])) {
                unlink("../" . $package['image']);
            }
            $image = 'uploads/packages/' . $filename;
        }
    }
    
    // Update package
    $sql = "UPDATE packages SET 
            title = '$title',
            slug = '$slug',
            type = '$type',
            duration = '$duration',
            price = $price,
            price_note = '$price_note',
            suitable_for = '$suitable_for',
            short_description = '$short_description',
            image = '$image',
            border_color = '$border_color',
            featured = $featured,
            status = $status
            WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        // Delete existing related data
        mysqli_query($conn, "DELETE FROM package_highlights WHERE package_id = $id");
        mysqli_query($conn, "DELETE FROM package_inclusions WHERE package_id = $id");
        mysqli_query($conn, "DELETE FROM package_itinerary WHERE package_id = $id");
        mysqli_query($conn, "DELETE FROM package_notes WHERE package_id = $id");
        
        // Insert highlights
        if (!empty($_POST['highlights'])) {
            foreach ($_POST['highlights'] as $index => $highlight) {
                if (!empty(trim($highlight))) {
                    $highlight = mysqli_real_escape_string($conn, trim($highlight));
                    mysqli_query($conn, "INSERT INTO package_highlights (package_id, highlight, display_order) VALUES ($id, '$highlight', $index)");
                }
            }
        }
        
        // Insert inclusions
        if (!empty($_POST['inclusions'])) {
            foreach ($_POST['inclusions'] as $index => $inclusion) {
                if (!empty(trim($inclusion))) {
                    $inclusion = mysqli_real_escape_string($conn, trim($inclusion));
                    mysqli_query($conn, "INSERT INTO package_inclusions (package_id, inclusion, display_order) VALUES ($id, '$inclusion', $index)");
                }
            }
        }
        
        // Insert itinerary
        if (!empty($_POST['itinerary_day'])) {
            foreach ($_POST['itinerary_day'] as $index => $day) {
                if (!empty($day) && !empty($_POST['itinerary_title'][$index]) && !empty($_POST['itinerary_desc'][$index])) {
                    $day = (int)$day;
                    $title_it = mysqli_real_escape_string($conn, $_POST['itinerary_title'][$index]);
                    $desc = mysqli_real_escape_string($conn, $_POST['itinerary_desc'][$index]);
                    mysqli_query($conn, "INSERT INTO package_itinerary (package_id, day_number, title, description, display_order) VALUES ($id, $day, '$title_it', '$desc', $index)");
                }
            }
        }
        
        // Insert notes
        if (!empty($_POST['notes'])) {
            foreach ($_POST['notes'] as $index => $note) {
                if (!empty(trim($note))) {
                    $note = mysqli_real_escape_string($conn, trim($note));
                    mysqli_query($conn, "INSERT INTO package_notes (package_id, note, display_order) VALUES ($id, '$note', $index)");
                }
            }
        }
        
        $_SESSION['success'] = "Package updated successfully!";
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
    <title>Edit Package | Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>
    
    <style>
        .dynamic-field {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            position: relative;
            border-left: 4px solid #0d6efd;
        }
        .remove-field {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            color: #dc3545;
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .remove-field:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
            border: 2px solid #dee2e6;
            padding: 5px;
        }
        .border-color-preview {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            vertical-align: middle;
        }
        .card-header {
            background: linear-gradient(45deg, #f8f9fa, #ffffff);
        }
        .btn-add {
            border: 2px dashed #0d6efd;
            color: #0d6efd;
            background: white;
            transition: all 0.3s;
        }
        .btn-add:hover {
            background: #0d6efd;
            color: white;
            border: 2px dashed #ffffff;
        }
        .form-section {
            transition: all 0.3s;
        }
        .form-section:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
                            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="mb-1 fw-bold">
                                        <i class="fas fa-edit me-2 text-primary"></i>Edit Package
                                    </h2>
                                    <p class="text-muted mb-0">Update package information and details</p>
                                </div>
                                <a href="packages.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Packages
                                </a>
                            </div>
                            
                            <div class="white_card_body">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i><?= $error ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data" id="editPackageForm">
                                    <!-- Basic Information -->
                                    <div class="card mb-4 form-section">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="fas fa-info-circle me-2 text-primary"></i>Basic Information
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-8">
                                                    <label class="form-label fw-bold">Package Title *</label>
                                                    <input type="text" name="title" class="form-control" 
                                                           value="<?= htmlspecialchars($package['title']) ?>" required>
                                                    <small class="text-muted">This will be displayed on the package card</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Type *</label>
                                                    <select name="type" class="form-select" required>
                                                        <option value="domestic" <?= $package['type'] == 'domestic' ? 'selected' : '' ?>>Domestic</option>
                                                        <option value="international" <?= $package['type'] == 'international' ? 'selected' : '' ?>>International</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">Duration *</label>
                                                    <input type="text" name="duration" class="form-control" 
                                                           value="<?= htmlspecialchars($package['duration']) ?>" 
                                                           placeholder="e.g., 5N/6D" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">Price (USD) *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" step="0.01" name="price" class="form-control" 
                                                               value="<?= $package['price'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">Price Note</label>
                                                    <input type="text" name="price_note" class="form-control" 
                                                           value="<?= htmlspecialchars($package['price_note']) ?>" 
                                                           placeholder="e.g., (2 People)">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">Suitable For</label>
                                                    <input type="text" name="suitable_for" class="form-control" 
                                                           value="<?= htmlspecialchars($package['suitable_for']) ?>" 
                                                           placeholder="e.g., Family, Couples">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Border Color</label>
                                                    <select name="border_color" class="form-select">
                                                        <option value="green" <?= $package['border_color'] == 'green' ? 'selected' : '' ?>>Green</option>
                                                        <option value="red" <?= $package['border_color'] == 'red' ? 'selected' : '' ?>>Red</option>
                                                        <option value="blue" <?= $package['border_color'] == 'blue' ? 'selected' : '' ?>>Blue</option>
                                                        <option value="orange" <?= $package['border_color'] == 'orange' ? 'selected' : '' ?>>Orange</option>
                                                        <option value="purple" <?= $package['border_color'] == 'purple' ? 'selected' : '' ?>>Purple</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">&nbsp;</label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" name="featured" class="form-check-input" 
                                                               id="featured" <?= $package['featured'] ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="featured">Featured Package</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">&nbsp;</label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" name="status" class="form-check-input" 
                                                               id="status" <?= $package['status'] ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="status">Active</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Short Description</label>
                                                    <textarea name="short_description" class="form-control" rows="3"><?= htmlspecialchars($package['short_description']) ?></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Package Image</label>
                                                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                                                    <?php if (!empty($package['image'])): ?>
                                                        <div class="mt-3">
                                                            <p class="mb-2">Current Image:</p>
                                                            <img src="../<?= $package['image'] ?>" class="preview-image" alt="Current">
                                                        </div>
                                                    <?php endif; ?>
                                                    <img class="preview-image" id="imagePreview" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Highlights -->
                                    <div class="card mb-4 form-section">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-star me-2 text-warning"></i>Highlights
                                            </h5>
                                            <button type="button" class="btn btn-sm btn-add" onclick="addField('highlights')">
                                                <i class="fas fa-plus me-2"></i>Add Highlight
                                            </button>
                                        </div>
                                        <div class="card-body" id="highlights-container">
                                            <?php if (mysqli_num_rows($highlights) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($highlights)): ?>
                                                    <div class="dynamic-field">
                                                        <input type="text" name="highlights[]" class="form-control" 
                                                               value="<?= htmlspecialchars($row['highlight']) ?>" 
                                                               placeholder="Enter highlight">
                                                        <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <div class="dynamic-field">
                                                    <input type="text" name="highlights[]" class="form-control" 
                                                           placeholder="Enter highlight">
                                                    <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Inclusions -->
                                    <div class="card mb-4 form-section">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-check-circle me-2 text-success"></i>Inclusions
                                            </h5>
                                            <button type="button" class="btn btn-sm btn-add" onclick="addField('inclusions')">
                                                <i class="fas fa-plus me-2"></i>Add Inclusion
                                            </button>
                                        </div>
                                        <div class="card-body" id="inclusions-container">
                                            <?php if (mysqli_num_rows($inclusions) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($inclusions)): ?>
                                                    <div class="dynamic-field">
                                                        <input type="text" name="inclusions[]" class="form-control" 
                                                               value="<?= htmlspecialchars($row['inclusion']) ?>" 
                                                               placeholder="Enter inclusion">
                                                        <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <div class="dynamic-field">
                                                    <input type="text" name="inclusions[]" class="form-control" 
                                                           placeholder="Enter inclusion">
                                                    <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Itinerary -->
                                    <div class="card mb-4 form-section">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-map-signals me-2 text-info"></i>Itinerary
                                            </h5>
                                            <button type="button" class="btn btn-sm btn-add" onclick="addItinerary()">
                                                <i class="fas fa-plus me-2"></i>Add Day
                                            </button>
                                        </div>
                                        <div class="card-body" id="itinerary-container">
                                            <?php if (mysqli_num_rows($itinerary) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($itinerary)): ?>
                                                    <div class="dynamic-field">
                                                        <div class="row g-2">
                                                            <div class="col-md-2">
                                                                <input type="number" name="itinerary_day[]" class="form-control" 
                                                                       value="<?= $row['day_number'] ?>" placeholder="Day" min="1">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="itinerary_title[]" class="form-control" 
                                                                       value="<?= htmlspecialchars($row['title']) ?>" placeholder="Title">
                                                            </div>
                                                            <div class="col-md-7">
                                                                <textarea name="itinerary_desc[]" class="form-control" rows="2" 
                                                                          placeholder="Description"><?= htmlspecialchars($row['description']) ?></textarea>
                                                            </div>
                                                        </div>
                                                        <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <div class="dynamic-field">
                                                    <div class="row g-2">
                                                        <div class="col-md-2">
                                                            <input type="number" name="itinerary_day[]" class="form-control" 
                                                                   placeholder="Day" min="1">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" name="itinerary_title[]" class="form-control" 
                                                                   placeholder="Title">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <textarea name="itinerary_desc[]" class="form-control" rows="2" 
                                                                      placeholder="Description"></textarea>
                                                        </div>
                                                    </div>
                                                    <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="card mb-4 form-section">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-exclamation-circle me-2 text-danger"></i>Important Notes
                                            </h5>
                                            <button type="button" class="btn btn-sm btn-add" onclick="addField('notes')">
                                                <i class="fas fa-plus me-2"></i>Add Note
                                            </button>
                                        </div>
                                        <div class="card-body" id="notes-container">
                                            <?php if (mysqli_num_rows($notes) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($notes)): ?>
                                                    <div class="dynamic-field">
                                                        <textarea name="notes[]" class="form-control" rows="2" 
                                                                  placeholder="Enter note"><?= htmlspecialchars($row['note']) ?></textarea>
                                                        <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <div class="dynamic-field">
                                                    <textarea name="notes[]" class="form-control" rows="2" 
                                                              placeholder="Enter note"></textarea>
                                                    <span class="remove-field" onclick="removeField(this)" title="Remove">×</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <a href="packages.php" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Update Package
                                        </button>
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
            
            // Hide current image if exists
            const currentImage = document.querySelector('.preview-image:not(#imagePreview)');
            if (currentImage) {
                currentImage.style.display = 'none';
            }
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
            if (confirm('Are you sure you want to remove this item?')) {
                container.remove();
            }
        } else {
            // Just clear the values
            container.querySelectorAll('input, textarea').forEach(input => {
                input.value = '';
            });
            alert('At least one field must remain. Values have been cleared.');
        }
    }

    // Form validation before submit
    document.getElementById('editPackageForm').addEventListener('submit', function(e) {
        const title = document.querySelector('input[name="title"]').value.trim();
        const duration = document.querySelector('input[name="duration"]').value.trim();
        const price = document.querySelector('input[name="price"]').value;
        
        if (!title || !duration || !price) {
            e.preventDefault();
            alert('Please fill in all required fields (Title, Duration, Price)');
        }
    });

    // Auto-generate slug from title (optional feature)
    document.querySelector('input[name="title"]').addEventListener('blur', function() {
        // You can show slug preview if needed
        console.log('Title changed:', this.value);
    });
    </script>
</body>

</html>