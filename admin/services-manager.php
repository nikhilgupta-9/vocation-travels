<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "db-conn.php";
include_once "functions.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: auth/login.php");
    exit();
}

$success_message = '';
$error_message = '';

// Handle status toggle
if (isset($_GET['toggle_status']) && !empty($_GET['slug'])) {
    $slug = trim($_GET['slug']);
    $stmt = $conn->prepare("UPDATE services_cms SET status = IF(status='active', 'inactive', 'active') WHERE slug = ?");
    if ($stmt) {
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->close();
        header("Location: services-manager.php?msg=status_updated");
        exit();
    }
}

if (isset($_GET['msg']) && $_GET['msg'] === 'status_updated') {
    $success_message = "Service status toggled successfully!";
}

// Fetch all services from DB
$services = [];
$res = $conn->query("SELECT * FROM services_cms ORDER BY category ASC, id ASC");
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $services[] = $r;
    }
}

// Stats
$total_count = count($services);
$core_count = 0;
$spec_count = 0;
$active_count = 0;
$total_views = 0;
$total_inquiries = 0;
$total_seo = 0;

foreach ($services as $s) {
    if ($s['category'] === 'core') $core_count++;
    else $spec_count++;
    if ($s['status'] === 'active') $active_count++;
    $total_views += (int)$s['views_count'];
    $total_inquiries += (int)$s['inquiries_count'];
    $total_seo += (int)$s['seo_score'];
}
$avg_seo = $total_count > 0 ? round($total_seo / $total_count) : 90;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Services CMS Manager (65 Services) | Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>

    <style>
        .service-row:hover {
            background-color: #f8fafc;
        }
        .icon-circle {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 16px;
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

                <!-- Alert Messages -->
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($success_message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Top Header -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1 fw-bold text-dark">
                            <i class="fas fa-concierge-bell text-primary me-2"></i>Services CMS Manager
                        </h2>
                        <p class="text-muted mb-0">Manage content, images, FAQs and Yoast SEO for all 65 crawlable service pages</p>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <a href="<?= $site ?>services/" target="_blank" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> View Live Hub
                        </a>
                        <a href="seo-health.php" class="btn btn-success btn-sm">
                            <i class="fas fa-chart-line me-1"></i> Yoast SEO Health
                        </a>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="row g-3 mb-4">
                    <div class="col-md-2 col-sm-4 col-6">
                        <div class="white_card p-3 shadow-sm text-center">
                            <span class="text-muted small">Total Services</span>
                            <h3 class="fw-bold mb-0 text-primary"><?= $total_count ?></h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <div class="white_card p-3 shadow-sm text-center">
                            <span class="text-muted small">Active Services</span>
                            <h3 class="fw-bold mb-0 text-success"><?= $active_count ?></h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <div class="white_card p-3 shadow-sm text-center">
                            <span class="text-muted small">Core Services</span>
                            <h3 class="fw-bold mb-0 text-info"><?= $core_count ?></h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <div class="white_card p-3 shadow-sm text-center">
                            <span class="text-muted small">Specialized</span>
                            <h3 class="fw-bold mb-0 text-dark"><?= $spec_count ?></h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <div class="white_card p-3 shadow-sm text-center">
                            <span class="text-muted small">Total Page Views</span>
                            <h3 class="fw-bold mb-0 text-warning"><?= $total_views ?></h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-6">
                        <div class="white_card p-3 shadow-sm text-center">
                            <span class="text-muted small">Avg SEO Score</span>
                            <h3 class="fw-bold mb-0 text-success"><?= $avg_seo ?>%</h3>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="white_card mb_30 p-4 shadow-sm">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" id="serviceSearchInput" class="form-control border-start-0" 
                                       placeholder="Search services by name, keyword, or slug..." oninput="filterServices()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="categoryFilter" class="form-select" onchange="filterServices()">
                                <option value="all">All Categories</option>
                                <option value="core">Core Services (14)</option>
                                <option value="specialized">Specialized Services (51)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="statusFilter" class="form-select" onchange="filterServices()">
                                <option value="all">All Status</option>
                                <option value="active">Active Only</option>
                                <option value="inactive">Inactive Only</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="text-muted small" id="resultCount">Showing <?= $total_count ?> services</span>
                        </div>
                    </div>

                    <!-- Services Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="servicesTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="32%">Service Name & URL</th>
                                    <th width="12%">Category</th>
                                    <th width="10%">Views</th>
                                    <th width="10%">Inquiries</th>
                                    <th width="12%">Yoast SEO</th>
                                    <th width="10%">Status</th>
                                    <th width="14%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $s): ?>
                                    <?php 
                                        $sc = (int)$s['seo_score'];
                                        $badge_cls = $sc >= 85 ? 'bg-success' : ($sc >= 65 ? 'bg-warning text-dark' : 'bg-danger');
                                    ?>
                                    <tr class="service-row" 
                                        data-name="<?= htmlspecialchars(strtolower($s['name'])) ?>"
                                        data-slug="<?= htmlspecialchars(strtolower($s['slug'])) ?>"
                                        data-category="<?= htmlspecialchars($s['category']) ?>"
                                        data-status="<?= htmlspecialchars($s['status']) ?>">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="icon-circle">
                                                    <i class="<?= htmlspecialchars($s['icon'] ?: 'fa-solid fa-plane-departure') ?>"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($s['name']) ?></div>
                                                    <code class="small text-muted">/services/<?= htmlspecialchars($s['slug']) ?>/</code>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $s['category'] === 'core' ? 'info' : 'secondary' ?>-subtle text-<?= $s['category'] === 'core' ? 'info' : 'secondary' ?> fw-semibold">
                                                <?= ucfirst($s['category']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted"><i class="fas fa-eye me-1"></i><?= $s['views_count'] ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-primary"><i class="fas fa-envelope me-1"></i><?= $s['inquiries_count'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badge_cls ?> px-2.5 py-1 fw-bold">
                                                <i class="fas fa-circle me-1" style="font-size: 7px;"></i> <?= $sc ?>/100
                                            </span>
                                        </td>
                                        <td>
                                            <a href="services-manager.php?toggle_status=1&slug=<?= urlencode($s['slug']) ?>" 
                                               class="badge <?= $s['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?> text-decoration-none"
                                               title="Click to toggle status">
                                                <?= ucfirst($s['status']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="edit-service.php?slug=<?= urlencode($s['slug']) ?>" class="btn btn-sm btn-outline-primary" title="Edit Content & SEO">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <a href="<?= $site ?>services/<?= urlencode($s['slug']) ?>/" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Public Page">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <?php include "footer.php"; ?>
    </section>

    <script>
        function filterServices() {
            const query = document.getElementById('serviceSearchInput').value.toLowerCase().trim();
            const cat = document.getElementById('categoryFilter').value;
            const status = document.getElementById('statusFilter').value;

            const rows = document.querySelectorAll('.service-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const slug = row.getAttribute('data-slug');
                const rowCat = row.getAttribute('data-category');
                const rowStatus = row.getAttribute('data-status');

                const matchesQuery = !query || name.includes(query) || slug.includes(query);
                const matchesCat = (cat === 'all') || (rowCat === cat);
                const matchesStatus = (status === 'all') || (rowStatus === status);

                if (matchesQuery && matchesCat && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('resultCount').textContent = `Showing ${visibleCount} services`;
        }
    </script>
</body>
</html>
