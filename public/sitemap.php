<?php
/**
 * Server-rendered sitemap.xml (served at /sitemap.xml via .htaccess rewrite).
 * Visa city pages and blog posts are pulled from their live data sources
 * (visa_cities table / get_blog_posts()) so a new page shows up here
 * automatically — no manual edit to this file needed.
 */

include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/visa_countries.php";
include_once __DIR__ . "/../util/visa_cities.php";
include_once __DIR__ . "/../util/blog_posts.php";
include_once __DIR__ . "/../util/services_data.php";

header('Content-Type: application/xml; charset=UTF-8');

$urls = [];

// Core site pages
$urls[] = ['loc' => $site, 'changefreq' => 'weekly', 'priority' => '1.0'];
$urls[] = ['loc' => $site . 'about/', 'changefreq' => 'monthly', 'priority' => '0.6'];
$urls[] = ['loc' => $site . 'services/', 'changefreq' => 'monthly', 'priority' => '0.7'];
foreach (array_keys(get_services()) as $slug) {
    $urls[] = ['loc' => $site . 'services/' . $slug . '/', 'changefreq' => 'monthly', 'priority' => '0.6'];
}
$urls[] = ['loc' => $site . 'travel-package/', 'changefreq' => 'weekly', 'priority' => '0.8'];
$urls[] = ['loc' => $site . 'vip-concierge/', 'changefreq' => 'monthly', 'priority' => '0.6'];
$urls[] = ['loc' => $site . 'blogs/', 'changefreq' => 'weekly', 'priority' => '0.6'];
$urls[] = ['loc' => $site . 'contact/', 'changefreq' => 'monthly', 'priority' => '0.5'];

// Visa services hub + per-country pages
$urls[] = ['loc' => $site . 'visa-services/', 'changefreq' => 'weekly', 'priority' => '0.9'];
$countries = get_visa_countries();
uasort($countries, fn($a, $b) => $a['order'] <=> $b['order']);
foreach ($countries as $slug => $country) {
    $urls[] = ['loc' => $site . 'visa-services/' . $slug . '/', 'changefreq' => 'weekly', 'priority' => '0.8'];
}

// Visa consultant city landing pages (DB-driven — new cities appear automatically)
$cities = get_visa_cities();
uasort($cities, fn($a, $b) => $a['order'] <=> $b['order']);
foreach (array_keys($cities) as $slug) {
    $urls[] = ['loc' => $site . 'visa-consultants-' . $slug . '/', 'changefreq' => 'weekly', 'priority' => '0.9'];
}

// Blog posts
foreach (get_blog_posts() as $slug => $post) {
    $entry = ['loc' => $site . 'blog-details/' . $slug . '/', 'changefreq' => 'monthly', 'priority' => '0.6'];
    if (!empty($post['updated'])) {
        $entry['lastmod'] = $post['updated'];
    }
    $urls[] = $entry;
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
  <url>
    <loc><?= htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></loc>
<?php if (!empty($url['lastmod'])): ?>
    <lastmod><?= htmlspecialchars($url['lastmod']) ?></lastmod>
<?php endif; ?>
    <changefreq><?= htmlspecialchars($url['changefreq']) ?></changefreq>
    <priority><?= htmlspecialchars($url['priority']) ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
