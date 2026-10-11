<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/blog_posts.php";

$contact = contact_us();
$posts = get_blog_posts();

$slug = isset($_GET['alias']) ? preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['alias'])) : '';
$post = get_blog_post($slug);

if (!$post) {
  header("Location: " . $site . "blogs/");
  exit;
}

$related_slugs = $post['related'] ?? [];

$meta_title = $post['meta_title'];
$meta_description = $post['meta_description'];
$meta_keywords = $post['meta_keywords'];
$canonical_path = 'blog-details/' . $slug . '/';
$og_image = $post['featured_image'];

// Structured data (technical SEO + AEO): BlogPosting + FAQPage + BreadcrumbList.
// FAQPage is what lets answer engines / AI overviews lift a direct Q&A pair
// straight out of this page instead of just a generic snippet.
$blog_schema = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'BlogPosting',
      'headline' => $post['title'],
      'description' => $post['meta_description'],
      'image' => $site . $post['featured_image'],
      'author' => ['@type' => 'Organization', 'name' => $post['author']],
      'publisher' => ['@type' => 'Organization', 'name' => $contact['company_name'] ?? 'Vocation Travels And Tours'],
      'datePublished' => $post['published'],
      'dateModified' => $post['updated'],
      'mainEntityOfPage' => $site . 'blog-details/' . $slug . '/',
    ],
    [
      '@type' => 'FAQPage',
      'mainEntity' => array_map(fn($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
      ], $post['faqs']),
    ],
    [
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => $site . 'blogs/'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $post['title'], 'item' => $site . 'blog-details/' . $slug . '/'],
      ],
    ],
  ],
];

