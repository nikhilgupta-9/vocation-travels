<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/blog_posts.php";

$contact = contact_us();
$posts = get_blog_posts();
uasort($posts, fn($a, $b) => strtotime($b['published']) <=> strtotime($a['published']));

$meta_title = 'Travel & Visa Blog | Tips for Bangalore, Hyderabad, Pune, Chennai & India – ' . $contact['company_name'];
$meta_description = 'Travel guides and visa tips for travelers in Bangalore, Hyderabad, Pune, Chennai and across India — tour packages, destination guides and visa application advice.';
$meta_keywords = ['travel blog india', 'visa tips bangalore', 'visa tips hyderabad', 'tour packages blog', 'travel guide pune', 'travel guide chennai'];
$canonical_path = 'blogs/';

$blog_schema = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'Blog',
      '@id' => $site . 'blogs/#blog',
      'url' => $site . 'blogs/',
      'name' => $meta_title,
      'description' => $meta_description,
      'publisher' => [
        '@type' => 'TravelAgency',
        'name' => $contact['company_name'] ?? 'VOCATION TRAVELS AND TOURS PRIVATE LIMITED',
        'url' => $site,
        'logo' => $site . 'assets/images/logo.png',
      ],
      'breadcrumb' => [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
          ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => $site . 'blogs/'],
        ]
      ]
    ]
  ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include('seo-meta.php') ?>
  <title><?= htmlspecialchars($meta_title) ?></title>
  <?php include('link.php') ?>
  <script type="application/ld+json"><?= json_encode($blog_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

  <style>
    .logo-g.text-center {
      display: flex;
      justify-content: center;
    }

    .footer-social-links ul {
      display: flex !important;
      gap: 18px;
      justify-content: center;
    }

    img.footeer_logo {
      width: 80px;
      height: 80px;
      object-fit: contain;
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-gray-100">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Hero Section -->
    <section class="relative h-[70vh] w-full overflow-hidden">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="<?=$site?>assets/videos/Services.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1 class="text-white font-bold leading-tight text-5xl md:text-6xl lg:text-7xl mb-4 drop-shadow-lg">
          Travel Stories & Insights
        </h1>
        <p class="text-indigo-100 text-lg md:text-2xl max-w-2xl mb-6 font-light drop-shadow">
          Explore tips, guides, and stories from around the world
        </p>
      </div>
    </section>

    <!-- Blog Section -->
    <section class="py-16 px-6 md:px-12 lg:px-20">
      <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Latest Blogs</h2>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
          <?php foreach ($posts as $pslug => $p): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
              <img src="<?= $site . $p['hero_image'] ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-56 object-cover">
              <div class="p-6">
                <span class="inline-block px-3 py-1 mb-3 rounded-full text-xs font-semibold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48]">
                  <?= htmlspecialchars($p['category']) ?>
                </span>
                <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($p['title']) ?></h3>
                <p class="text-gray-600 text-sm mb-4"><?= htmlspecialchars($p['excerpt']) ?></p>
                <a href="<?= $site ?>blog-details/<?= htmlspecialchars($pslug) ?>/" class="font-semibold" style="color:#159c00;">Read More &rarr;</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <!-- Scripts -->
  <script src="<?=$site?>unpkg.com/alpinejs%403.15.8/dist/cdn.min.js" defer></script>
  <script src="<?=$site?>assets/js/main.js"></script>
</body>
</html>