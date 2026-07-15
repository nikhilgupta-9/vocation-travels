<?php
session_start();
include "db-conn.php";
include "functions.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM packages WHERE id = $id");
    $_SESSION['success'] = "Package deleted successfully!";
    header("Location: packages.php");
    exit();
}

// Toggle status
if (isset($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    mysqli_query($conn, "UPDATE packages SET status = !status WHERE id = $id");
    header("Location: packages.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Tour Packages | Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>
    
    <style>
        .package-card {
            transition: all 0.3s ease;
        }
        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .border-green { border-bottom: 5px solid #10b981; }
        .border-red { border-bottom: 5px solid #ef4444; }
        .border-blue { border-bottom: 5px solid #3b82f6; }
        .border-orange { border-bottom: 5px solid #f97316; }
        .border-purple { border-bottom: 5px solid #a855f7; }
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
                                    <h2 class="mb-1 fw-bold">Tour Packages</h2>
                                    <p class="text-muted mb-0">Manage domestic and international tour packages</p>
                                </div>
                                <a href="add_package.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add New Package
                                </a>
                            </div>

                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                    <?= $_SESSION['success'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['success']); ?>
                            <?php endif; ?>

                            <!-- Stats Cards -->
                            <div class="card-body border-bottom">
                                <div class="row g-3">
                                    <?php
                                    $domestic = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE type='domestic'"));
                                    $international = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE type='international'"));
                                    $active = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE status=1"));
                                    ?>
                                    <div class="col-md-3">
                                        <div class="bg-light p-3 rounded">
                                            <h6 class="text-muted mb-1">Total Packages</h6>
                                            <h3 class="mb-0"><?= $domestic['count'] + $international['count'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-success bg-opacity-10 p-3 rounded">
                                            <h6 class="text-muted mb-1">Domestic</h6>
                                            <h3 class="mb-0 text-success"><?= $domestic['count'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-info bg-opacity-10 p-3 rounded">
                                            <h6 class="text-muted mb-1">International</h6>
                                            <h3 class="mb-0 text-light"><?= $international['count'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                                            <h6 class="text-muted mb-1">Active</h6>
                                            <h3 class="mb-0 text-light"><?= $active['count'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search and Filter -->
                            <div class="card-header bg-light border-0 py-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="searchPackages" placeholder="Search packages...">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" id="typeFilter">
                                            <option value="all">All Types</option>
                                            <option value="domestic">Domestic</option>
                                            <option value="international">International</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" id="statusFilter">
                                            <option value="all">All Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-secondary w-100" onclick="clearFilters()">Clear</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Packages Table -->
                            <div class="white_card_body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="packagesTable">
                                        <thead class="bg-light text-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Duration</th>
                                                <th>Price (USD)</th>
                                                <th>Status</th>
                                                <th>Featured</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
                                            while ($row = mysqli_fetch_assoc($result)):
                                            ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td>
                                                    <?php if ($row['image']): ?>
                                                        <img src="../<?= $row['image'] ?>" alt="<?= $row['title'] ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                                    <?php else: ?>
                                                        <span class="text-muted">No image</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($row['title']) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $row['type'] == 'domestic' ? 'success' : 'info' ?>">
                                                        <?= ucfirst($row['type']) ?>
                                                    </span>
                                                </td>
                                                <td><?= $row['duration'] ?></td>
                                                <td>$<?= number_format($row['price'], 2) ?></td>
                                                <td>
                                                    <a href="?toggle_status=<?= $row['id'] ?>" class="text-decoration-none">
                                                        <span class="badge bg-<?= $row['status'] ? 'success' : 'secondary' ?>">
                                                            <?= $row['status'] ? 'Active' : 'Inactive' ?>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $row['featured'] ? 'warning' : 'light' ?>">
                                                        <?= $row['featured'] ? 'Featured' : 'Regular' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="edit_package.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" onclick="viewPackage(<?= $row['id'] ?>)" class="btn btn-sm btn-outline-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this package?')" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
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

    <!-- View Package Modal -->
    <div class="modal fade" id="viewPackageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Package Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="packageDetails">
                    <!-- Load via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary" id="editPackageBtn">Edit Package</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    function filterTable() {
        const search = document.getElementById('searchPackages').value.toLowerCase();
        const type = document.getElementById('typeFilter').value;
        const status = document.getElementById('statusFilter').value;
        
        const rows = document.querySelectorAll('#packagesTable tbody tr');
        
        rows.forEach(row => {
            let show = true;
            const title = row.cells[2].textContent.toLowerCase();
            const rowType = row.cells[3].querySelector('span').textContent.toLowerCase();
            const rowStatus = row.cells[6].querySelector('span').textContent.toLowerCase();
            
            if (search && !title.includes(search)) show = false;
            if (type !== 'all' && rowType !== type) show = false;
            if (status !== 'all') {
                const statusText = status === '1' ? 'active' : 'inactive';
                if (rowStatus !== statusText) show = false;
            }
            
            row.style.display = show ? '' : 'none';
        });
    }

    function clearFilters() {
        document.getElementById('searchPackages').value = '';
        document.getElementById('typeFilter').value = 'all';
        document.getElementById('statusFilter').value = 'all';
        filterTable();
    }

    function viewPackage(id) {
        fetch('get_package_details.php?id=' + id)
            .then(response => response.text())
            .then(html => {
                document.getElementById('packageDetails').innerHTML = html;
                document.getElementById('editPackageBtn').href = 'edit_package.php?id=' + id;
                new bootstrap.Modal(document.getElementById('viewPackageModal')).show();
            });
    }

    document.getElementById('searchPackages').addEventListener('keyup', filterTable);
    document.getElementById('typeFilter').addEventListener('change', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    </script>
</body>

</html>