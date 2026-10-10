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

    $stmt = $conn->prepare("UPDATE services_cms SET name = ?, category = ?, tagline = ?, icon = ?, image = ?, overview_text = ?, meta_title = ?, meta_description = ?, focus_keyword = ?, seo_score = ?, status = ?, updated_at = NOW() WHERE slug = ?");
    if ($stmt) {
        $stmt->bind_param("sssssssssiss", $name, $category, $tagline, $icon, $image, $overview_text, $meta_title, $meta_description, $focus_keyword, $score, $status, $slug);
        if ($stmt->execute()) {
            $success_message = "Service '{$name}' saved successfully! Yoast SEO Score: {$score}/100.";
        } else {
            $error_message = "Failed to update service: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch service data
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Service: <?= htmlspecialchars($service['name']) ?> | Admin</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>

    <style>
        .serp-box {
            background: #fff;
            border: 1px solid #dadce0;
            border-radius: 12px;
            padding: 18px 22px;
            font-family: Arial, sans-serif;
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
        .serp-breadcrumb { color: #4d5156; font-size: 12px; }
        .serp-title {
            color: #1a0dab;
            font-size: 19px;
            font-weight: 400;
            line-height: 1.3;
            margin-bottom: 6px;
        }
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
        .yoast-green { background: #22c55e; }
        .yoast-orange { background: #f59e0b; }
        .yoast-red { background: #ef4444; }
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

                <!-- Header -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div>
                        <div class="mb-1">
                            <a href="services-manager.php" class="text-decoration-none text-muted small">
                                <i class="fas fa-arrow-left me-1"></i> Back to Services Manager
                            </a>
                        </div>
                        <h2 class="mb-1 fw-bold text-dark">
                            <i class="<?= htmlspecialchars($service['icon'] ?: 'fa-solid fa-plane-departure') ?> text-primary me-2"></i>
                            Edit Service: <?= htmlspecialchars($service['name']) ?>
                        </h2>
                        <code class="text-muted small"><?= $live_url ?></code>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <a href="<?= $live_url ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> View Live Page
                        </a>
                        <button type="button" onclick="document.getElementById('serviceEditForm').submit()" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </div>

                <form id="serviceEditForm" method="POST" action="edit-service.php?slug=<?= urlencode($slug) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save_service">

                    <div class="row g-4">
                        <!-- Left Column: Service Details -->
                        <div class="col-lg-7">
                            <div class="white_card p-4 shadow-sm mb-4">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-info-circle text-primary me-2"></i>Service Information
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold small">Service Name *</label>
                                        <input type="text" class="form-control" name="name" id="serviceName" required
                                               value="<?= htmlspecialchars($service['name']) ?>" oninput="syncSeoDefaults()">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Category *</label>
                                        <select class="form-select" name="category">
                                            <option value="core" <?= $service['category'] === 'core' ? 'selected' : '' ?>>Core Service</option>
                                            <option value="specialized" <?= $service['category'] === 'specialized' ? 'selected' : '' ?>>Specialized Service</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Tagline / Short Summary *</label>
                                        <textarea class="form-control" name="tagline" rows="2" required><?= htmlspecialchars($service['tagline']) ?></textarea>
                                        <small class="text-muted">Displayed in cards across the Services hub & category listings.</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">FontAwesome Icon Class</label>
                                        <input type="text" class="form-control" name="icon" 
                                               value="<?= htmlspecialchars($service['icon']) ?>" placeholder="e.g. fa-solid fa-gem">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Status</label>
                                        <select class="form-select" name="status">
                                            <option value="active" <?= $service['status'] === 'active' ? 'selected' : '' ?>>Active (Published)</option>
                                            <option value="inactive" <?= $service['status'] === 'inactive' ? 'selected' : '' ?>>Inactive (Hidden)</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Featured Banner Image</label>
                                        <div class="d-flex gap-3 align-items-center mb-2">
                                            <img src="<?= $site . ltrim($service['image'], '/') ?>" 
                                                 alt="Service Image" class="rounded shadow-sm" style="width: 100px; height: 60px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control mb-1" name="image" 
                                                       value="<?= htmlspecialchars($service['image']) ?>" placeholder="assets/images/services/...">
                                                <input type="file" class="form-control form-control-sm" name="image_file" accept="image/*">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Detailed Overview Content</label>
                                        <textarea class="form-control font-monospace" name="overview_text" rows="8"
                                                  placeholder="Detailed paragraphs explaining this travel service..."><?= htmlspecialchars($service['overview_text']) ?></textarea>
                                        <small class="text-muted">Separate multiple paragraphs with blank lines (double Enter).</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Live Yoast SEO Panel -->
                        <div class="col-lg-5">
                            <div class="white_card p-4 shadow-sm mb-4">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                    <h5 class="fw-bold mb-0">
                                        <i class="fas fa-chart-line text-success me-2"></i>Yoast SEO Optimization
                                    </h5>
                                    <span class="badge bg-success fs-6" id="yoastScoreBadge">Score: <?= $service['seo_score'] ?>/100</span>
                                </div>

                                <!-- Focus Keyphrase -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Focus Keyphrase *</label>
                                    <input type="text" class="form-control" name="focus_keyword" id="seoKeyword" required
                                           value="<?= htmlspecialchars($service['focus_keyword']) ?>" oninput="runYoastAnalysis()">
                                    <small class="text-muted">Primary search query target (e.g. "luxury tour packages India")</small>
                                </div>

                                <!-- Meta Title -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold small mb-0">SEO Meta Title *</label>
                                        <span class="small text-muted" id="titleCounter">0 / 65</span>
                                    </div>
                                    <input type="text" class="form-control" name="meta_title" id="seoTitle" required
                                           value="<?= htmlspecialchars($service['meta_title']) ?>" oninput="runYoastAnalysis()">
                                    <div class="meter-bar">
                                        <div class="meter-fill" id="titleMeter" style="width: 0%;"></div>
                                    </div>
                                </div>

                                <!-- Meta Description -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold small mb-0">Meta Description *</label>
                                        <span class="small text-muted" id="descCounter">0 / 160</span>
                                    </div>
                                    <textarea class="form-control" name="meta_description" id="seoDesc" rows="3" required oninput="runYoastAnalysis()"><?= htmlspecialchars($service['meta_description']) ?></textarea>
                                    <div class="meter-bar">
                                        <div class="meter-fill" id="descMeter" style="width: 0%;"></div>
                                    </div>
                                </div>

                                <!-- Google SERP Preview Box -->
                                <div class="mb-3 pt-2">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-2">Google SERP Snippet Preview</label>
                                    <div class="serp-box shadow-sm">
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
                                </div>

                                <!-- Real-time Yoast Checklist -->
                                <div class="bg-light p-3 rounded-3 border">
                                    <h6 class="fw-bold small text-uppercase mb-2">Yoast Analysis Results</h6>
                                    <div class="space-y-1 small">
                                        <div class="d-flex align-items-center mb-1.5" id="chkKwInTitle">
                                            <span class="yoast-bullet yoast-green"></span>
                                            <span>Focus keyphrase in SEO Title</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1.5" id="chkKwInDesc">
                                            <span class="yoast-bullet yoast-green"></span>
                                            <span>Focus keyphrase in Meta Description</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1.5" id="chkTitleWidth">
                                            <span class="yoast-bullet yoast-green"></span>
                                            <span>SEO Title optimal width (45 - 65 chars)</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1.5" id="chkDescWidth">
                                            <span class="yoast-bullet yoast-green"></span>
                                            <span>Meta Description width (120 - 165 chars)</span>
                                        </div>
                                        <div class="d-flex align-items-center" id="chkSlugReadability">
                                            <span class="yoast-bullet yoast-green"></span>
                                            <span>Clean search-friendly slug</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-success w-100 py-2.5 fw-bold">
                                        <i class="fas fa-save me-1"></i> Save Service & SEO Data
                                    </button>
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

            const kwInDesc = kw && desc.toLowerCase().includes(kw);
            const chkKwD = document.getElementById('chkKwInDesc');
            chkKwD.querySelector('.yoast-bullet').className = 'yoast-bullet ' + (kwInDesc ? 'yoast-green' : 'yoast-orange');

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
        }

        function syncSeoDefaults() {
            const name = document.getElementById('serviceName').value;
            const titleField = document.getElementById('seoTitle');
            if (!titleField.value || titleField.value.includes('Vocation Travels')) {
                titleField.value = name + ' | Vocation Travels And Tours';
            }
            runYoastAnalysis();
        }

        document.addEventListener('DOMContentLoaded', function() {
            runYoastAnalysis();
        });
    </script>
</body>
</html>
