<?php
/**
 * Server-rendered XML Sitemap for Googlebot & search engine crawlers.
 * Automatically pulls:
 * - Core site pages
 * - All Tour Packages (with itineraries and dedicated /package/:slug/ URLs)
 * - All 65 Services from services_cms
 * - All 42 Pan-India Visa Consultant City landing pages
 * - Country-specific Visa pages (USA, UK, Canada, Schengen, Australia, Dubai, etc.)
 * - Blog posts
 */

include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/visa_countries.php";
include_once __DIR__ . "/../util/visa_cities.php";
include_once __DIR__ . "/../util/blog_posts.php";
include_once __DIR__ . "/../util/services_data.php";

header('Content-Type: application/xml; charset=UTF-8');

$urls = [];

// 1. Core site pages
$urls[] = ['loc' => $site, 'changefreq' => 'daily', 'priority' => '1.0'];
$urls[] = ['loc' => $site . 'about/', 'changefreq' => 'monthly', 'priority' => '0.8'];
$urls[] = ['loc' => $site . 'contact/', 'changefreq' => 'monthly', 'priority' => '0.8'];
$urls[] = ['loc' => $site . 'vip-concierge/', 'changefreq' => 'weekly', 'priority' => '0.8'];
$urls[] = ['loc' => $site . 'blogs/', 'changefreq' => 'weekly', 'priority' => '0.7'];
$urls[] = ['loc' => $site . 'privacy-policy/', 'changefreq' => 'yearly', 'priority' => '0.3'];
$urls[] = ['loc' => $site . 'terms-and-conditions/', 'changefreq' => 'yearly', 'priority' => '0.3'];

// 2. Tour Packages Hub & Individual Package Landing Pages (12+ Packages)
$urls[] = ['loc' => $site . 'travel-package/', 'changefreq' => 'daily', 'priority' => '0.95'];
if ($conn && !$conn->connect_error) {
    $pkg_res = @mysqli_query($conn, "SELECT slug, updated_at FROM packages WHERE status = 1 ORDER BY featured DESC, id DESC");
    if ($pkg_res) {
        while ($p = mysqli_fetch_assoc($pkg_res)) {
            $p_entry = [
                'loc' => $site . 'package/' . $p['slug'] . '/',
                'changefreq' => 'weekly',
                'priority' => '0.90'
            ];
            if (!empty($p['updated_at'])) {
                $p_entry['lastmod'] = date('Y-m-d', strtotime($p['updated_at']));
            }
            $urls[] = $p_entry;
        }
    }
}

// 3. Visa Services Hub & Country-Specific Pages
$urls[] = ['loc' => $site . 'visa-services/', 'changefreq' => 'daily', 'priority' => '0.95'];
$countries = get_visa_countries();
uasort($countries, fn($a, $b) => $a['order'] <=> $b['order']);
foreach ($countries as $slug => $country) {
    $urls[] = [
        'loc' => $site . 'visa-services/' . $slug . '/',
        'changefreq' => 'weekly',
        'priority' => '0.85'
    ];
}

// 4. Pan-India Visa Consultant City Landing Pages (All 42 Cities from Database)
$cities = get_visa_cities();
uasort($cities, fn($a, $b) => $a['order'] <=> $b['order']);
foreach (array_keys($cities) as $slug) {
    $urls[] = [
        'loc' => $site . 'visa-consultants-' . $slug . '/',
        'changefreq' => 'weekly',
        'priority' => '0.90'
    ];
}

// 5. Services Hub & All 65 CMS Services Landing Pages
$urls[] = ['loc' => $site . 'services/', 'changefreq' => 'weekly', 'priority' => '0.85'];
$services_added = [];
if ($conn && !$conn->connect_error) {
    $svc_res = @mysqli_query($conn, "SELECT slug, updated_at FROM services_cms WHERE status = 'active' ORDER BY seo_score DESC, views_count DESC");
    if ($svc_res && mysqli_num_rows($svc_res) > 0) {
        while ($s = mysqli_fetch_assoc($svc_res)) {
            $s_entry = [
                'loc' => $site . 'services/' . $s['slug'] . '/',
                'changefreq' => 'weekly',
                'priority' => '0.80'
            ];
            if (!empty($s['updated_at'])) {
                $s_entry['lastmod'] = date('Y-m-d', strtotime($s['updated_at']));
            }
            $urls[] = $s_entry;
            $services_added[$s['slug']] = true;
        }
    }
}
// Fallback for any static service missing
foreach (array_keys(get_services()) as $slug) {
    if (!isset($services_added[$slug])) {
        $urls[] = [
            'loc' => $site . 'services/' . $slug . '/',
            'changefreq' => 'monthly',
            'priority' => '0.70'
        ];
    }
}

// 6. Blog Posts
foreach (get_blog_posts() as $slug => $post) {
    $entry = [
        'loc' => $site . 'blog-details/' . $slug . '/',
        'changefreq' => 'monthly',
        'priority' => '0.65'
    ];
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
<?php else: ?>
    <lastmod><?= date('Y-m-d') ?></lastmod>
<?php endif; ?>
    <changefreq><?= htmlspecialchars($url['changefreq']) ?></changefreq>
    <priority><?= htmlspecialchars($url['priority']) ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
