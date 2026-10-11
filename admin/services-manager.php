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

// Handle status toggle while preserving active pagination/filter parameters
if (isset($_GET['toggle_status']) && !empty($_GET['slug'])) {
    $slug = trim($_GET['slug']);
    $stmt = $conn->prepare("UPDATE services_cms SET status = IF(status='active', 'inactive', 'active') WHERE slug = ?");
    if ($stmt) {
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->close();

        // Preserve current GET parameters
        $redirect_params = $_GET;
        unset($redirect_params['toggle_status'], $redirect_params['slug']);
        $redirect_params['msg'] = 'status_updated';
        header("Location: services-manager.php?" . http_build_query($redirect_params));
        exit();
    }
}

if (isset($_GET['msg']) && $_GET['msg'] === 'status_updated') {
    $success_message = "Service status toggled successfully!";
}

// Global Stats (Independent of current filter/page)
$stats_res = $conn->query("SELECT 
    COUNT(*) as total_count,
    SUM(status = 'active') as active_count,
    SUM(category = 'core') as core_count,
    SUM(category = 'specialized') as spec_count,
    SUM(views_count) as total_views,
    SUM(inquiries_count) as total_inquiries,
    AVG(seo_score) as avg_seo
FROM services_cms");

$stats = $stats_res ? $stats_res->fetch_assoc() : [];
$total_count = (int)($stats['total_count'] ?? 65);
$active_count = (int)($stats['active_count'] ?? 0);
$core_count = (int)($stats['core_count'] ?? 14);
$spec_count = (int)($stats['spec_count'] ?? 51);
$total_views = (int)($stats['total_views'] ?? 0);
$total_inquiries = (int)($stats['total_inquiries'] ?? 0);
$avg_seo = round((float)($stats['avg_seo'] ?? 92));

// Filter & Pagination Parameters
$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? 'all');
$status = trim($_GET['status'] ?? 'all');
$sort = trim($_GET['sort'] ?? 'default');

