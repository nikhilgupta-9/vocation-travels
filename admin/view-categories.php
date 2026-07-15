<?php
session_start();
include "functions.php";
include "db-conn.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM categories WHERE cate_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Category deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete category!";
    }

    $stmt->close();
    header("Location: view-categories.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Category Management | Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">

    <?php include "links.php"; ?>

    <style>
        .category-card {
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .category-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .category-image:hover {
            border-color: #3b82f6;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-inactive {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .search-box {
            position: relative;
            max-width: 400px;
        }

        .search-box .form-control {
            padding-left: 45px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .search-box .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            overflow: hidden;
        }

        .stats-card .card-body {
            padding: 1.5rem;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .filter-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .filter-btn.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #94a3b8;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
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
                            <!-- Header with Search and Filters -->
                            <div class="card-header bg-white border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="mb-1 fw-bold">Category Management</h2>
                                        <p class="text-muted mb-0 small">Manage your product categories efficiently</p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Search Box -->
                                        <div class="search-box me-3">
                                            <i class="fas fa-search search-icon"></i>
                                            <input type="text" class="form-control" id="searchInput"
                                                placeholder="Search categories..." onkeyup="searchCategories()">
                                        </div>

                                        <a href="add-categories.php" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addcategory">
                                            <i class="fas fa-plus me-2"></i>Add New
                                        </a>
                                    </div>
                                </div>

                                <!-- Status Filters -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-muted me-2">Filter by:</span>
                                            <button class="btn btn-outline-secondary filter-btn active"
                                                onclick="filterCategories('all')">
                                                <i class="fas fa-list me-1"></i>All
                                            </button>
                                            <button class="btn btn-outline-success filter-btn"
                                                onclick="filterCategories('active')">
                                                <i class="fas fa-check-circle me-1"></i>Active
                                            </button>
                                            <button class="btn btn-outline-danger filter-btn"
                                                onclick="filterCategories('inactive')">
                                                <i class="fas fa-times-circle me-1"></i>Inactive
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories Table -->
                            <div class="white_card_body">
                                <div class="table-responsive">
                                    <table class="table table-hover lms_table_active" id="categoryTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col" width="25%">Category</th>
                                                <th scope="col" width="20%">Slug URL</th>
                                                <th scope="col" width="15%">Status</th>
                                                <th scope="col" width="15%">Created Date</th>
                                                <th scope="col" width="20%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo get_Category(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h5 class="mb-2">Delete Category</h5>
                        <p class="text-muted">Are you sure you want to delete "<span id="deleteItemName"
                                class="fw-bold"></span>"?</p>
                        <p class="text-danger small">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            This action cannot be undone. All sub-categories and products under this category will be
                            affected.
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Search functionality
        function searchCategories() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let rows = document.querySelectorAll('#categoryTable tbody tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? '' : 'none';
            });
        }

        // Filter functionality
        function filterCategories(status) {
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            let rows = document.querySelectorAll('#categoryTable tbody tr');

            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    let badge = row.querySelector('.status-badge');
                    if (badge) {
                        let rowStatus = badge.textContent.toLowerCase();
                        row.style.display = rowStatus.includes(status) ? '' : 'none';
                    }
                }
            });
        }

        // Delete modal functionality
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deleteModal');

            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const itemId = button.getAttribute('data-id');
                    const itemName = button.getAttribute('data-name');

                    document.getElementById('deleteItemName').textContent = itemName;
                    document.getElementById('confirmDeleteBtn').href = 'view-categories.php?id=' + itemId;
                });
            }

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Show success/error messages
            <?php if (isset($_SESSION['success'])): ?>
                showNotification('success', '<?php echo $_SESSION["success"]; ?>');
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                showNotification('error', '<?php echo $_SESSION["error"]; ?>');
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        });

        function showNotification(type, message) {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    </script>
</body>

</html>