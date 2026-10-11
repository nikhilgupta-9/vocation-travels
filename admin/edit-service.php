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

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
if (empty($slug)) {
    header("Location: services-manager.php");
    exit();
}

$success_message = '';
$error_message = '';

// Handle POST save
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_service') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? 'core');
    $tagline = trim($_POST['tagline'] ?? '');
    $icon = trim($_POST['icon'] ?? 'fa-solid fa-plane-departure');
    $image = trim($_POST['image'] ?? '');
    $overview_text = trim($_POST['overview_text'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $focus_keyword = trim($_POST['focus_keyword'] ?? '');
    $status = trim($_POST['status'] ?? 'active');

    // Handle Highlights Array -> JSON
    $highlights = [];
    if (isset($_POST['highlights']) && is_array($_POST['highlights'])) {
        foreach ($_POST['highlights'] as $hl) {
            $trimmed = trim($hl);
            if (!empty($trimmed)) {
                $highlights[] = $trimmed;
            }
        }
    }
    $highlights_json = json_encode($highlights, JSON_UNESCAPED_UNICODE);

    // Handle Features Array -> JSON
    $features = [];
    if (isset($_POST['features']) && is_array($_POST['features'])) {
        foreach ($_POST['features'] as $ft) {
            $t = trim($ft['title'] ?? '');
            $d = trim($ft['desc'] ?? '');
            $i = trim($ft['icon'] ?? 'fa-solid fa-check-circle');
            if (!empty($t)) {
                $features[] = ['title' => $t, 'desc' => $d, 'icon' => $i];
            }
        }
    }
    $features_json = json_encode($features, JSON_UNESCAPED_UNICODE);

    // Handle FAQs Array -> JSON
    $faqs = [];
    if (isset($_POST['faqs']) && is_array($_POST['faqs'])) {
        foreach ($_POST['faqs'] as $faq) {
            $q = trim($faq['q'] ?? '');
            $a = trim($faq['a'] ?? '');
            if (!empty($q)) {
                $faqs[] = ['q' => $q, 'a' => $a];
            }
        }
    }
    $faqs_json = json_encode($faqs, JSON_UNESCAPED_UNICODE);

    // Handle Image Upload if provided
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (in_array($_FILES['image_file']['type'], $allowed)) {
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $filename = 'svc_' . $slug . '_' . time() . '.' . $ext;
            $dest_dir = dirname(__DIR__) . '/assets/images/services/';
            if (!is_dir($dest_dir)) {
                mkdir($dest_dir, 0755, true);
            }
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $dest_dir . $filename)) {
                $image = 'assets/images/services/' . $filename;
            }
        }
    }

    // Recalculate Yoast SEO score
    $score = 100;
    $t_len = mb_strlen($meta_title);
    $d_len = mb_strlen($meta_description);

    if (empty($focus_keyword)) $score -= 20;
    else {
        $kw = strtolower($focus_keyword);
        if (strpos(strtolower($meta_title), $kw) === false) $score -= 10;
        if (strpos(strtolower($meta_description), $kw) === false) $score -= 10;
    }
    if ($t_len < 35 || $t_len > 65) $score -= 15;
    if ($d_len < 100 || $d_len > 165) $score -= 15;
    $score = max(35, min(100, $score));

    $stmt = $conn->prepare("UPDATE services_cms SET 
        name = ?, 
        category = ?, 
        tagline = ?, 
        icon = ?, 
        image = ?, 
        overview_text = ?, 
        highlights_json = ?, 
        features_json = ?, 
        faqs_json = ?, 
        meta_title = ?, 
        meta_description = ?, 
        focus_keyword = ?, 
        seo_score = ?, 
        status = ?, 
        updated_at = NOW() 
        WHERE slug = ?");

    if ($stmt) {
        $stmt->bind_param("ssssssssssssiss", 
            $name, 
            $category, 
            $tagline, 
            $icon, 
            $image, 
            $overview_text, 
            $highlights_json, 
            $features_json, 
            $faqs_json, 
            $meta_title, 
            $meta_description, 
            $focus_keyword, 
            $score, 
            $status, 
            $slug
        );
        if ($stmt->execute()) {
            $success_message = "Service '{$name}' updated successfully! Yoast SEO Score: {$score}/100.";
        } else {
            $error_message = "Failed to update service: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch fresh service data
$stmt = $conn->prepare("SELECT * FROM services_cms WHERE slug = ? LIMIT 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$res = $stmt->get_result();
$service = $res->fetch_assoc();
$stmt->close();

if (!$service) {
    header("Location: services-manager.php");
    exit();
}

$live_url = $site . 'services/' . $service['slug'] . '/';

// Parse existing JSON arrays for UI builder
$highlights_data = json_decode($service['highlights_json'] ?? '[]', true) ?: [];
$features_data = json_decode($service['features_json'] ?? '[]', true) ?: [];
$faqs_data = json_decode($service['faqs_json'] ?? '[]', true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Service: <?= htmlspecialchars($service['name']) ?> | Admin Control Center</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>

    <style>
        :root {
            --primary-accent: #4f46e5;
            --primary-hover: #4338ca;
            --success-accent: #10b981;
        }
        body.crm_body_bg {
            background-color: #f1f5f9;
        }
        /* Sticky Top Action Bar */
        .sticky-action-bar {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 20px;
            margin: -20px -20px 24px -20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border-radius: 0 0 16px 16px;
        }
        .service-hero-card {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            color: #ffffff;
            border-radius: 16px;
            padding: 26px 30px;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(49, 46, 129, 0.2);
            position: relative;
            overflow: hidden;
        }
        .service-hero-card::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero-icon-box {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .editor-tab-nav {
            background: #ffffff;
            border-radius: 14px;
            padding: 6px;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 24px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .editor-tab-nav .nav-link {
            border-radius: 10px;
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 18px;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .editor-tab-nav .nav-link:hover {
            color: #1e293b;
            background: #f8fafc;
        }
        .editor-tab-nav .nav-link.active {
            background: var(--primary-accent);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }
        .ui-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.02);
        }
        .ui-card-title {
            font-size: 17px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        /* Item Builders */
        .dynamic-item-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }
        .dynamic-item-card:hover {
            border-color: #cbd5e1;
            background: #f1f5f9;
        }
        /* Icon picker presets */
        .icon-preset-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .icon-preset-btn:hover, .icon-preset-btn.active {
            border-color: var(--primary-accent);
            color: var(--primary-accent);
            background: #eef2ff;
        }
        /* Google SERP Simulator */
        .serp-card {
            background: #ffffff;
            border: 1px solid #dadce0;
            border-radius: 12px;
            padding: 18px 22px;
            font-family: Arial, sans-serif;
            max-width: 660px;
        }
        .serp-card.mobile-view {
            max-width: 390px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            border: 2px solid #e2e8f0;
            margin: 0 auto;
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
        .serp-breadcrumb { color: #4d5156; font-size: 12px; word-break: break-all; }
        .serp-title {
            color: #1a0dab;
            font-size: 19px;
            font-weight: 400;
            line-height: 1.3;
            margin-bottom: 6px;
            cursor: pointer;
        }
        .serp-title:hover { text-decoration: underline; }
        .serp-snippet { color: #4d5156; font-size: 14px; line-height: 1.5; }
        .meter-bar {
            height: 6px;
            border-radius: 4px;
            background: #e2e8f0;
            overflow: hidden;
            margin-top: 4px;
        }
        .meter-fill { height: 100%; transition: width 0.3s ease; }
        .yoast-bullet {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .yoast-green { background: #10b981; }
        .yoast-orange { background: #f59e0b; }
        .yoast-red { background: #ef4444; }
        .pill-counter {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 12px;
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
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-lg me-3"></i>
                            <div>
                                <strong>Success!</strong> <?= htmlspecialchars($success_message) ?>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                            <div>
                                <strong>Error:</strong> <?= htmlspecialchars($error_message) ?>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Start -->
                <form id="serviceEditForm" method="POST" action="edit-service.php?slug=<?= urlencode($slug) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save_service">

                    <!-- Sticky Top Action Bar -->
                    <div class="sticky-action-bar d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <a href="services-manager.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="fas fa-arrow-left me-1"></i> Services Hub
                            </a>
                            <span class="text-muted d-none d-md-inline">|</span>
                            <span class="fw-bold text-dark d-none d-md-inline">
                                Editing: <?= htmlspecialchars($service['name']) ?>
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <a href="<?= $live_url ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-external-link-alt me-1"></i> View Live Page
                            </a>
                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 fw-bold shadow-sm" id="topSaveBtn">
                                <i class="fas fa-save me-1"></i> Save Changes (Ctrl+S)
                            </button>
                        </div>
                    </div>

                    <!-- Service Hero Banner -->
                    <div class="service-hero-card">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
                            <div class="d-flex align-items-center gap-4">
                                <div class="hero-icon-box shadow">
                                    <i class="<?= htmlspecialchars($service['icon'] ?: 'fa-solid fa-plane-departure') ?>" id="heroIconDisplay"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-white text-dark rounded-pill fw-bold text-uppercase px-2.5 py-1" style="font-size: 11px;">
                                            <?= ucfirst($service['category']) ?> Service
                                        </span>
                                        <span class="badge rounded-pill px-2.5 py-1 <?= $service['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>" style="font-size: 11px;">
                                            <i class="fas fa-circle me-1" style="font-size: 7px;"></i> <?= ucfirst($service['status']) ?>
                                        </span>
                                    </div>
                                    <h2 class="fw-bold mb-1 text-white" id="heroNameDisplay"><?= htmlspecialchars($service['name']) ?></h2>
                                    <div class="opacity-75 small">
                                        <i class="fas fa-link me-1"></i> <?= $live_url ?>
                                    </div>
                                </div>
                            </div>

                            <!-- KPIs in Hero -->
                            <div class="d-flex gap-3">
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 rounded-3 px-3 py-2 text-center" style="min-width: 90px;">
                                    <div class="fs-4 fw-bold mb-0 text-white"><?= $service['views_count'] ?></div>
                                    <small class="opacity-75" style="font-size: 11px;"><i class="fas fa-eye me-1"></i>Views</small>
                                </div>
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 rounded-3 px-3 py-2 text-center" style="min-width: 90px;">
                                    <div class="fs-4 fw-bold mb-0 text-white"><?= $service['inquiries_count'] ?></div>
                                    <small class="opacity-75" style="font-size: 11px;"><i class="fas fa-envelope me-1"></i>Leads</small>
                                </div>
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 rounded-3 px-3 py-2 text-center" style="min-width: 95px;">
                                    <div class="fs-4 fw-bold mb-0 text-warning" id="heroScoreDisplay"><?= $service['seo_score'] ?>%</div>
                                    <small class="opacity-75" style="font-size: 11px;"><i class="fas fa-chart-line me-1"></i>SEO Health</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <ul class="nav editor-tab-nav" id="serviceEditorTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="tab-general-btn" data-bs-toggle="tab" data-bs-target="#tab-general" type="button">
                                <i class="fas fa-file-alt"></i> General & Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="tab-seo-btn" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button">
                                <i class="fas fa-chart-line"></i> Yoast SEO & SERP
                                <span class="badge bg-success rounded-pill ms-1" id="tabScoreBadge"><?= $service['seo_score'] ?></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="tab-highlights-btn" data-bs-toggle="tab" data-bs-target="#tab-highlights" type="button">
                                <i class="fas fa-star"></i> Highlights & Features (<?= count($highlights_data) + count($features_data) ?>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="tab-faqs-btn" data-bs-toggle="tab" data-bs-target="#tab-faqs" type="button">
                                <i class="fas fa-question-circle"></i> FAQ Builder (<?= count($faqs_data) ?>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="tab-media-btn" data-bs-toggle="tab" data-bs-target="#tab-media" type="button">
                                <i class="fas fa-images"></i> Media & Icon
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Panes Content -->
                    <div class="tab-content" id="serviceEditorContent">

                        <!-- TAB 1: General & Overview -->
                        <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-lg-8">
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-align-left text-primary me-2"></i>Primary Service Information</span>
                                            <span class="badge bg-light text-muted border">Slug: <?= htmlspecialchars($service['slug']) ?></span>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label class="form-label fw-bold small text-dark">Service Display Name *</label>
                                                <input type="text" class="form-control form-control-lg fs-6" name="name" id="serviceName" required
                                                       value="<?= htmlspecialchars($service['name']) ?>" oninput="syncServiceTitle()">
                                                <small class="text-muted">Primary name visible in headlines and navigation menus.</small>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold small text-dark">Category Classification *</label>
                                                <select class="form-select form-control-lg fs-6" name="category">
                                                    <option value="core" <?= $service['category'] === 'core' ? 'selected' : '' ?>>Core Service (Top 14)</option>
                                                    <option value="specialized" <?= $service['category'] === 'specialized' ? 'selected' : '' ?>>Specialized Service (B2B / Luxury)</option>
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-bold small text-dark">Short Tagline / Summary Card Description *</label>
                                                <textarea class="form-control" name="tagline" rows="2" required placeholder="A crisp 1-2 sentence hook for services grid cards..."><?= htmlspecialchars($service['tagline']) ?></textarea>
                                                <small class="text-muted">Shown in search result cards, homepage highlights, and the main /services/ hub.</small>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold small text-dark mb-0">Detailed Overview Content (Multi-Paragraph)</label>
                                                    <span class="text-muted small" id="paragraphCountText">Formatting: Double Enter for new paragraphs</span>
                                                </div>
                                                <textarea class="form-control font-monospace" name="overview_text" id="overviewTextInput" rows="10" 
                                                          style="line-height: 1.6; font-size: 14px;"
                                                          placeholder="Detailed paragraphs explaining this travel service, value proposition, client experience..."><?= htmlspecialchars($service['overview_text']) ?></textarea>
                                                <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                                    <span><i class="fas fa-info-circle me-1 text-primary"></i>Separate multiple paragraphs with blank lines (double Enter).</span>
                                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" onclick="formatOverviewSpacing()">
                                                        <i class="fas fa-magic me-1"></i> Auto-Format Spacing
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Quick Settings Panel -->
                                <div class="col-lg-4">
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-sliders-h text-primary me-2"></i>Publishing & Status</span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Publication Status</label>
                                            <select class="form-select" name="status">
                                                <option value="active" <?= $service['status'] === 'active' ? 'selected' : '' ?>>🟢 Active & Publicly Indexable</option>
                                                <option value="inactive" <?= $service['status'] === 'inactive' ? 'selected' : '' ?>>🔴 Inactive (Draft / Hidden)</option>
                                            </select>
                                            <small class="text-muted">Inactive services are excluded from public menus and return 404.</small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Direct Canonical URL</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light small" value="<?= $live_url ?>" readonly id="liveUrlCopyField">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="copyUrlToClipboard()" title="Copy Link">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="border-top pt-3">
                                            <button type="submit" class="btn btn-success w-100 py-2.5 fw-bold shadow-sm">
                                                <i class="fas fa-save me-1"></i> Save Changes Now
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Quick Media Mini-Preview -->
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-image text-primary me-2"></i>Featured Banner</span>
                                        </div>
                                        <div class="position-relative overflow-hidden rounded-3 mb-2 shadow-sm" style="height: 160px; background: #e2e8f0;">
                                            <img src="<?= $site . ltrim($service['image'], '/') ?>" 
                                                 alt="Service Image" id="sideImagePreview" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <a href="#tab-media" onclick="document.getElementById('tab-media-btn').click()" class="btn btn-outline-primary btn-sm w-100">
                                            <i class="fas fa-edit me-1"></i> Change Banner or Icon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: Yoast SEO & Google SERP Simulator -->
                        <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                            <div class="row g-4">
                                <!-- SEO Fields -->
                                <div class="col-lg-7">
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-chart-line text-success me-2"></i>Yoast SEO Configuration</span>
                                            <span class="badge bg-success fs-6" id="yoastScoreBadge">Score: <?= $service['seo_score'] ?>/100</span>
                                        </div>

                                        <!-- Focus Keyphrase -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold small text-dark d-flex justify-content-between">
                                                <span>Focus Keyphrase *</span>
                                                <span class="text-muted fw-normal">Target Google search query</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="fas fa-key text-warning"></i></span>
                                                <input type="text" class="form-control" name="focus_keyword" id="seoKeyword" required
                                                       value="<?= htmlspecialchars($service['focus_keyword']) ?>" oninput="runYoastAnalysis()"
                                                       placeholder="e.g. domestic tour packages India, luxury holidays Delhi">
                                            </div>
                                            <small class="text-muted">The exact keyword or search phrase you want this service page to rank for.</small>
                                        </div>

                                        <!-- Meta Title -->
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="form-label fw-bold small text-dark mb-0">SEO Meta Title *</label>
                                                <span class="pill-counter" id="titleCounter">0 / 65</span>
                                            </div>
                                            <input type="text" class="form-control" name="meta_title" id="seoTitle" required
                                                   value="<?= htmlspecialchars($service['meta_title']) ?>" oninput="runYoastAnalysis()"
                                                   placeholder="Title shown in browser tabs and Google Search">
                                            <div class="meter-bar">
                                                <div class="meter-fill" id="titleMeter" style="width: 0%;"></div>
                                            </div>
                                            <small class="text-muted">Recommended: 45 to 65 characters for optimal Google desktop and mobile clipping.</small>
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="form-label fw-bold small text-dark mb-0">Meta Description *</label>
                                                <span class="pill-counter" id="descCounter">0 / 160</span>
                                            </div>
                                            <textarea class="form-control" name="meta_description" id="seoDesc" rows="3" required 
                                                      oninput="runYoastAnalysis()"
                                                      placeholder="The summary text snippet that appears beneath your title in Google search results..."><?= htmlspecialchars($service['meta_description']) ?></textarea>
                                            <div class="meter-bar">
                                                <div class="meter-fill" id="descMeter" style="width: 0%;"></div>
                                            </div>
                                            <small class="text-muted">Recommended: 120 to 165 characters. Keep focus keyword naturally integrated.</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- SERP Simulator & Realtime Checklist -->
                                <div class="col-lg-5">
                                    <div class="ui-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="fw-bold mb-0">
                                                <i class="fab fa-google text-danger me-2"></i>Google SERP Snippet Preview
                                            </h6>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-secondary active" id="btnPreviewDesktop" onclick="switchSerpView('desktop')">
                                                    <i class="fas fa-desktop me-1"></i> Desktop
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" id="btnPreviewMobile" onclick="switchSerpView('mobile')">
                                                    <i class="fas fa-mobile-alt me-1"></i> Mobile
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Google SERP Card -->
                                        <div class="serp-card shadow-sm mb-4" id="serpCardContainer">
                                            <div class="serp-url-line">
                                                <div class="serp-favicon">V</div>
                                                <div>
                                                    <span class="fw-semibold">Vocation Travels</span>
                                                    <span class="serp-breadcrumb"><?= $live_url ?></span>
                                                </div>
                                            </div>
                                            <div class="serp-title" id="serpPreviewTitle"><?= htmlspecialchars($service['meta_title']) ?></div>
                                            <div class="serp-snippet" id="serpPreviewDesc"><?= htmlspecialchars($service['meta_description']) ?></div>
                                        </div>

                                        <!-- Live Yoast Checklist Box -->
                                        <div class="bg-light p-3 rounded-3 border">
                                            <h6 class="fw-bold small text-uppercase mb-3 d-flex justify-content-between align-items-center">
                                                <span>Yoast SEO Diagnostic</span>
                                                <span class="badge bg-secondary" id="analysisItemsCount">5 checks</span>
                                            </h6>
                                            <div class="space-y-2 small">
                                                <div class="d-flex align-items-center mb-2" id="chkKwInTitle">
                                                    <span class="yoast-bullet yoast-green"></span>
                                                    <span><strong>Focus keyword in title:</strong> <span id="txtKwTitle">Present</span></span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2" id="chkKwInDesc">
                                                    <span class="yoast-bullet yoast-green"></span>
                                                    <span><strong>Focus keyword in description:</strong> <span id="txtKwDesc">Present</span></span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2" id="chkTitleWidth">
                                                    <span class="yoast-bullet yoast-green"></span>
                                                    <span><strong>Title optimal length:</strong> (45 - 65 chars)</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2" id="chkDescWidth">
                                                    <span class="yoast-bullet yoast-green"></span>
                                                    <span><strong>Description optimal length:</strong> (120 - 165 chars)</span>
                                                </div>
                                                <div class="d-flex align-items-center" id="chkSlugReadability">
                                                    <span class="yoast-bullet yoast-green"></span>
                                                    <span><strong>Slug:</strong> Short, clean and crawlable</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: Highlights & Features Builder -->
                        <div class="tab-pane fade" id="tab-highlights" role="tabpanel">
                            <div class="row g-4">
                                <!-- Highlights List -->
                                <div class="col-lg-6">
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-check-double text-success me-2"></i>Key Highlights Bullets</span>
                                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill" onclick="addHighlightRow()">
                                                <i class="fas fa-plus me-1"></i> Add Highlight
                                            </button>
                                        </div>
                                        <p class="text-muted small">Highlights are showcased prominently at the top of the service details page.</p>

                                        <div id="highlightsContainer">
                                            <?php if (!empty($highlights_data)): ?>
                                                <?php foreach ($highlights_data as $h_idx => $hl_text): ?>
                                                    <div class="dynamic-item-card d-flex gap-2 align-items-center highlight-item">
                                                        <span class="text-muted"><i class="fas fa-grip-vertical"></i></span>
                                                        <input type="text" class="form-control" name="highlights[]" value="<?= htmlspecialchars($hl_text) ?>" required placeholder="e.g. Curated itineraries for popular destinations">
                                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.highlight-item').remove()" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="dynamic-item-card d-flex gap-2 align-items-center highlight-item">
                                                    <span class="text-muted"><i class="fas fa-grip-vertical"></i></span>
                                                    <input type="text" class="form-control" name="highlights[]" value="Handcrafted itinerary planned around your dates" placeholder="Highlight text...">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.highlight-item').remove()" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Feature Cards Builder -->
                                <div class="col-lg-6">
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-th-large text-primary me-2"></i>Feature Pillars Cards</span>
                                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="addFeatureCard()">
                                                <i class="fas fa-plus me-1"></i> Add Feature Card
                                            </button>
                                        </div>
                                        <p class="text-muted small">Features are rendered as modular 3-pillar cards highlighting key value offerings.</p>

                                        <div id="featuresContainer">
                                            <?php if (!empty($features_data)): ?>
                                                <?php foreach ($features_data as $f_idx => $ft): ?>
                                                    <div class="dynamic-item-card feature-item">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="fw-bold small text-primary"><i class="fas fa-cube me-1"></i> Feature #<span class="ft-idx"><?= $f_idx + 1 ?></span></span>
                                                            <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="this.closest('.feature-item').remove()" title="Delete">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-md-4">
                                                                <label class="small text-muted mb-1">Icon Class</label>
                                                                <input type="text" class="form-control form-control-sm" name="features[<?= $f_idx ?>][icon]" value="<?= htmlspecialchars($ft['icon'] ?? 'fa-solid fa-gem') ?>">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label class="small text-muted mb-1">Feature Title</label>
                                                                <input type="text" class="form-control form-control-sm" name="features[<?= $f_idx ?>][title]" value="<?= htmlspecialchars($ft['title'] ?? '') ?>" placeholder="e.g. VIP Concierge Access">
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="small text-muted mb-1">Description</label>
                                                                <input type="text" class="form-control form-control-sm" name="features[<?= $f_idx ?>][desc]" value="<?= htmlspecialchars($ft['desc'] ?? '') ?>" placeholder="Brief description of this benefit...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="dynamic-item-card feature-item">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="fw-bold small text-primary"><i class="fas fa-cube me-1"></i> Feature #1</span>
                                                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="this.closest('.feature-item').remove()" title="Delete">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-md-4">
                                                            <label class="small text-muted mb-1">Icon Class</label>
                                                            <input type="text" class="form-control form-control-sm" name="features[0][icon]" value="fa-solid fa-gem">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="small text-muted mb-1">Feature Title</label>
                                                            <input type="text" class="form-control form-control-sm" name="features[0][title]" value="Premium Execution">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="small text-muted mb-1">Description</label>
                                                            <input type="text" class="form-control form-control-sm" name="features[0][desc]" value="Seamless luxury management tailored to your preference.">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: FAQ Builder -->
                        <div class="tab-pane fade" id="tab-faqs" role="tabpanel">
                            <div class="ui-card">
                                <div class="ui-card-title">
                                    <span><i class="fas fa-question-circle text-info me-2"></i>Frequently Asked Questions (FAQPage Schema)</span>
                                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill" onclick="addFaqItem()">
                                        <i class="fas fa-plus me-1"></i> Add FAQ Question
                                    </button>
                                </div>
                                <p class="text-muted small">These FAQs render both on the public service page accordion AND generate Google FAQ Schema structured data.</p>

                                <div id="faqsContainer">
                                    <?php if (!empty($faqs_data)): ?>
                                        <?php foreach ($faqs_data as $q_idx => $fq): ?>
                                            <div class="dynamic-item-card faq-item mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-bold small text-dark"><i class="fas fa-comment-dots text-info me-1"></i> FAQ Question #<span class="faq-idx"><?= $q_idx + 1 ?></span></span>
                                                    <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="this.closest('.faq-item').remove()" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" class="form-control fw-bold" name="faqs[<?= $q_idx ?>][q]" value="<?= htmlspecialchars($fq['q'] ?? '') ?>" placeholder="Question (e.g. How far in advance should we book?)">
                                                </div>
                                                <div>
                                                    <textarea class="form-control" name="faqs[<?= $q_idx ?>][a]" rows="2" placeholder="Detailed answer..."><?= htmlspecialchars($fq['a'] ?? '') ?></textarea>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="dynamic-item-card faq-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-bold small text-dark"><i class="fas fa-comment-dots text-info me-1"></i> FAQ Question #1</span>
                                                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="this.closest('.faq-item').remove()" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="mb-2">
                                                <input type="text" class="form-control fw-bold" name="faqs[0][q]" value="What does this service include?" placeholder="Question...">
                                            </div>
                                            <div>
                                                <textarea class="form-control" name="faqs[0][a]" rows="2" placeholder="Answer...">Comprehensive end-to-end planning with dedicated travel specialists.</textarea>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: Media & Icon -->
                        <div class="tab-pane fade" id="tab-media" role="tabpanel">
                            <div class="row g-4">
                                <!-- Featured Image -->
                                <div class="col-lg-7">
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-image text-primary me-2"></i>Featured Banner Image</span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Current Banner Preview</label>
                                            <div class="rounded-3 overflow-hidden shadow-sm border mb-3" style="height: 240px; background: #e2e8f0;">
                                                <img src="<?= $site . ltrim($service['image'], '/') ?>" 
                                                     alt="Service Banner" id="mediaTabPreview" class="w-100 h-100 object-fit-cover">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Image Path / URL</label>
                                            <input type="text" class="form-control" name="image" id="imageUrlInput"
                                                   value="<?= htmlspecialchars($service['image']) ?>" 
                                                   placeholder="assets/images/services/world-tours.jpg" oninput="updateMediaPreview(this.value)">
                                            <small class="text-muted">Relative site path or full HTTPS URL.</small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Upload New Image File</label>
                                            <input type="file" class="form-control" name="image_file" id="imageFileInput" accept="image/jpeg,image/png,image/webp" onchange="previewUploadedFile(this)">
                                            <small class="text-muted">JPG, PNG, or WEBP (Recommended: 1200 x 600 px).</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Icon Selector -->
                                <div class="col-lg-5">
                                    <div class="ui-card">
                                        <div class="ui-card-title">
                                            <span><i class="fas fa-icons text-primary me-2"></i>Service Icon</span>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-3 border">
                                            <div class="icon-circle shadow-sm" style="width: 52px; height: 52px; font-size: 24px;">
                                                <i class="<?= htmlspecialchars($service['icon'] ?: 'fa-solid fa-plane-departure') ?>" id="liveSelectedIcon"></i>
                                            </div>
                                            <div>
                                                <span class="small text-muted d-block">Current Class:</span>
                                                <code class="fw-bold text-primary" id="selectedIconText"><?= htmlspecialchars($service['icon']) ?></code>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Custom FontAwesome Class</label>
                                            <input type="text" class="form-control" name="icon" id="customIconInput"
                                                   value="<?= htmlspecialchars($service['icon']) ?>" oninput="selectCustomIcon(this.value)">
                                        </div>

                                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">Quick Preset Icons</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php
                                            $presets = [
                                                'fa-solid fa-plane-departure', 'fa-solid fa-earth-asia', 'fa-solid fa-hotel',
                                                'fa-solid fa-car', 'fa-solid fa-compass', 'fa-solid fa-passport',
                                                'fa-solid fa-map-location-dot', 'fa-solid fa-gem', 'fa-solid fa-wand-magic-sparkles',
                                                'fa-solid fa-umbrella-beach', 'fa-solid fa-shield-halved', 'fa-solid fa-handshake',
                                                'fa-solid fa-champagne-glasses', 'fa-solid fa-jet-fighter-up', 'fa-solid fa-tags'
                                            ];
                                            foreach ($presets as $p_icon):
                                            ?>
                                                <button type="button" class="icon-preset-btn <?= $service['icon'] === $p_icon ? 'active' : '' ?>" 
                                                        onclick="selectPresetIcon('<?= $p_icon ?>')" title="<?= $p_icon ?>">
                                                    <i class="<?= $p_icon ?>"></i>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        <?php include "footer.php"; ?>
    </section>

    <script>
        // Real-time Yoast SEO Analysis
        function runYoastAnalysis() {
            const title = document.getElementById('seoTitle').value;
            const desc = document.getElementById('seoDesc').value;
            const kw = document.getElementById('seoKeyword').value.trim().toLowerCase();

            const tLen = title.length;
            const dLen = desc.length;

            document.getElementById('titleCounter').textContent = tLen + ' / 65';
            document.getElementById('descCounter').textContent = dLen + ' / 160';
            document.getElementById('serpPreviewTitle').textContent = title || 'Vocation Travels – Service Page';
            document.getElementById('serpPreviewDesc').textContent = desc || 'Service overview description...';

            // Title Meter
            const tMeter = document.getElementById('titleMeter');
            tMeter.style.width = Math.min(100, (tLen / 65) * 100) + '%';
            tMeter.className = 'meter-fill ' + ((tLen >= 40 && tLen <= 65) ? 'bg-success' : (tLen > 0 ? 'bg-warning' : 'bg-danger'));

            // Desc Meter
            const dMeter = document.getElementById('descMeter');
            dMeter.style.width = Math.min(100, (dLen / 160) * 100) + '%';
            dMeter.className = 'meter-fill ' + ((dLen >= 120 && dLen <= 165) ? 'bg-success' : (dLen > 0 ? 'bg-warning' : 'bg-danger'));

            // Checklist tests
            const kwInTitle = kw && title.toLowerCase().includes(kw);
            const chkKwT = document.getElementById('chkKwInTitle');
            chkKwT.querySelector('.yoast-bullet').className = 'yoast-bullet ' + (kwInTitle ? 'yoast-green' : 'yoast-orange');
            document.getElementById('txtKwTitle').textContent = kwInTitle ? 'Present' : 'Missing';

            const kwInDesc = kw && desc.toLowerCase().includes(kw);
            const chkKwD = document.getElementById('chkKwInDesc');
            chkKwD.querySelector('.yoast-bullet').className = 'yoast-bullet ' + (kwInDesc ? 'yoast-green' : 'yoast-orange');
            document.getElementById('txtKwDesc').textContent = kwInDesc ? 'Present' : 'Missing';

            const titleOk = tLen >= 40 && tLen <= 65;
            const chkTOk = document.getElementById('chkTitleWidth');
            chkTOk.querySelector('.yoast-bullet').className = 'yoast-bullet ' + (titleOk ? 'yoast-green' : (tLen > 25 ? 'yoast-orange' : 'yoast-red'));

            const descOk = dLen >= 110 && dLen <= 165;
            const chkDOk = document.getElementById('chkDescWidth');
            chkDOk.querySelector('.yoast-bullet').className = 'yoast-bullet ' + (descOk ? 'yoast-green' : (dLen > 70 ? 'yoast-orange' : 'yoast-red'));

            // Calculate Score
            let score = 100;
            if (!kw) score -= 20;
            else {
                if (!kwInTitle) score -= 10;
                if (!kwInDesc) score -= 10;
            }
            if (!titleOk) score -= 15;
            if (!descOk) score -= 15;
            score = Math.max(35, Math.min(100, score));

            const badge = document.getElementById('yoastScoreBadge');
            badge.textContent = 'Score: ' + score + '/100';
            badge.className = 'badge fs-6 ' + (score >= 85 ? 'bg-success' : (score >= 65 ? 'bg-warning text-dark' : 'bg-danger'));

            document.getElementById('tabScoreBadge').textContent = score;
            document.getElementById('tabScoreBadge').className = 'badge rounded-pill ms-1 ' + (score >= 85 ? 'bg-success' : (score >= 65 ? 'bg-warning text-dark' : 'bg-danger'));
            document.getElementById('heroScoreDisplay').textContent = score + '%';
        }

        function syncServiceTitle() {
            const name = document.getElementById('serviceName').value;
            document.getElementById('heroNameDisplay').textContent = name || 'Service Name';
        }

        // Switch Desktop vs Mobile SERP simulator
        function switchSerpView(mode) {
            const container = document.getElementById('serpCardContainer');
            const btnDesk = document.getElementById('btnPreviewDesktop');
            const btnMob = document.getElementById('btnPreviewMobile');

            if (mode === 'mobile') {
                container.classList.add('mobile-view');
                btnMob.classList.add('active');
                btnDesk.classList.remove('active');
            } else {
                container.classList.remove('mobile-view');
                btnDesk.classList.add('active');
                btnMob.classList.remove('active');
            }
        }

        // Icon Picker handlers
        function selectPresetIcon(iconClass) {
            document.getElementById('customIconInput').value = iconClass;
            selectCustomIcon(iconClass);

            document.querySelectorAll('.icon-preset-btn').forEach(btn => {
                if (btn.getAttribute('title') === iconClass) btn.classList.add('active');
                else btn.classList.remove('active');
            });
        }

        function selectCustomIcon(iconClass) {
            document.getElementById('liveSelectedIcon').className = iconClass;
            document.getElementById('heroIconDisplay').className = iconClass;
            document.getElementById('selectedIconText').textContent = iconClass;
        }

        // Media URL preview
        function updateMediaPreview(url) {
            const fullUrl = (url.startsWith('http') || url.startsWith('//')) ? url : ('<?= $site ?>' + url.replace(/^\//, ''));
            document.getElementById('mediaTabPreview').src = fullUrl;
            document.getElementById('sideImagePreview').src = fullUrl;
        }

        function previewUploadedFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('mediaTabPreview').src = e.target.result;
                    document.getElementById('sideImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Dynamic Highlights row addition
        function addHighlightRow() {
            const container = document.getElementById('highlightsContainer');
            const div = document.createElement('div');
            div.className = 'dynamic-item-card d-flex gap-2 align-items-center highlight-item';
            div.innerHTML = `
                <span class="text-muted"><i class="fas fa-grip-vertical"></i></span>
                <input type="text" class="form-control" name="highlights[]" value="" placeholder="New highlight point..." required>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.highlight-item').remove()" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Dynamic Feature card addition
        function addFeatureCard() {
            const container = document.getElementById('featuresContainer');
            const count = container.querySelectorAll('.feature-item').length;
            const div = document.createElement('div');
            div.className = 'dynamic-item-card feature-item';
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold small text-primary"><i class="fas fa-cube me-1"></i> Feature #<span class="ft-idx">${count + 1}</span></span>
                    <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="this.closest('.feature-item').remove()" title="Delete">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="small text-muted mb-1">Icon Class</label>
                        <input type="text" class="form-control form-control-sm" name="features[${count}][icon]" value="fa-solid fa-star">
                    </div>
                    <div class="col-md-8">
                        <label class="small text-muted mb-1">Feature Title</label>
                        <input type="text" class="form-control form-control-sm" name="features[${count}][title]" value="" placeholder="Feature title...">
                    </div>
                    <div class="col-12">
                        <label class="small text-muted mb-1">Description</label>
                        <input type="text" class="form-control form-control-sm" name="features[${count}][desc]" value="" placeholder="Feature description...">
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        // Dynamic FAQ item addition
        function addFaqItem() {
            const container = document.getElementById('faqsContainer');
            const count = container.querySelectorAll('.faq-item').length;
            const div = document.createElement('div');
            div.className = 'dynamic-item-card faq-item mb-3';
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold small text-dark"><i class="fas fa-comment-dots text-info me-1"></i> FAQ Question #<span class="faq-idx">${count + 1}</span></span>
                    <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="this.closest('.faq-item').remove()" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control fw-bold" name="faqs[${count}][q]" value="" placeholder="Question...">
                </div>
                <div>
                    <textarea class="form-control" name="faqs[${count}][a]" rows="2" placeholder="Answer..."></textarea>
                </div>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Overview formatting helper
        function formatOverviewSpacing() {
            const textarea = document.getElementById('overviewTextInput');
            let text = textarea.value.trim();
            // Normalize paragraph breaks
            text = text.replace(/\r\n/g, '\n').replace(/\n{3,}/g, '\n\n');
            textarea.value = text;
        }

        // Copy URL
        function copyUrlToClipboard() {
            const input = document.getElementById('liveUrlCopyField');
            input.select();
            document.execCommand('copy');
            alert('Live URL copied to clipboard: ' + input.value);
        }

        // Keyboard Shortcut: Ctrl+S / Cmd+S to submit form
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('serviceEditForm').submit();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            runYoastAnalysis();
        });
    </script>
</body>
</html>
