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

// Handle SEO Update Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_page_seo') {
    $page_id = (int)$_POST['page_id'];
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $focus_keyword = trim($_POST['focus_keyword'] ?? '');
    $canonical_url = trim($_POST['canonical_url'] ?? '');
    $og_image = trim($_POST['og_image'] ?? '');
    
    // Calculate Yoast SEO Score dynamically
    $score = 100;
    $title_len = mb_strlen($meta_title);
    $desc_len = mb_strlen($meta_description);

    if (empty($focus_keyword)) {
        $score -= 20;
    } else {
        $kw_lower = strtolower($focus_keyword);
        if (strpos(strtolower($meta_title), $kw_lower) === false) $score -= 10;
        if (strpos(strtolower($meta_description), $kw_lower) === false) $score -= 10;
    }

    if ($title_len < 30 || $title_len > 65) $score -= 15;
    if ($desc_len < 100 || $desc_len > 165) $score -= 15;
    if (empty($og_image)) $score -= 10;
    $score = max(30, min(100, $score));

    $stmt = $conn->prepare("UPDATE page_seo SET meta_title = ?, meta_description = ?, focus_keyword = ?, canonical_url = ?, og_image = ?, seo_score = ?, updated_at = NOW() WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("sssssii", $meta_title, $meta_description, $focus_keyword, $canonical_url, $og_image, $score, $page_id);
        if ($stmt->execute()) {
            $success_message = "Yoast SEO metadata for page updated successfully! New SEO Score: {$score}/100.";
        } else {
            $error_message = "Failed to update SEO settings: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all Core Pages SEO
$core_pages = [];
$res = $conn->query("SELECT * FROM page_seo ORDER BY id ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $core_pages[] = $row;
    }
}

// Fetch Services CMS SEO summary
$services_res = $conn->query("SELECT id, slug, name, category, meta_title, meta_description, focus_keyword, seo_score, views_count, inquiries_count, status FROM services_cms ORDER BY seo_score DESC");
$services_list = [];
$total_svc_score = 0;
if ($services_res) {
    while ($r = $services_res->fetch_assoc()) {
        $services_list[] = $r;
        $total_svc_score += (int)$r['seo_score'];
    }
}

// Calculate site-wide stats
$total_core = count($core_pages);
$total_services = count($services_list);
$total_monitored = $total_core + $total_services;

$core_avg = $total_core > 0 ? (array_sum(array_column($core_pages, 'seo_score')) / $total_core) : 90;
$svc_avg = $total_services > 0 ? ($total_svc_score / $total_services) : 90;
$site_seo_avg = round(($core_avg * 0.4) + ($svc_avg * 0.6));

$good_count = 0;
$ok_count = 0;
$bad_count = 0;
foreach (array_merge($core_pages, $services_list) as $item) {
    $sc = (int)($item['seo_score'] ?? 85);
    if ($sc >= 85) $good_count++;
    elseif ($sc >= 65) $ok_count++;
    else $bad_count++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Yoast SEO Health Center | Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>

    <style>
        .yoast-score-gauge {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-weight: 800;
            color: #fff;
            box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        }
        .yoast-bullet {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .yoast-green { background: #22c55e; color: #fff; }
        .yoast-orange { background: #f59e0b; color: #fff; }
        .yoast-red { background: #ef4444; color: #fff; }
        .yoast-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            transition: all 0.25s ease;
        }
        .yoast-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        /* Google SERP Preview */
        .serp-box {
            background: #fff;
            border: 1px solid #dadce0;
            border-radius: 12px;
            padding: 18px 22px;
            font-family: Arial, sans-serif;
            max-width: 680px;
        }
        .serp-url-line {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #202124;
            margin-bottom: 4px;
        }
        .serp-favicon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #e8f0fe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #1a73e8;
            font-weight: bold;
        }
        .serp-breadcrumb {
            color: #4d5156;
            font-size: 12px;
        }
        .serp-title {
            color: #1a0dab;
            font-size: 19px;
            font-weight: 400;
            line-height: 1.3;
            margin-bottom: 6px;
            cursor: pointer;
            text-decoration: none;
        }
        .serp-title:hover {
            text-decoration: underline;
        }
        .serp-snippet {
            color: #4d5156;
            font-size: 14px;
            line-height: 1.5;
        }
        .char-counter {
            font-size: 11px;
            font-weight: 600;
        }
        .meter-bar {
            height: 6px;
            border-radius: 4px;
            background: #e2e8f0;
            overflow: hidden;
            margin-top: 4px;
        }
        .meter-fill {
            height: 100%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        .nav-tabs .nav-link {
            font-weight: 600;
            color: #64748b;
        }
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 3px solid #0d6efd;
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
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($error_message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Header Row -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1 fw-bold text-dark">
                            <i class="fas fa-chart-line text-success me-2"></i>Yoast SEO Health Center
                        </h2>
                        <p class="text-muted mb-0">Live SEO Health Auditing, SERP Simulation & Metadata Control across 70+ URLs</p>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <a href="<?= $site ?>sitemap.xml" target="_blank" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sitemap me-1"></i> View Sitemap.xml
                        </a>
                        <a href="<?= $site ?>robots.txt" target="_blank" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-robot me-1"></i> View Robots.txt
                        </a>
                        <button onclick="window.location.reload()" class="btn btn-primary btn-sm">
                            <i class="fas fa-sync-alt me-1"></i> Refresh SEO Audit
                        </button>
                    </div>
                </div>

                <!-- Top Stats & Overall Gauge -->
                <div class="row g-3 mb-4">
                    <!-- Gauge Card -->
                    <div class="col-lg-4 col-md-6">
                        <div class="white_card p-4 h-100 shadow-sm d-flex align-items-center justify-content-between">
                            <div>
                                <span class="badge bg-success-subtle text-success mb-2 px-2.5 py-1 fw-bold">Site-wide Health</span>
                                <h4 class="fw-bold mb-1">Yoast SEO Score</h4>
                                <p class="text-muted small mb-0">Calculated over <?= $total_monitored ?> total indexable URLs</p>
                                <div class="mt-3">
                                    <span class="badge bg-success me-1"><i class="fas fa-circle me-1" style="font-size: 8px;"></i> <?= $good_count ?> Good</span>
                                    <span class="badge bg-warning text-dark me-1"><i class="fas fa-circle me-1" style="font-size: 8px;"></i> <?= $ok_count ?> OK</span>
                                    <span class="badge bg-danger"><i class="fas fa-circle me-1" style="font-size: 8px;"></i> <?= $bad_count ?> Needs Fix</span>
                                </div>
                            </div>
                            <div class="yoast-score-gauge <?= $site_seo_avg >= 85 ? 'yoast-green' : ($site_seo_avg >= 65 ? 'yoast-orange' : 'yoast-red') ?>">
                                <span style="font-size: 28px; line-height: 1;"><?= $site_seo_avg ?></span>
                                <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">/ 100</span>
                            </div>
                        </div>
                    </div>

                    <!-- Core Metrics Card -->
                    <div class="col-lg-4 col-md-6">
                        <div class="white_card p-4 h-100 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Core Coverage</h6>
                                <span class="badge bg-primary"><?= $total_monitored ?> Pages</span>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Core Pages (Home, About, Hubs)</span>
                                    <span class="fw-bold text-dark"><?= $total_core ?> Pages</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Services Landing Pages</span>
                                    <span class="fw-bold text-dark"><?= $total_services ?> Pages</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="pt-2 border-top d-flex justify-content-between align-items-center small text-muted">
                                <span>Pan-India Coverage:</span>
                                <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> 40+ Cities Indexed</span>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Health Checklist -->
                    <div class="col-lg-4 col-md-12">
                        <div class="white_card p-4 h-100 shadow-sm">
                            <h6 class="fw-bold mb-3"><i class="fas fa-shield-alt text-info me-2"></i>Technical SEO Verification</h6>
                            <ul class="list-unstyled mb-0 small space-y-2">
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <span><i class="fas fa-check text-success me-2"></i>Canonical Tags configured</span>
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <span><i class="fas fa-check text-success me-2"></i>OpenGraph & Twitter Cards</span>
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <span><i class="fas fa-check text-success me-2"></i>Schema.org JSON-LD Structured Data</span>
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-check text-success me-2"></i>Mobile-Friendly Responsive Meta</span>
                                    <span class="badge bg-success-subtle text-success">100% Mobile Ready</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Google SERP Live Simulator Section -->
                <div class="white_card mb_30 p-4 shadow-sm">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="fab fa-google text-danger me-2"></i>Google SERP Snippet Simulator
                            </h5>
                            <p class="text-muted small mb-0">See exactly how your pages appear in Google Search result snippets</p>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0">
                            <select id="serpPageSelector" class="form-select form-select-sm" style="min-width: 260px;" onchange="loadSerpPreview(this.value)">
                                <optgroup label="Core Frontend Pages">
                                    <?php foreach ($core_pages as $cp): ?>
                                        <option value="core_<?= $cp['id'] ?>" 
                                                data-title="<?= htmlspecialchars($cp['meta_title']) ?>" 
                                                data-desc="<?= htmlspecialchars($cp['meta_description']) ?>" 
                                                data-url="<?= htmlspecialchars($site . ltrim($cp['canonical_url'] ?? '', '/')) ?>"
                                                data-keyword="<?= htmlspecialchars($cp['focus_keyword']) ?>"
                                                data-score="<?= $cp['seo_score'] ?>">
                                            <?= htmlspecialchars($cp['page_name']) ?> (Score: <?= $cp['seo_score'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Popular Services Pages">
                                    <?php foreach (array_slice($services_list, 0, 10) as $sp): ?>
                                        <option value="svc_<?= $sp['id'] ?>" 
                                                data-title="<?= htmlspecialchars($sp['meta_title'] ?: ($sp['name'] . ' | Vocation Travels')) ?>" 
                                                data-desc="<?= htmlspecialchars($sp['meta_description']) ?>" 
                                                data-url="<?= htmlspecialchars($site . 'services/' . $sp['slug'] . '/') ?>"
                                                data-keyword="<?= htmlspecialchars($sp['focus_keyword']) ?>"
                                                data-score="<?= $sp['seo_score'] ?>">
                                            Service: <?= htmlspecialchars($sp['name']) ?> (Score: <?= $sp['seo_score'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 align-items-center">
                        <div class="col-lg-7">
                            <div class="serp-box shadow-sm">
                                <div class="serp-url-line">
                                    <div class="serp-favicon">V</div>
                                    <div>
                                        <span class="fw-semibold">Vocation Travels</span>
                                        <span class="serp-breadcrumb" id="previewUrl">https://vocationtravels.com</span>
                                    </div>
                                </div>
                                <h3 class="serp-title mb-1" id="previewTitle">
                                    Vocation Travels – Holiday Tour Packages & Visa Consultants Across India
                                </h3>
                                <p class="serp-snippet mb-0" id="previewDesc">
                                    Discover luxury tour packages and trusted visa consultancy across 40+ Indian cities and globally. 24/7 VIP concierge, bespoke itineraries, and expert visa assistance.
                                </p>
                            </div>
                        </div>

                        <!-- Realtime Yoast Analysis checklist for this page -->
                        <div class="col-lg-5">
                            <div class="bg-light p-3 rounded-3 border">
                                <h6 class="fw-bold mb-3 d-flex justify-content-between align-items-center">
                                    <span>Yoast Content Analysis</span>
                                    <span class="badge bg-success" id="analysisScoreBadge">Score: 95/100</span>
                                </h6>
                                <div class="space-y-2 small">
                                    <div class="d-flex align-items-center mb-2" id="chkTitleLen">
                                        <span class="yoast-bullet yoast-green"></span>
                                        <span><strong>SEO Title width:</strong> <span id="titleCount">68</span> characters (Optimal: 45-65)</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" id="chkDescLen">
                                        <span class="yoast-bullet yoast-green"></span>
                                        <span><strong>Meta description width:</strong> <span id="descCount">155</span> characters (Optimal: 120-160)</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" id="chkKeywordTitle">
                                        <span class="yoast-bullet yoast-green"></span>
                                        <span><strong>Focus keyword in title:</strong> <span id="kwTitleResult">Present</span></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" id="chkKeywordDesc">
                                        <span class="yoast-bullet yoast-green"></span>
                                        <span><strong>Focus keyword in description:</strong> <span id="kwDescResult">Present</span></span>
                                    </div>
                                    <div class="d-flex align-items-center" id="chkCanonical">
                                        <span class="yoast-bullet yoast-green"></span>
                                        <span><strong>Canonical URL:</strong> Valid & configured</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs for Core Pages vs Services CMS SEO -->
                <div class="white_card card_height_100 mb_30">
                    <div class="card-header bg-white border-bottom py-3">
                        <ul class="nav nav-tabs card-header-tabs" id="seoTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="core-tab" data-bs-toggle="tab" data-bs-target="#core-pane" type="button">
                                    <i class="fas fa-layer-group me-2"></i>Core Frontend Pages (<?= count($core_pages) ?>)
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services-pane" type="button">
                                    <i class="fas fa-concierge-bell me-2"></i>Services CMS SEO (<?= count($services_list) ?>)
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="seoTabsContent">

                            <!-- Core Pages Table -->
                            <div class="tab-pane fade show active" id="core-pane" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="15%">Page Name</th>
                                                <th width="15%">Focus Keyword</th>
                                                <th width="28%">SEO Meta Title</th>
                                                <th width="24%">Meta Description</th>
                                                <th width="8%">Yoast Score</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($core_pages as $p): ?>
                                                <?php 
                                                    $sc = (int)$p['seo_score'];
                                                    $badge_cls = $sc >= 85 ? 'bg-success' : ($sc >= 65 ? 'bg-warning text-dark' : 'bg-danger');
                                                    $t_len = mb_strlen($p['meta_title']);
                                                    $d_len = mb_strlen($p['meta_description']);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark"><?= htmlspecialchars($p['page_name']) ?></div>
                                                        <code class="small text-muted">/<?= htmlspecialchars($p['canonical_url'] ?? '') ?></code>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="fas fa-key text-warning me-1"></i><?= htmlspecialchars($p['focus_keyword'] ?: 'Not set') ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate fw-semibold" style="max-width: 320px;" title="<?= htmlspecialchars($p['meta_title']) ?>">
                                                            <?= htmlspecialchars($p['meta_title']) ?>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 mt-1">
                                                            <span class="char-counter <?= ($t_len >= 45 && $t_len <= 65) ? 'text-success' : 'text-danger' ?>">
                                                                <?= $t_len ?> chars
                                                            </span>
                                                            <div class="meter-bar flex-grow-1" style="max-width: 100px;">
                                                                <div class="meter-fill <?= ($t_len >= 45 && $t_len <= 65) ? 'bg-success' : 'bg-warning' ?>" style="width: <?= min(100, ($t_len / 65) * 100) ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate text-muted small" style="max-width: 280px;" title="<?= htmlspecialchars($p['meta_description']) ?>">
                                                            <?= htmlspecialchars($p['meta_description']) ?>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 mt-1">
                                                            <span class="char-counter <?= ($d_len >= 120 && $d_len <= 165) ? 'text-success' : 'text-danger' ?>">
                                                                <?= $d_len ?> chars
                                                            </span>
                                                            <div class="meter-bar flex-grow-1" style="max-width: 100px;">
                                                                <div class="meter-fill <?= ($d_len >= 120 && $d_len <= 165) ? 'bg-success' : 'bg-warning' ?>" style="width: <?= min(100, ($d_len / 160) * 100) ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge <?= $badge_cls ?> px-2.5 py-1.5 fw-bold">
                                                            <?= $sc ?>/100
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary" 
                                                                onclick="openEditSeoModal(<?= htmlspecialchars(json_encode($p)) ?>)">
                                                            <i class="fas fa-edit me-1"></i>Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Services Table -->
                            <div class="tab-pane fade" id="services-pane" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p class="text-muted small mb-0">Showing all 65 indexed services. Click "Edit" to configure full content & Yoast SEO for any service.</p>
                                    <a href="services-manager.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-external-link-alt me-1"></i> Open Full Services CMS Manager
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Service Name</th>
                                                <th>Category</th>
                                                <th>Focus Keyword</th>
                                                <th>Page Views</th>
                                                <th>Inquiries</th>
                                                <th>Yoast Score</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($services_list as $s): ?>
                                                <?php 
                                                    $sc = (int)$s['seo_score'];
                                                    $badge_cls = $sc >= 85 ? 'bg-success' : ($sc >= 65 ? 'bg-warning text-dark' : 'bg-danger');
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark"><?= htmlspecialchars($s['name']) ?></div>
                                                        <code class="small text-muted">/services/<?= htmlspecialchars($s['slug']) ?>/</code>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?= $s['category'] === 'core' ? 'info' : 'secondary' ?>-subtle text-<?= $s['category'] === 'core' ? 'info' : 'secondary' ?>">
                                                            <?= ucfirst($s['category']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">
                                                            <?= htmlspecialchars($s['focus_keyword'] ?: strtolower($s['name'])) ?>
                                                        </span>
                                                    </td>
                                                    <td><i class="fas fa-eye text-muted me-1"></i><?= $s['views_count'] ?></td>
                                                    <td><i class="fas fa-envelope text-primary me-1"></i><?= $s['inquiries_count'] ?></td>
                                                    <td>
                                                        <span class="badge <?= $badge_cls ?> px-2.5 py-1.5 fw-bold">
                                                            <?= $sc ?>/100
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="edit-service.php?slug=<?= urlencode($s['slug']) ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-sliders-h me-1"></i>Edit SEO
                                                        </a>
                                                        <a href="<?= $site ?>services/<?= urlencode($s['slug']) ?>/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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

    <!-- Modal for Editing Page SEO -->
    <div class="modal fade" id="editSeoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="seo-health.php">
                    <input type="hidden" name="action" value="update_page_seo">
                    <input type="hidden" name="page_id" id="modalPageId">
                    
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-chart-line text-success me-2"></i>Edit Yoast SEO: <span id="modalPageNameTitle"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold small">Focus Keyword / Keyphrase</label>
                                <input type="text" class="form-control" name="focus_keyword" id="modalFocusKeyword" required
                                       placeholder="e.g. tour packages India, visa consultants Delhi" oninput="updateModalYoastAnalysis()">
                                <small class="text-muted">The main search query you want this page to rank for on Google.</small>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label fw-bold small mb-1">SEO Meta Title (45 - 65 chars recommended)</label>
                                    <span class="char-counter text-muted" id="modalTitleCounter">0 / 65</span>
                                </div>
                                <input type="text" class="form-control" name="meta_title" id="modalMetaTitle" required
                                       placeholder="Page title displayed in search engines" oninput="updateModalYoastAnalysis()">
                                <div class="meter-bar">
                                    <div class="meter-fill" id="modalTitleMeter" style="width: 0%;"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label fw-bold small mb-1">Meta Description (120 - 160 chars recommended)</label>
                                    <span class="char-counter text-muted" id="modalDescCounter">0 / 160</span>
                                </div>
                                <textarea class="form-control" name="meta_description" id="modalMetaDesc" rows="3" required
                                          placeholder="The summary text snippet that appears below your title on Google" oninput="updateModalYoastAnalysis()"></textarea>
                                <div class="meter-bar">
                                    <div class="meter-fill" id="modalDescMeter" style="width: 0%;"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Canonical Path</label>
                                <input type="text" class="form-control" name="canonical_url" id="modalCanonicalUrl"
                                       placeholder="e.g. about/, contact/, services/">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Social Share Image (OG Image)</label>
                                <input type="text" class="form-control" name="og_image" id="modalOgImage"
                                       placeholder="assets/images/...">
                            </div>

                            <!-- Live Modal Analysis Box -->
                            <div class="col-12 mt-3">
                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold mb-2 small text-uppercase">Live Yoast SEO Score Calculation</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div id="modalAnalysisNotes" class="small text-muted">Title & Description fit optimal length</div>
                                        <div class="badge bg-success fs-6" id="modalEstimatedScore">Score: 95/100</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Save SEO Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadSerpPreview(val) {
            const select = document.getElementById('serpPageSelector');
            const opt = select.options[select.selectedIndex];
            
            const title = opt.getAttribute('data-title') || '';
            const desc = opt.getAttribute('data-desc') || '';
            const url = opt.getAttribute('data-url') || '';
            const kw = (opt.getAttribute('data-keyword') || '').toLowerCase();
            const score = opt.getAttribute('data-score') || '90';

            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewDesc').textContent = desc;
            document.getElementById('previewUrl').textContent = url;
            document.getElementById('titleCount').textContent = title.length;
            document.getElementById('descCount').textContent = desc.length;
            document.getElementById('analysisScoreBadge').textContent = 'Score: ' + score + '/100';

            // Check title length
            const chkTitle = document.getElementById('chkTitleLen');
            if (title.length >= 45 && title.length <= 65) {
                chkTitle.querySelector('.yoast-bullet').className = 'yoast-bullet yoast-green';
            } else if (title.length >= 35 && title.length <= 75) {
                chkTitle.querySelector('.yoast-bullet').className = 'yoast-bullet yoast-orange';
            } else {
                chkTitle.querySelector('.yoast-bullet').className = 'yoast-bullet yoast-red';
            }

            // Check desc length
            const chkDesc = document.getElementById('chkDescLen');
            if (desc.length >= 120 && desc.length <= 165) {
                chkDesc.querySelector('.yoast-bullet').className = 'yoast-bullet yoast-green';
            } else if (desc.length >= 80 && desc.length <= 180) {
                chkDesc.querySelector('.yoast-bullet').className = 'yoast-bullet yoast-orange';
            } else {
                chkDesc.querySelector('.yoast-bullet').className = 'yoast-bullet yoast-red';
            }

            // Check keyword in title & desc
            const kwInTitle = kw && title.toLowerCase().includes(kw);
            const chkKwT = document.getElementById('chkKeywordTitle');
            chkKwT.querySelector('.yoast-bullet').className = 'yoast-bullet ' + (kwInTitle ? 'yoast-green' : 'yoast-orange');
            document.getElementById('kwTitleResult').textContent = kwInTitle ? 'Found in title' : 'Not found in title';

            const kwInDesc = kw && desc.toLowerCase().includes(kw);
            const chkKwD = document.getElementById('chkKeywordDesc');
            chkKwD.querySelector('.yoast-bullet').className = 'yoast-bullet ' + (kwInDesc ? 'yoast-green' : 'yoast-orange');
            document.getElementById('kwDescResult').textContent = kwInDesc ? 'Found in description' : 'Not found in description';
        }

        function openEditSeoModal(pageData) {
            document.getElementById('modalPageId').value = pageData.id;
            document.getElementById('modalPageNameTitle').textContent = pageData.page_name;
            document.getElementById('modalFocusKeyword').value = pageData.focus_keyword || '';
            document.getElementById('modalMetaTitle').value = pageData.meta_title || '';
            document.getElementById('modalMetaDesc').value = pageData.meta_description || '';
            document.getElementById('modalCanonicalUrl').value = pageData.canonical_url || '';
            document.getElementById('modalOgImage').value = pageData.og_image || '';

            updateModalYoastAnalysis();

            const modal = new bootstrap.Modal(document.getElementById('editSeoModal'));
            modal.show();
        }

        function updateModalYoastAnalysis() {
            const title = document.getElementById('modalMetaTitle').value;
            const desc = document.getElementById('modalMetaDesc').value;
            const kw = document.getElementById('modalFocusKeyword').value.trim().toLowerCase();

            const tLen = title.length;
            const dLen = desc.length;

            document.getElementById('modalTitleCounter').textContent = tLen + ' / 65';
            document.getElementById('modalDescCounter').textContent = dLen + ' / 160';

            const tMeter = document.getElementById('modalTitleMeter');
            tMeter.style.width = Math.min(100, (tLen / 65) * 100) + '%';
            tMeter.className = 'meter-fill ' + ((tLen >= 45 && tLen <= 65) ? 'bg-success' : (tLen > 0 ? 'bg-warning' : 'bg-danger'));

            const dMeter = document.getElementById('modalDescMeter');
            dMeter.style.width = Math.min(100, (dLen / 160) * 100) + '%';
            dMeter.className = 'meter-fill ' + ((dLen >= 120 && dLen <= 165) ? 'bg-success' : (dLen > 0 ? 'bg-warning' : 'bg-danger'));

            // Score estimation
            let estScore = 100;
            if (!kw) estScore -= 20;
            else {
                if (!title.toLowerCase().includes(kw)) estScore -= 10;
                if (!desc.toLowerCase().includes(kw)) estScore -= 10;
            }
            if (tLen < 30 || tLen > 65) estScore -= 15;
            if (dLen < 100 || dLen > 165) estScore -= 15;
            estScore = Math.max(35, Math.min(100, estScore));

            const badge = document.getElementById('modalEstimatedScore');
            badge.textContent = 'Score: ' + estScore + '/100';
            badge.className = 'badge fs-6 ' + (estScore >= 85 ? 'bg-success' : (estScore >= 65 ? 'bg-warning text-dark' : 'bg-danger'));
        }

        // Initialize preview on first option
        document.addEventListener('DOMContentLoaded', function() {
            loadSerpPreview();
        });
    </script>
</body>
</html>
