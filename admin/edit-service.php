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
        faqs_json = ?, 
        meta_title = ?, 
        meta_description = ?, 
        focus_keyword = ?, 
        seo_score = ?, 
        status = ?, 
        updated_at = NOW() 
        WHERE slug = ?");

    if ($stmt) {
        $stmt->bind_param("ssssssssssisss", 
            $name, 
            $category, 
            $tagline, 
            $icon, 
            $image, 
            $overview_text, 
            $highlights_json, 
            $faqs_json, 
            $meta_title, 
            $meta_description, 
            $focus_keyword, 
            $score, 
            $status, 
            $slug
        );
        if ($stmt->execute()) {
            $success_message = "Service '{$name}' saved successfully! Yoast SEO Score: {$score}/100.";
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
$highlights_data = json_decode($service['highlights_json'] ?? '[]', true) ?: [];
$faqs_data = json_decode($service['faqs_json'] ?? '[]', true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Service: <?= htmlspecialchars($service['name']) ?> | Admin</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>

    <!-- CKEditor 4 Standard for Rich Text Editing -->
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    <style>
        .page-header-simple {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 24px;
            margin: -20px -20px 24px -20px;
        }
        .clean-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .clean-card-header {
            background: #ffffff;
            padding: 16px 20px;
            border-bottom: 1px solid #edf2f7;
            font-weight: 700;
            font-size: 15px;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .clean-card-body {
            padding: 20px;
        }
        .permalink-badge {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #475569;
            margin-top: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        /* Icon Preset Buttons */
        .icon-btn-choice {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .icon-btn-choice:hover, .icon-btn-choice.active {
            border-color: #4f46e5;
            background: #eef2ff;
            color: #4f46e5;
        }
        /* Google SERP Card Preview */
        .serp-box {
            background: #ffffff;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 14px 18px;
            font-family: Arial, sans-serif;
            max-width: 600px;
        }
        .serp-url {
            font-size: 13px;
            color: #202124;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 3px;
        }
        .serp-favicon {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e8f0fe;
            color: #1a73e8;
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .serp-title {
            color: #1a0dab;
            font-size: 18px;
            line-height: 1.3;
            margin-bottom: 4px;
            cursor: pointer;
        }
        .serp-snippet {
            color: #4d5156;
            font-size: 13px;
            line-height: 1.45;
        }
        .meter-bar {
            height: 5px;
            border-radius: 3px;
            background: #e2e8f0;
            overflow: hidden;
            margin-top: 4px;
        }
        .meter-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        .yoast-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .yoast-dot-green { background: #10b981; }
        .yoast-dot-orange { background: #f59e0b; }
        .yoast-dot-red { background: #ef4444; }
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
                        <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($success_message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($error_message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Start -->
                <form id="serviceForm" method="POST" action="edit-service.php?slug=<?= urlencode($slug) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save_service">

                    <!-- Top Clean Header Bar -->
                    <div class="page-header-simple d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <a href="services-manager.php" class="text-muted text-decoration-none small">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Services
                                </a>
                                <span class="text-muted small">/</span>
                                <span class="badge bg-light text-dark border"><?= ucfirst($service['category']) ?></span>
                            </div>
                            <h2 class="mb-0 fw-bold text-dark fs-4">
                                <i class="<?= htmlspecialchars($service['icon'] ?: 'fa-solid fa-plane-departure') ?> text-primary me-2" id="headerIcon"></i>
                                Edit Service: <span id="headerServiceName"><?= htmlspecialchars($service['name']) ?></span>
                            </h2>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <a href="<?= $live_url ?>" target="_blank" class="btn btn-outline-secondary btn-sm px-3">
                                <i class="fas fa-external-link-alt me-1"></i> View on Website
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm" id="saveBtn">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>

                    <!-- Main Grid Layout: Left Content (Col-8) | Right Settings (Col-4) -->
                    <div class="row g-4">

                        <!-- LEFT COLUMN: Main Service Content & Text Editor -->
                        <div class="col-lg-8">

                            <!-- Card 1: Service Title & Overview Editor -->
                            <div class="clean-card">
                                <div class="clean-card-header">
                                    <span><i class="fas fa-pen text-primary me-2"></i>Service Information</span>
                                </div>
                                <div class="clean-card-body">
                                    <!-- Service Name -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Service Name *</label>
                                        <input type="text" class="form-control form-control-lg fs-5" name="name" id="serviceName" required
                                               value="<?= htmlspecialchars($service['name']) ?>" oninput="syncTitles(this.value)">
                                        
                                        <!-- Permalink -->
                                        <div class="permalink-badge">
                                            <span><strong>Permalink:</strong> <code><?= $live_url ?></code></span>
                                            <a href="<?= $live_url ?>" target="_blank" class="text-primary small text-decoration-none">
                                                <i class="fas fa-external-link-alt"></i> Visit Page
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Tagline / Short Summary -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark">Short Tagline / Summary Card Description *</label>
                                        <textarea class="form-control" name="tagline" rows="2" required placeholder="A brief 1-2 sentence description shown in service lists and category cards..."><?= htmlspecialchars($service['tagline']) ?></textarea>
                                        <small class="text-muted">Displayed on the /services/ overview hub and tour category cards.</small>
                                    </div>

                                    <!-- Rich Text Editor for Detailed Overview -->
                                    <div class="mb-2">
                                        <label class="form-label fw-bold text-dark d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-align-left text-primary me-1"></i> Detailed Service Overview (Rich Text Editor)</span>
                                            <small class="text-muted fw-normal">Use bold, lists, and headings freely</small>
                                        </label>
                                        
                                        <textarea name="overview_text" id="editor" class="form-control" rows="12"><?= htmlspecialchars($service['overview_text']) ?></textarea>
                                        <small class="text-muted mt-1 d-block">
                                            This is the main content area of your service page. You can format paragraphs, add bullet points, and highlight key benefits.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Yoast SEO Optimization Box -->
                            <div class="clean-card">
                                <div class="clean-card-header">
                                    <span><i class="fas fa-chart-line text-success me-2"></i>Yoast SEO Optimization</span>
                                    <span class="badge bg-success fs-6" id="yoastScoreBadge">Score: <?= $service['seo_score'] ?>/100</span>
                                </div>
                                <div class="clean-card-body">
                                    <!-- Focus Keyphrase -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-dark">Focus Keyphrase *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-key text-warning"></i></span>
                                            <input type="text" class="form-control" name="focus_keyword" id="seoKeyword" required
                                                   value="<?= htmlspecialchars($service['focus_keyword']) ?>" oninput="runYoastAudit()"
                                                   placeholder="e.g. domestic tour packages India, holiday planner Delhi">
                                        </div>
                                        <small class="text-muted">Primary search query you want this page to rank for on Google.</small>
                                    </div>

                                    <!-- SEO Meta Title -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold small text-dark mb-0">SEO Meta Title *</label>
                                            <span class="small text-muted" id="titleCharCount">0 / 65</span>
                                        </div>
                                        <input type="text" class="form-control" name="meta_title" id="seoTitle" required
                                               value="<?= htmlspecialchars($service['meta_title']) ?>" oninput="runYoastAudit()"
                                               placeholder="Title tag displayed in Google search results">
                                        <div class="meter-bar">
                                            <div class="meter-fill" id="titleBar" style="width: 0%;"></div>
                                        </div>
                                        <small class="text-muted">Ideal length: 45 to 65 characters.</small>
                                    </div>

                                    <!-- Meta Description -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold small text-dark mb-0">Meta Description *</label>
                                            <span class="small text-muted" id="descCharCount">0 / 160</span>
                                        </div>
                                        <textarea class="form-control" name="meta_description" id="seoDesc" rows="3" required
                                                  oninput="runYoastAudit()"
                                                  placeholder="The summary text snippet that appears beneath your title on Google..."><?= htmlspecialchars($service['meta_description']) ?></textarea>
                                        <div class="meter-bar">
                                            <div class="meter-fill" id="descBar" style="width: 0%;"></div>
                                        </div>
                                        <small class="text-muted">Ideal length: 120 to 165 characters.</small>
                                    </div>

                                    <!-- Google Search Snippet Simulator -->
                                    <div class="mb-3 pt-2">
                                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">Google Search Snippet Preview</label>
                                        <div class="serp-box shadow-sm">
                                            <div class="serp-url">
                                                <div class="serp-favicon">V</div>
                                                <span>vocationtravels.com &rsaquo; services &rsaquo; <?= htmlspecialchars($service['slug']) ?></span>
                                            </div>
                                            <div class="serp-title" id="serpTitlePreview"><?= htmlspecialchars($service['meta_title']) ?></div>
                                            <div class="serp-snippet" id="serpDescPreview"><?= htmlspecialchars($service['meta_description']) ?></div>
                                        </div>
                                    </div>

                                    <!-- Yoast Live Checklist -->
                                    <div class="bg-light p-3 rounded border mt-3">
                                        <h6 class="fw-bold small text-uppercase mb-2">Yoast SEO Checks</h6>
                                        <div class="small space-y-1">
                                            <div class="d-flex align-items-center mb-1" id="chkKwTitle">
                                                <span class="yoast-dot yoast-dot-green"></span>
                                                <span>Focus keyphrase in SEO Title: <strong id="resKwTitle">Yes</strong></span>
                                            </div>
                                            <div class="d-flex align-items-center mb-1" id="chkKwDesc">
                                                <span class="yoast-dot yoast-dot-green"></span>
                                                <span>Focus keyphrase in Meta Description: <strong id="resKwDesc">Yes</strong></span>
                                            </div>
                                            <div class="d-flex align-items-center mb-1" id="chkTitleLen">
                                                <span class="yoast-dot yoast-dot-green"></span>
                                                <span>SEO Title optimal width (45 - 65 chars)</span>
                                            </div>
                                            <div class="d-flex align-items-center" id="chkDescLen">
                                                <span class="yoast-dot yoast-dot-green"></span>
                                                <span>Meta Description optimal width (120 - 165 chars)</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Card 3: Key Highlights & FAQs (Collapsible for Cleanliness) -->
                            <div class="clean-card">
                                <div class="clean-card-header" data-bs-toggle="collapse" data-bs-target="#optionalAddons" style="cursor: pointer;">
                                    <span>
                                        <i class="fas fa-list-check text-primary me-2"></i>
                                        Highlights & FAQs (Optional Additions)
                                    </span>
                                    <span class="text-muted small">
                                        <i class="fas fa-chevron-down"></i> Click to Expand
                                    </span>
                                </div>
                                <div class="collapse" id="optionalAddons">
                                    <div class="clean-card-body border-top">

                                        <!-- Highlights Section -->
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label fw-bold text-dark mb-0">Key Highlights (Bullet Points)</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-2" onclick="addHighlightItem()">
                                                    <i class="fas fa-plus me-1"></i> Add Bullet
                                                </button>
                                            </div>
                                            <div id="highlightsList" class="space-y-2">
                                                <?php foreach ($highlights_data as $hl): ?>
                                                    <div class="input-group mb-2 hl-row">
                                                        <span class="input-group-text bg-white"><i class="fas fa-check text-success"></i></span>
                                                        <input type="text" class="form-control" name="highlights[]" value="<?= htmlspecialchars($hl) ?>" placeholder="e.g. 5-Star stays and curated local sightseeing">
                                                        <button type="button" class="btn btn-outline-danger" onclick="this.closest('.hl-row').remove()">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <!-- FAQs Section -->
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label fw-bold text-dark mb-0">Frequently Asked Questions (FAQ Accordion)</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-2" onclick="addFaqRow()">
                                                    <i class="fas fa-plus me-1"></i> Add Question
                                                </button>
                                            </div>
                                            <div id="faqsList">
                                                <?php foreach ($faqs_data as $idx => $faq): ?>
                                                    <div class="border rounded p-3 mb-2 bg-light faq-row">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="fw-bold small text-dark"><i class="fas fa-question-circle text-primary me-1"></i> Question #<?= $idx + 1 ?></span>
                                                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="this.closest('.faq-row').remove()">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" class="form-control mb-2" name="faqs[<?= $idx ?>][q]" value="<?= htmlspecialchars($faq['q'] ?? '') ?>" placeholder="Question...">
                                                        <textarea class="form-control" name="faqs[<?= $idx ?>][a]" rows="2" placeholder="Answer..."><?= htmlspecialchars($faq['a'] ?? '') ?></textarea>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT COLUMN: Publish Settings, Image & Icon (Col-4) -->
                        <div class="col-lg-4">

                            <!-- Card 1: Publish & Status -->
                            <div class="clean-card">
                                <div class="clean-card-header">
                                    <span><i class="fas fa-globe text-primary me-2"></i>Publishing Settings</span>
                                </div>
                                <div class="clean-card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-dark">Status</label>
                                        <select class="form-select" name="status">
                                            <option value="active" <?= $service['status'] === 'active' ? 'selected' : '' ?>>🟢 Active (Published)</option>
                                            <option value="inactive" <?= $service['status'] === 'inactive' ? 'selected' : '' ?>>🔴 Inactive (Hidden)</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-dark">Category</label>
                                        <select class="form-select" name="category">
                                            <option value="core" <?= $service['category'] === 'core' ? 'selected' : '' ?>>Core Service</option>
                                            <option value="specialized" <?= $service['category'] === 'specialized' ? 'selected' : '' ?>>Specialized Service</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 py-2.5 fw-bold shadow-sm">
                                        <i class="fas fa-save me-1"></i> Save Changes
                                    </button>
                                </div>
                            </div>

                            <!-- Card 2: Featured Banner Image -->
                            <div class="clean-card">
                                <div class="clean-card-header">
                                    <span><i class="fas fa-image text-primary me-2"></i>Featured Banner Image</span>
                                </div>
                                <div class="clean-card-body">
                                    <div class="border rounded overflow-hidden mb-3 bg-light text-center" style="height: 180px;">
                                        <img src="<?= $site . ltrim($service['image'], '/') ?>" 
                                             alt="Service Banner" id="bannerImgPreview" class="w-100 h-100" style="object-fit: cover;">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-dark">Upload New Image</label>
                                        <input type="file" class="form-control form-control-sm" name="image_file" accept="image/*" onchange="previewUpload(this)">
                                    </div>

                                    <div>
                                        <label class="form-label fw-bold small text-dark">Image File Path</label>
                                        <input type="text" class="form-control form-control-sm" name="image" id="imagePathInput"
                                               value="<?= htmlspecialchars($service['image']) ?>" oninput="previewUrl(this.value)">
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Service Icon -->
                            <div class="clean-card">
                                <div class="clean-card-header">
                                    <span><i class="fas fa-icons text-primary me-2"></i>Service Icon</span>
                                </div>
                                <div class="clean-card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3 p-2 bg-light rounded border">
                                        <div class="bg-white rounded border d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px; font-size: 22px;">
                                            <i class="<?= htmlspecialchars($service['icon'] ?: 'fa-solid fa-plane-departure') ?>" id="sideIconPreview"></i>
                                        </div>
                                        <div>
                                            <div class="small text-muted">FontAwesome Class:</div>
                                            <code class="fw-bold" id="iconCodeDisplay"><?= htmlspecialchars($service['icon']) ?></code>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-dark">Custom Icon Class</label>
                                        <input type="text" class="form-control form-control-sm" name="icon" id="iconInput"
                                               value="<?= htmlspecialchars($service['icon']) ?>" oninput="updateIcon(this.value)">
                                    </div>

                                    <label class="form-label fw-bold small text-muted text-uppercase mb-2">Quick Icons</label>
                                    <div class="d-flex flex-wrap gap-1.5">
                                        <?php
                                        $quick_icons = [
                                            'fa-solid fa-plane-departure', 'fa-solid fa-earth-asia', 'fa-solid fa-hotel',
                                            'fa-solid fa-car', 'fa-solid fa-compass', 'fa-solid fa-passport',
                                            'fa-solid fa-map-location-dot', 'fa-solid fa-gem', 'fa-solid fa-umbrella-beach',
                                            'fa-solid fa-shield-halved', 'fa-solid fa-handshake', 'fa-solid fa-wand-magic-sparkles'
                                        ];
                                        foreach ($quick_icons as $qi):
                                        ?>
                                            <button type="button" class="icon-btn-choice <?= $service['icon'] === $qi ? 'active' : '' ?>" 
                                                    onclick="chooseIcon('<?= $qi ?>')" title="<?= $qi ?>">
                                                <i class="<?= $qi ?>"></i>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4: Stats Summary -->
                            <div class="clean-card">
                                <div class="clean-card-header">
                                    <span><i class="fas fa-chart-pie text-primary me-2"></i>Engagement</span>
                                </div>
                                <div class="clean-card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small"><i class="fas fa-eye me-1"></i> Total Views</span>
                                        <strong class="text-dark"><?= $service['views_count'] ?></strong>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small"><i class="fas fa-envelope me-1"></i> Inquiries Generated</span>
                                        <strong class="text-primary"><?= $service['inquiries_count'] ?></strong>
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

    <!-- CKEditor Initialization & Scripts -->
    <script>
        // 1. Initialize CKEditor 4 with standard formatting tools
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('editor', {
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote'] },
                    { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'links', items: ['Link', 'Unlink'] },
                    { name: 'insert', items: ['Table', 'HorizontalRule'] },
                    { name: 'tools', items: ['Maximize', 'Source'] }
                ],
                height: 380,
                removePlugins: 'elementspath',
                resize_enabled: true
            });
        }

        // Make sure CKEditor updates textarea on form submission
        document.getElementById('serviceForm').addEventListener('submit', function() {
            if (typeof CKEDITOR !== 'undefined') {
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }
        });

        // 2. Real-time Yoast SEO Audit
        function runYoastAudit() {
            const title = document.getElementById('seoTitle').value;
            const desc = document.getElementById('seoDesc').value;
            const kw = document.getElementById('seoKeyword').value.trim().toLowerCase();

            const tLen = title.length;
            const dLen = desc.length;

            document.getElementById('titleCharCount').textContent = tLen + ' / 65';
            document.getElementById('descCharCount').textContent = dLen + ' / 160';

            // Meters
            const tBar = document.getElementById('titleBar');
            tBar.style.width = Math.min(100, (tLen / 65) * 100) + '%';
            tBar.className = 'meter-fill ' + ((tLen >= 40 && tLen <= 65) ? 'bg-success' : (tLen > 0 ? 'bg-warning' : 'bg-danger'));

            const dBar = document.getElementById('descBar');
            dBar.style.width = Math.min(100, (dLen / 160) * 100) + '%';
            dBar.className = 'meter-fill ' + ((dLen >= 120 && dLen <= 165) ? 'bg-success' : (dLen > 0 ? 'bg-warning' : 'bg-danger'));

            // SERP preview update
            document.getElementById('serpTitlePreview').textContent = title || 'Service Title | Vocation Travels';
            document.getElementById('serpDescPreview').textContent = desc || 'Service overview description snippet...';

            // Checks
            const kwInTitle = kw && title.toLowerCase().includes(kw);
            const chkKwT = document.getElementById('chkKwTitle');
            chkKwT.querySelector('.yoast-dot').className = 'yoast-dot ' + (kwInTitle ? 'yoast-dot-green' : 'yoast-dot-orange');
            document.getElementById('resKwTitle').textContent = kwInTitle ? 'Yes' : 'Missing';

            const kwInDesc = kw && desc.toLowerCase().includes(kw);
            const chkKwD = document.getElementById('chkKwDesc');
            chkKwD.querySelector('.yoast-dot').className = 'yoast-dot ' + (kwInDesc ? 'yoast-dot-green' : 'yoast-dot-orange');
            document.getElementById('resKwDesc').textContent = kwInDesc ? 'Yes' : 'Missing';

            const titleOk = tLen >= 40 && tLen <= 65;
            document.getElementById('chkTitleLen').querySelector('.yoast-dot').className = 'yoast-dot ' + (titleOk ? 'yoast-dot-green' : 'yoast-dot-orange');

            const descOk = dLen >= 110 && dLen <= 165;
            document.getElementById('chkDescLen').querySelector('.yoast-dot').className = 'yoast-dot ' + (descOk ? 'yoast-dot-green' : 'yoast-dot-orange');

            // Score
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
        }

        function syncTitles(name) {
            document.getElementById('headerServiceName').textContent = name || 'Service';
        }

        // Icon Picker
        function chooseIcon(iconClass) {
            document.getElementById('iconInput').value = iconClass;
            updateIcon(iconClass);
            document.querySelectorAll('.icon-btn-choice').forEach(btn => {
                if (btn.getAttribute('title') === iconClass) btn.classList.add('active');
                else btn.classList.remove('active');
            });
        }

        function updateIcon(iconClass) {
            document.getElementById('sideIconPreview').className = iconClass;
            document.getElementById('headerIcon').className = iconClass + ' text-primary me-2';
            document.getElementById('iconCodeDisplay').textContent = iconClass;
        }

        // Image Previews
        function previewUpload(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('bannerImgPreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewUrl(url) {
            const fullUrl = (url.startsWith('http') || url.startsWith('//')) ? url : ('<?= $site ?>' + url.replace(/^\//, ''));
            document.getElementById('bannerImgPreview').src = fullUrl;
        }

        // Add Highlight row
        function addHighlightItem() {
            const container = document.getElementById('highlightsList');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 hl-row';
            div.innerHTML = `
                <span class="input-group-text bg-white"><i class="fas fa-check text-success"></i></span>
                <input type="text" class="form-control" name="highlights[]" value="" placeholder="New highlight bullet..." required>
                <button type="button" class="btn btn-outline-danger" onclick="this.closest('.hl-row').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Add FAQ row
        function addFaqRow() {
            const container = document.getElementById('faqsList');
            const count = container.querySelectorAll('.faq-row').length;
            const div = document.createElement('div');
            div.className = 'border rounded p-3 mb-2 bg-light faq-row';
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold small text-dark"><i class="fas fa-question-circle text-primary me-1"></i> Question #${count + 1}</span>
                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="this.closest('.faq-row').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <input type="text" class="form-control mb-2" name="faqs[${count}][q]" value="" placeholder="Question...">
                <textarea class="form-control" name="faqs[${count}][a]" rows="2" placeholder="Answer..."></textarea>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Ctrl+S / Cmd+S save shortcut
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('serviceForm').submit();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            runYoastAudit();
        });
    </script>
</body>
</html>