$per_page_raw = $_GET['per_page'] ?? '15';
if ($per_page_raw === 'all') {
    $per_page = 9999;
} else {
    $per_page = (int)$per_page_raw;
    if (!in_array($per_page, [10, 15, 25, 50])) {
        $per_page = 15;
    }
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

// Build Dynamic SQL Query with Prepared Statements
$where = ["1=1"];
$params = [];
$types = "";

if (!empty($search)) {
    $where[] = "(name LIKE ? OR slug LIKE ? OR focus_keyword LIKE ? OR meta_title LIKE ?)";
    $like = '%' . $search . '%';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= "ssss";
}

if ($category === 'core' || $category === 'specialized') {
    $where[] = "category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($status === 'active' || $status === 'inactive') {
    $where[] = "status = ?";
    $params[] = $status;
    $types .= "s";
}

$where_clause = implode(" AND ", $where);

// Sorting
$order_clause = "category ASC, id ASC";
if ($sort === 'name_asc') $order_clause = "name ASC";
elseif ($sort === 'name_desc') $order_clause = "name DESC";
elseif ($sort === 'views_desc') $order_clause = "views_count DESC, id ASC";
elseif ($sort === 'inquiries_desc') $order_clause = "inquiries_count DESC, id ASC";
elseif ($sort === 'seo_desc') $order_clause = "seo_score DESC, id ASC";
elseif ($sort === 'seo_asc') $order_clause = "seo_score ASC, id ASC";

// Get filtered total rows
$count_query = "SELECT COUNT(*) as total FROM services_cms WHERE $where_clause";
$count_stmt = $conn->prepare($count_query);
if (!empty($types)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$total_filtered = (int)$count_stmt->get_result()->fetch_assoc()['total'];
$count_stmt->close();

// Pagination Math
$total_pages = max(1, (int)ceil($total_filtered / $per_page));
if ($page > $total_pages) {
    $page = $total_pages;
}
$offset = ($page - 1) * $per_page;

// Fetch current page data
$data_query = "SELECT * FROM services_cms WHERE $where_clause ORDER BY $order_clause LIMIT ?, ?";
$data_stmt = $conn->prepare($data_query);
$limit_types = $types . "ii";
$limit_params = array_merge($params, [$offset, $per_page]);
$data_stmt->bind_param($limit_types, ...$limit_params);
$data_stmt->execute();
$res = $data_stmt->get_result();

$services = [];
while ($row = $res->fetch_assoc()) {
    $services[] = $row;
}
$data_stmt->close();

// Helper function to build pagination URLs preserving all active filters
if (!function_exists('pagination_url')) {
    function pagination_url($target_page) {
        $params = $_GET;
        $params['page'] = $target_page;
        return 'services-manager.php?' . http_build_query($params);
    }
}

$has_active_filters = (!empty($search) || $category !== 'all' || $status !== 'all' || $sort !== 'default' || $per_page_raw !== '15');
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
        /* Custom Pagination Styling */
        .pagination {
            gap: 4px;
        }
        .pagination .page-link {
            color: #475569;
            border-radius: 8px !important;
            border: 1px solid #e2e8f0;
            padding: 7px 13px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s ease;
        }
        .pagination .page-link:hover {
            background-color: #f1f5f9;
            color: #1e293b;
            border-color: #cbd5e1;
        }
        .pagination .page-item.active .page-link {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }
        .pagination .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }
        .filter-chip {
            background: #f1f5f9;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
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
                        <p class="text-muted mb-0">Manage content, images, FAQs and Yoast SEO across all 65 crawlable service pages</p>
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

                <!-- Global Stats Overview -->
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

                <!-- Main Card with Filters and Paginated Table -->
                <div class="white_card mb_30 p-4 shadow-sm">

                    <!-- Filter Form -->
                    <form method="GET" action="services-manager.php" id="filterForm">
                        <div class="row g-3 align-items-center mb-3">
                            <!-- Search Field -->
                            <div class="col-lg-4 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" 
                                           placeholder="Search by name, slug or keyword..." 
                                           value="<?= htmlspecialchars($search) ?>">
                                    <?php if (!empty($search)): ?>
                                        <a href="services-manager.php" class="btn btn-outline-secondary border-start-0" title="Clear search">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="col-lg-2 col-md-3 col-6">
                                <select name="category" class="form-select" onchange="this.form.submit()">
                                    <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>All Categories</option>
                                    <option value="core" <?= $category === 'core' ? 'selected' : '' ?>>Core Services (<?= $core_count ?>)</option>
                                    <option value="specialized" <?= $category === 'specialized' ? 'selected' : '' ?>>Specialized (<?= $spec_count ?>)</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-lg-2 col-md-3 col-6">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>All Status</option>
                                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active Only</option>
                                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive Only</option>
                                </select>
                            </div>

                            <!-- Sort Filter -->
                            <div class="col-lg-2 col-md-4 col-6">
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>>Sort: Default</option>
                                    <option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Name: A to Z</option>
                                    <option value="name_desc" <?= $sort === 'name_desc' ? 'selected' : '' ?>>Name: Z to A</option>
                                    <option value="views_desc" <?= $sort === 'views_desc' ? 'selected' : '' ?>>Most Views</option>
                                    <option value="inquiries_desc" <?= $sort === 'inquiries_desc' ? 'selected' : '' ?>>Most Inquiries</option>
                                    <option value="seo_desc" <?= $sort === 'seo_desc' ? 'selected' : '' ?>>Highest SEO Score</option>
                                    <option value="seo_asc" <?= $sort === 'seo_asc' ? 'selected' : '' ?>>Lowest SEO Score</option>
                                </select>
                            </div>

                            <!-- Items Per Page -->
                            <div class="col-lg-2 col-md-4 col-6">
                                <select name="per_page" class="form-select" onchange="this.form.submit()">
                                    <option value="10" <?= $per_page_raw === '10' ? 'selected' : '' ?>>10 per page</option>
                                    <option value="15" <?= $per_page_raw === '15' ? 'selected' : '' ?>>15 per page</option>
                                    <option value="25" <?= $per_page_raw === '25' ? 'selected' : '' ?>>25 per page</option>
                                    <option value="50" <?= $per_page_raw === '50' ? 'selected' : '' ?>>50 per page</option>
                                    <option value="all" <?= $per_page_raw === 'all' ? 'selected' : '' ?>>Show All (65)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Active Filter Summary & Clear All button -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pt-2 border-top">
                            <div class="small text-muted">
                                Showing <strong><?= $total_filtered > 0 ? ($offset + 1) : 0 ?></strong> to 
                                <strong><?= min($offset + $per_page, $total_filtered) ?></strong> of 
                                <strong><?= $total_filtered ?></strong> services
                                <?php if ($total_filtered !== $total_count): ?>
                                    <span class="text-secondary">(filtered from <?= $total_count ?> total)</span>
                                <?php endif; ?>
                            </div>

                            <?php if ($has_active_filters): ?>
                                <div>
                                    <a href="services-manager.php" class="btn btn-outline-danger btn-sm py-1">
                                        <i class="fas fa-undo me-1"></i> Reset All Filters
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>

                    <!-- Services Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="servicesTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="32%">Service Name & URL</th>
                                    <th width="12%">Category</th>
                                    <th width="10%">Views</th>
                                    <th width="10%">Inquiries</th>
                                    <th width="11%">Yoast SEO</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($services)): ?>
                                    <?php $row_num = $offset + 1; ?>
                                    <?php foreach ($services as $s): ?>
                                        <?php 
                                            $sc = (int)$s['seo_score'];
                                            $badge_cls = $sc >= 85 ? 'bg-success' : ($sc >= 65 ? 'bg-warning text-dark' : 'bg-danger');
                                            $toggle_params = $_GET;
                                            $toggle_params['toggle_status'] = 1;
                                            $toggle_params['slug'] = $s['slug'];
                                            $toggle_url = 'services-manager.php?' . http_build_query($toggle_params);
                                        ?>
                                        <tr class="service-row">
                                            <td class="text-muted small fw-semibold"><?= $row_num++ ?></td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="icon-circle shadow-sm">
                                                        <i class="<?= htmlspecialchars($s['icon'] ?: 'fa-solid fa-plane-departure') ?>"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">
                                                            <a href="edit-service.php?slug=<?= urlencode($s['slug']) ?>" class="text-dark text-decoration-none hover-primary">
                                                                <?= htmlspecialchars($s['name']) ?>
                                                            </a>
                                                        </div>
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
                                                <span class="text-muted"><i class="fas fa-eye me-1 text-secondary"></i><?= $s['views_count'] ?></span>
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
                                                <a href="<?= htmlspecialchars($toggle_url) ?>" 
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
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-search fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                                                <h5>No services matched your filter</h5>
                                                <p class="small">Try adjusting your search query or reset all filters.</p>
                                                <a href="services-manager.php" class="btn btn-primary btn-sm mt-2">
                                                    Reset Filters
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Navigation Controls -->
                    <?php if ($total_pages > 1 && $per_page_raw !== 'all'): ?>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-muted small mb-2 mb-md-0">
                                Page <strong><?= $page ?></strong> of <strong><?= $total_pages ?></strong> 
                                (<?= $total_filtered ?> total services)
                            </div>

                            <nav aria-label="Services Pagination">
                                <ul class="pagination mb-0">
                                    <!-- First Page -->
                                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= pagination_url(1) ?>" aria-label="First" title="First Page">
                                            <i class="fas fa-angle-double-left"></i>
                                        </a>
                                    </li>

                                    <!-- Previous Page -->
                                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= pagination_url($page - 1) ?>" aria-label="Previous">
                                            <i class="fas fa-angle-left me-1"></i> Prev
                                        </a>
                                    </li>

                                    <?php
                                    // Window of pagination links
                                    $range = 2; // numbers on each side of current
                                    $start_page = max(1, $page - $range);
                                    $end_page = min($total_pages, $page + $range);

                                    if ($start_page > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="' . pagination_url(1) . '">1</a></li>';
                                        if ($start_page > 2) {
                                            echo '<li class="page-item disabled"><span class="page-link border-0">...</span></li>';
                                        }
                                    }

                                    for ($i = $start_page; $i <= $end_page; $i++):
                                    ?>
                                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= pagination_url($i) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php
                                    if ($end_page < $total_pages) {
                                        if ($end_page < $total_pages - 1) {
                                            echo '<li class="page-item disabled"><span class="page-link border-0">...</span></li>';
                                        }
                                        echo '<li class="page-item"><a class="page-link" href="' . pagination_url($total_pages) . '">' . $total_pages . '</a></li>';
                                    }
                                    ?>

                                    <!-- Next Page -->
                                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= pagination_url($page + 1) ?>" aria-label="Next">
                                            Next <i class="fas fa-angle-right ms-1"></i>
                                        </a>
                                    </li>

                                    <!-- Last Page -->
                                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= pagination_url($total_pages) ?>" aria-label="Last" title="Last Page">
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <?php include "footer.php"; ?>
    </section>
</body>
</html>