// Renders one body block. Trusted, author-authored content only (never user input).
function render_blog_block($block, $site)
{
  switch ($block['type']) {
    case 'h2':
      echo '<h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-10 mb-4">' . htmlspecialchars($block['text']) . '</h2>';
      break;
    case 'p':
      echo '<p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-5 text-base sm:text-lg">' . htmlspecialchars($block['text']) . '</p>';
      break;
    case 'html':
      echo '<p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-5 text-base sm:text-lg">' . str_replace('{{site}}', htmlspecialchars($site), $block['text']) . '</p>';
      break;
    case 'ul':
      echo '<ul class="list-disc list-inside space-y-2.5 text-gray-700 dark:text-gray-300 mb-6 text-base sm:text-lg">';
      foreach ($block['items'] as $item) {
        echo '<li>' . htmlspecialchars($item) . '</li>';
      }
      echo '</ul>';
      break;
    case 'quote':
      echo '<blockquote class="border-l-4 pl-4 italic text-gray-700 dark:text-gray-300 my-6 bg-gray-50 dark:bg-neutral-800/60 p-4 rounded-r-xl" style="border-color:#1ec700;">' . htmlspecialchars($block['text']) . '</blockquote>';
      break;
    case 'table':
      echo '<div class="overflow-x-auto mb-6"><table class="w-full text-sm text-left border-collapse border border-gray-200 dark:border-white/10 rounded-xl overflow-hidden">';
      echo '<thead><tr class="bg-gray-100 dark:bg-neutral-800">';
      foreach ($block['headers'] as $h) {
        echo '<th class="p-3.5 border-b border-gray-200 dark:border-white/10 font-bold text-gray-900 dark:text-white">' . htmlspecialchars($h) . '</th>';
      }
      echo '</tr></thead><tbody class="divide-y divide-gray-200 dark:divide-white/10">';
      foreach ($block['rows'] as $row) {
        echo '<tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50">';
        foreach ($row as $cell) {
          echo '<td class="p-3.5 text-gray-700 dark:text-gray-300">' . htmlspecialchars($cell) . '</td>';
        }
        echo '</tr>';
      }
      echo '</tbody></table></div>';
      break;
  }
}
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

    .quick-answer {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-left: 4px solid #1ec700;
      border-radius: .75rem;
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-slate-50 dark:bg-neutral-950 text-slate-800 dark:text-gray-100 font-sans transition-colors duration-300">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Hero -->
    <section class="relative min-h-[460px] sm:min-h-[500px] w-full overflow-hidden flex items-center justify-center pt-32 pb-16 bg-neutral-950">
      <img src="<?= $site . $post['hero_image'] ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="absolute inset-0 w-full h-full object-cover filter brightness-50">
      <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/60 to-black/70"></div>
      <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
        <span class="inline-block px-4 py-1.5 mb-4 rounded-full text-xs font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
          <?= htmlspecialchars($post['category']) ?>
        </span>
        <h1 class="text-white font-extrabold leading-tight text-3xl sm:text-4xl md:text-5xl mb-4 drop-shadow-2xl max-w-4xl">
          <?= htmlspecialchars($post['title']) ?>
        </h1>
        <p class="text-gray-300 text-xs sm:text-sm font-light">
          Published <?= htmlspecialchars($post['published_display']) ?> &bull; By <?= htmlspecialchars($post['author']) ?> &bull; <i class="fa-regular fa-clock ml-1"></i> <?= htmlspecialchars($post['read_time']) ?>
        </p>
      </div>
    </section>

    <!-- Breadcrumb -->
    <div class="max-w-4xl mx-auto px-6 pt-6 text-xs text-gray-500 dark:text-gray-400">
      <a href="<?= $site ?>" class="hover:underline text-emerald-600 dark:text-emerald-400">Home</a> /
      <a href="<?= $site ?>blogs/" class="hover:underline text-emerald-600 dark:text-emerald-400">Blog</a> /
      <span class="text-gray-800 dark:text-gray-200"><?= htmlspecialchars($post['title']) ?></span>
    </div>

    <!-- Content -->
    <section class="py-10 px-6 md:px-12 lg:px-0">
      <div class="max-w-4xl mx-auto bg-white dark:bg-neutral-900 rounded-3xl shadow-xl border border-gray-200 dark:border-white/10 p-6 sm:p-10 md:p-14 text-slate-800 dark:text-gray-100">

        <!-- Quick answer (AEO): a self-contained answer an AI overview or featured snippet can lift directly -->
        <div class="p-6 mb-8 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-500/30">
          <p class="text-xs font-bold uppercase tracking-wide text-emerald-700 dark:text-emerald-400 mb-2 flex items-center">
            <i class="fa-solid fa-bolt mr-2"></i> Quick Answer
          </p>
          <p class="text-gray-900 dark:text-emerald-100 text-base leading-relaxed"><?= htmlspecialchars($post['quick_answer']) ?></p>
        </div>

        <img src="<?= $site . $post['featured_image'] ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-72 md:h-96 object-cover rounded-2xl mb-8 border border-gray-100 dark:border-white/10 shadow-md">

        <div class="prose max-w-none text-gray-800 dark:text-gray-200">
          <?php foreach ($post['body'] as $block) render_blog_block($block, $site); ?>
        </div>

        <!-- FAQ (AEO + FAQPage schema) -->
        <?php if (!empty($post['faqs'])): ?>
          <div class="mt-12 border-t border-gray-200 dark:border-white/10 pt-8" x-data="{ openFaq: null }">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Frequently Asked Questions</h2>
            <div class="space-y-4">
              <?php foreach ($post['faqs'] as $faq): ?>
                <div x-data="{ open: false }" @click="open = !open"
                  class="bg-gray-50 dark:bg-neutral-800/70 rounded-2xl p-5 cursor-pointer border border-gray-200 dark:border-white/10 hover:border-emerald-500/50 transition">
                  <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-base"><?= htmlspecialchars($faq['q']) ?></h3>
                    <i :class="open ? 'fa-solid fa-chevron-up text-emerald-500' : 'fa-solid fa-chevron-down text-gray-400'" class="text-sm"></i>
                  </div>
                  <div x-show="open" x-transition class="mt-3 text-gray-600 dark:text-gray-300 leading-relaxed text-sm">
                    <?= htmlspecialchars($faq['a']) ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Share -->
        <div class="mt-12 border-t border-gray-200 dark:border-white/10 pt-6 flex items-center justify-between flex-wrap gap-4">
          <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300">Share this guide:</h3>
          <div class="flex gap-4">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($site . 'blog-details/' . $slug . '/') ?>" target="_blank" rel="noopener" class="text-blue-600 hover:text-blue-800 transition"><i class="fab fa-facebook fa-lg"></i></a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($site . 'blog-details/' . $slug . '/') ?>&text=<?= urlencode($post['title']) ?>" target="_blank" rel="noopener" class="text-sky-500 hover:text-sky-700 transition"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($site . 'blog-details/' . $slug . '/') ?>" target="_blank" rel="noopener" class="text-blue-800 hover:text-blue-900 transition"><i class="fab fa-linkedin fa-lg"></i></a>
          </div>
        </div>
      </div>
    </section>

    <!-- Related Posts -->
    <?php if (!empty($related_slugs)): ?>
      <section class="py-12 px-6">
        <div class="max-w-5xl mx-auto">
          <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Related Reading</h2>
          <div class="flex flex-wrap justify-center gap-4">
            <?php foreach ($related_slugs as $rslug): $rpost = $posts[$rslug] ?? null; if (!$rpost) continue; ?>
              <a href="<?= $site ?>blog-details/<?= htmlspecialchars($rslug) ?>/"
                class="px-5 py-2 rounded-full bg-white shadow hover:shadow-md text-gray-700 font-medium text-sm transition">
                <?= htmlspecialchars($rpost['title']) ?>
              </a>
            <?php endforeach; ?>
            <a href="<?= $site ?>blogs/"
              class="px-5 py-2 rounded-full text-white font-medium text-sm bg-gradient-to-r from-[#1ec700] to-[#e11d48] transition">
              View All Posts
            </a>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <!-- CTA -->
    <section class="py-12 px-4 sm:px-8 md:px-16">
      <div class="bg-gradient-to-r from-green-600 to-red-600 text-white rounded-2xl shadow-lg p-8 text-center max-w-4xl mx-auto">
        <h3 class="text-xl md:text-2xl font-bold mb-4">Planning a Trip or a Visa Application?</h3>
        <p class="md:text-lg leading-relaxed">
          Talk to our travel &amp; visa consultants serving Bangalore, Hyderabad, Pune, Chennai and all of India.
        </p>
        <a href="<?= $site ?>contact/#contactform"
          class="mt-6 inline-block px-6 py-3 bg-white text-green-700 font-semibold rounded-lg shadow-md hover:scale-105 transition duration-300">
          Enquire Now
        </a>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <!-- Scripts -->
  <script src="<?= $site ?>unpkg.com/alpinejs%403.15.8/dist/cdn.min.js" defer></script>
  <script src="<?= $site ?>assets/js/main.js"></script>
</body>

</html>
