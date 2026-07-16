<?php
// Reusable SEO head partial.
// Expects (all optional, sensible fallbacks provided): $meta_title, $meta_description,
// $meta_keywords (array or comma string), $canonical_path (path relative to $site, e.g. "visa-services.php").

$__default_title = 'Vocation Travels And Tours – Visa & Travel Services in Hyderabad & Bangalore';
$__default_description = 'Vocation Travels And Tours offers trusted visa assistance and international tour planning for travelers across Hyderabad, Bangalore and all of India.';

$__title = isset($meta_title) && $meta_title !== '' ? $meta_title : $__default_title;
$__description = isset($meta_description) && $meta_description !== '' ? $meta_description : $__default_description;

if (isset($meta_keywords)) {
  $__keywords = is_array($meta_keywords) ? implode(', ', $meta_keywords) : $meta_keywords;
} else {
  $__keywords = 'visa services Hyderabad, visa consultants Bangalore, international visa assistance, tour packages India';
}

$__canonical = $site . (isset($canonical_path) ? ltrim($canonical_path, '/') : '');
$__og_image = $site . (isset($og_image) && $og_image !== '' ? ltrim($og_image, '/') : 'assets/images/logo.png');
?>
<meta name="description" content="<?= htmlspecialchars($__description) ?>">
<meta name="keywords" content="<?= htmlspecialchars($__keywords) ?>">
<link rel="canonical" href="<?= htmlspecialchars($__canonical) ?>">

<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($__title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($__description) ?>">
<meta property="og:url" content="<?= htmlspecialchars($__canonical) ?>">
<meta property="og:image" content="<?= htmlspecialchars($__og_image) ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($__title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($__description) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($__og_image) ?>">
