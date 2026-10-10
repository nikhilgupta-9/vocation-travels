<?php
session_start();
include "db-conn.php";

$countries = [
    'usa' => 'USA',
    'canada' => 'Canada',
    'uk' => 'United Kingdom',
    'europe' => 'Europe (Schengen)',
    'australia' => 'Australia',
    'japan' => 'Japan',
    'singapore' => 'Singapore',
    'uae' => 'UAE / Dubai',
];

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $slug_input = trim($_POST['slug'] ?? '');
    $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($slug_input !== '' ? $slug_input : $name)));
    $slug = trim($slug, '-');
    $city_order = (int) ($_POST['city_order'] ?? 0);
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $meta_keywords = trim($_POST['meta_keywords'] ?? '');
    $hero_h1 = trim($_POST['hero_h1'] ?? '');
    $hero_tagline = trim($_POST['hero_tagline'] ?? '');
    $intro_heading = trim($_POST['intro_heading'] ?? '');
    $intro = trim($_POST['intro'] ?? '');
    $status = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';

    if ($name === '') $errors[] = "City name is required.";
    if ($slug === '') $errors[] = "Slug could not be generated — please set one manually.";
    if ($meta_title === '') $errors[] = "Meta title is required.";
    if ($meta_description === '') $errors[] = "Meta description is required.";
    if ($hero_h1 === '') $errors[] = "Hero H1 is required.";
    if ($hero_tagline === '') $errors[] = "Hero tagline is required.";
    if ($intro_heading === '') $errors[] = "Intro heading is required.";
    if ($intro === '') $errors[] = "Intro paragraph is required.";

    $services = [];
    foreach ($_POST['services']['title'] ?? [] as $i => $title) {
        $title = trim($title);
        if ($title === '') continue;
        $services[] = [
            'title' => $title,
            'desc' => trim($_POST['services']['desc'][$i] ?? ''),
            'icon' => trim($_POST['services']['icon'][$i] ?? '') ?: 'fa-passport',
            'country_link' => trim($_POST['services']['country_link'][$i] ?? ''),
        ];
    }

    $faqs = [];
    foreach ($_POST['faqs']['q'] ?? [] as $i => $q) {
        $q = trim($q);
        $a = trim($_POST['faqs']['a'][$i] ?? '');
        if ($q === '' || $a === '') continue;
        $faqs[] = ['q' => $q, 'a' => $a];
    }

    if (!$errors) {
        $check = $conn->prepare("SELECT id FROM visa_cities WHERE slug = ?");
        $check->bind_param("s", $slug);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = "A city with slug \"$slug\" already exists.";
        }
        $check->close();
    }

    if (!$errors) {
        $services_json = json_encode($services, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $faqs_json = json_encode($faqs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $stmt = $conn->prepare(
            "INSERT INTO visa_cities
                (slug, name, city_order, meta_title, meta_description, meta_keywords,
                 hero_h1, hero_tagline, intro_heading, intro, services, faqs, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssissssssssss",
            $slug, $name, $city_order, $meta_title, $meta_description, $meta_keywords,
            $hero_h1, $hero_tagline, $intro_heading, $intro, $services_json, $faqs_json, $status
        );

        if ($stmt->execute()) {
            $_SESSION['success'] = "Visa city \"$name\" added successfully!";
            header("Location: view-visa-cities.php");
            exit();
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Add Visa City | Admin Panel</title>
    <link rel="icon" href="assets/img/logo_icon.jpg" type="image/png">
    <?php include "links.php"; ?>
    <style>
        .repeater-row {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            position: relative;
        }
        .repeater-remove {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }
        .section-title {
            font-weight: 600;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eee;
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
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="white_card card_height_100 mb_30">
                            <div class="card-header bg-white border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="mb-0 fw-bold">Add Visa City</h2>
                                        <p class="text-muted mb-0 small">Publish a new /visa-consultants-:city landing page</p>
                                    </div>
                                    <a href="view-visa-cities.php" class="btn btn-outline-primary">
                                        <i class="fas fa-list me-1"></i> View Cities
                                    </a>
                                </div>
                            </div>
                            <div class="white_card_body">

                                <?php if ($errors): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach ($errors as $e): ?>
                                                <li><?= htmlspecialchars($e) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form method="post" id="cityForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">City Name*</label>
                                            <input type="text" class="form-control" name="name" required
                                                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" class="form-control" name="slug" placeholder="auto-generated from name"
                                                value="<?= htmlspecialchars($_POST['slug'] ?? '') ?>">
                                            <small class="text-muted">URL: /visa-consultants-&lt;slug&gt;/</small>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Display Order</label>
                                            <input type="number" class="form-control" name="city_order"
                                                value="<?= htmlspecialchars($_POST['city_order'] ?? '0') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Meta Title*</label>
                                            <input type="text" class="form-control" name="meta_title" required
                                                value="<?= htmlspecialchars($_POST['meta_title'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Meta Description*</label>
                                            <textarea class="form-control" name="meta_description" rows="2" required><?= htmlspecialchars($_POST['meta_description'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Meta Keywords</label>
                                            <textarea class="form-control" name="meta_keywords" rows="2" placeholder="comma-separated, e.g. best visa consultants in pune, student visa consultancy pune"><?= htmlspecialchars($_POST['meta_keywords'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Hero H1*</label>
                                            <input type="text" class="form-control" name="hero_h1" required
                                                value="<?= htmlspecialchars($_POST['hero_h1'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Hero Tagline*</label>
                                            <textarea class="form-control" name="hero_tagline" rows="2" required><?= htmlspecialchars($_POST['hero_tagline'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Intro Heading*</label>
                                            <input type="text" class="form-control" name="intro_heading" required
                                                value="<?= htmlspecialchars($_POST['intro_heading'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Intro Paragraph*</label>
                                            <textarea class="form-control" name="intro" rows="4" required><?= htmlspecialchars($_POST['intro'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="active">Active (published)</option>
                                                <option value="inactive">Inactive (hidden)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <h3 class="section-title">Services — write genuinely different copy per city, don't reuse another city's wording</h3>
                                    <div id="servicesWrap"></div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mb-4" onclick="addServiceRow()">
                                        <i class="fas fa-plus me-1"></i> Add Service
                                    </button>

                                    <h3 class="section-title">FAQs — feed the FAQPage schema, keep them city-specific</h3>
                                    <div id="faqsWrap"></div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mb-4" onclick="addFaqRow()">
                                        <i class="fas fa-plus me-1"></i> Add FAQ
                                    </button>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Save City
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
        let serviceIndex = 0;
        let faqIndex = 0;
        const countries = <?= json_encode($countries) ?>;

        function escapeHtml(str) {
            return String(str ?? '').replace(/[&<>"']/g, c => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[c]));
        }

        function addServiceRow(data = {}) {
            const i = serviceIndex++;
            const opts = ['<option value="">None</option>'].concat(
                Object.entries(countries).map(([k, v]) =>
                    `<option value="${k}" ${data.country_link === k ? 'selected' : ''}>${v}</option>`)
            ).join('');
            const row = document.createElement('div');
            row.className = 'repeater-row';
            row.innerHTML = `
                <button type="button" class="btn btn-sm btn-outline-danger repeater-remove" onclick="this.closest('.repeater-row').remove()">
                    <i class="fas fa-trash"></i>
                </button>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">Service Title</label>
                        <input type="text" class="form-control" name="services[title][${i}]" value="${escapeHtml(data.title)}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" class="form-control" name="services[icon][${i}]" placeholder="fa-passport" value="${escapeHtml(data.icon)}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Links to Country Page</label>
                        <select class="form-control" name="services[country_link][${i}]">${opts}</select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="services[desc][${i}]" rows="2">${escapeHtml(data.desc)}</textarea>
                    </div>
                </div>
            `;
            document.getElementById('servicesWrap').appendChild(row);
        }

        function addFaqRow(data = {}) {
            const i = faqIndex++;
            const row = document.createElement('div');
            row.className = 'repeater-row';
            row.innerHTML = `
                <button type="button" class="btn btn-sm btn-outline-danger repeater-remove" onclick="this.closest('.repeater-row').remove()">
                    <i class="fas fa-trash"></i>
                </button>
                <div class="mb-2">
                    <label class="form-label">Question</label>
                    <input type="text" class="form-control" name="faqs[q][${i}]" value="${escapeHtml(data.q)}">
                </div>
                <div>
                    <label class="form-label">Answer</label>
                    <textarea class="form-control" name="faqs[a][${i}]" rows="2">${escapeHtml(data.a)}</textarea>
                </div>
            `;
            document.getElementById('faqsWrap').appendChild(row);
        }

        // Start with a couple of blank rows for convenience
        addServiceRow();
        addServiceRow();
        addFaqRow();
        addFaqRow();
    </script>
</body>

</html>
