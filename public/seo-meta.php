<?php
// Reusable SEO head partial for Pan-India and Global indexing.
// Expects: $meta_title, $meta_description, $meta_keywords, $canonical_path, $og_image.

global $conn, $site;

// Determine page lookup slug
$__lookup_slug = '';
if (!empty($seo_slug)) {
    $__lookup_slug = $seo_slug;
} elseif (isset($canonical_path)) {
    $clean_canon = trim($canonical_path, '/');
    if ($clean_canon === '') {
        $__lookup_slug = 'home';
    } else {
        $parts = explode('/', $clean_canon);
        $__lookup_slug = $parts[0];
    }
} else {
    $current_script = basename($_SERVER['SCRIPT_NAME'] ?? '', '.php');
    $__lookup_slug = ($current_script === 'index' || $current_script === '') ? 'home' : $current_script;
}

// Query page_seo from database if available
if (!empty($conn) && $conn instanceof mysqli && !$conn->connect_errno && !empty($__lookup_slug)) {
    $__stmt = @$conn->prepare("SELECT meta_title, meta_description, focus_keyword, og_image FROM page_seo WHERE page_slug = ? LIMIT 1");
    if ($__stmt) {
        $__stmt->bind_param("s", $__lookup_slug);
        $__stmt->execute();
        $__res = $__stmt->get_result();
        if ($__res && $__row = $__res->fetch_assoc()) {
            if (!empty($__row['meta_title'])) {
                $meta_title = $__row['meta_title'];
            }
            if (!empty($__row['meta_description'])) {
                $meta_description = $__row['meta_description'];
            }
            if (!empty($__row['focus_keyword'])) {
                $meta_keywords = $__row['focus_keyword'] . ', ' . (is_array($meta_keywords ?? null) ? implode(', ', $meta_keywords) : ($meta_keywords ?? ''));
            }
            if (!empty($__row['og_image'])) {
                $og_image = $__row['og_image'];
            }
        }
        $__stmt->close();
    }
}

$__default_title = 'Vocation Travels – Holiday Tour Packages & Visa Consultants Across India (40+ Cities)';
$__default_description = 'Vocation Travels provides premier domestic and international holiday tour packages and expert visa consultancy across 40+ Indian cities and globally.';

$__title = isset($meta_title) && $meta_title !== '' ? $meta_title : $__default_title;
$__description = isset($meta_description) && $meta_description !== '' ? $meta_description : $__default_description;

if (isset($meta_keywords)) {
  $__keywords = is_array($meta_keywords) ? implode(', ', $meta_keywords) : $meta_keywords;
} else {
  $__keywords = 'visa consultants India, tour packages India, travel agency Delhi, travel agency Mumbai, travel agency Bangalore, travel agency Hyderabad, Schengen visa agent, USA visa consultant, holiday packages 2026';
}

$__canonical = $site . (isset($canonical_path) ? ltrim($canonical_path, '/') : '');
$__og_image = (isset($og_image) && strpos($og_image, 'http') === 0) ? $og_image : ($site . (isset($og_image) && $og_image !== '' ? ltrim($og_image, '/') : 'assets/images/luxury_travel_hero.jpg'));
?>
<meta name="description" content="<?= htmlspecialchars($__description) ?>">
<meta name="keywords" content="<?= htmlspecialchars($__keywords) ?>">
<link rel="canonical" href="<?= htmlspecialchars($__canonical) ?>">
<meta name="google-site-verification" content="_u8DS_RrIpZN0NS6YGupNfmZZvRtNRiZj3TPcVjuA2s" />

<!-- OpenGraph / Social Media Meta -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="Vocation Travels">
<meta property="og:title" content="<?= htmlspecialchars($__title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($__description) ?>">
<meta property="og:url" content="<?= htmlspecialchars($__canonical) ?>">
<meta property="og:image" content="<?= htmlspecialchars($__og_image) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($__title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($__description) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($__og_image) ?>">
