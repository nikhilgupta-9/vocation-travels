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
$og_image = $site . $post['featured_image'];
$phone = $contact['phone'] ?? '9999447373';
$wp_number = $contact['wp_number'] ?? '7982938239';
$clean_phone = preg_replace('/[^0-9]/', '', $phone);
$clean_wp = preg_replace('/[^0-9]/', '', $wp_number);

// Extract H2 headings for dynamic Table of Contents (TOC)
$toc_items = [];
foreach ($post['body'] as $idx => $block) {
  if ($block['type'] === 'h2') {
    $anchor_id = 'section-' . ($idx + 1) . '-' . preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($block['text'])));
    $anchor_id = trim($anchor_id, '-');
    $toc_items[] = [
      'id' => $anchor_id,
      'title' => $block['text']
    ];
  }
}

// Structured data (technical SEO + AEO): BlogPosting + FAQPage + BreadcrumbList
$blog_schema = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'BlogPosting',
      '@id' => $site . 'blog-details/' . $slug . '/#article',
      'isPartOf' => [
        '@type' => 'Blog',
        '@id' => $site . 'blogs/#blog',
        'name' => 'Vocation Travels Travel & Visa Blog',
        'publisher' => [
          '@type' => 'Organization',
          'name' => $contact['company_name'] ?? 'VOCATION TRAVELS AND TOURS PRIVATE LIMITED',
          'url' => $site,
          'logo' => $site . 'assets/images/logo.png',
        ]
      ],
      'headline' => $post['title'],
      'description' => $post['meta_description'],
      'image' => [
        '@type' => 'ImageObject',
        'url' => $site . $post['featured_image'],
      ],
      'inLanguage' => 'en-IN',
      'author' => [
        '@type' => 'Organization',
        'name' => $post['author'],
        'url' => $site . 'about/',
      ],
      'publisher' => [
        '@type' => 'Organization',
        'name' => $contact['company_name'] ?? 'VOCATION TRAVELS AND TOURS PRIVATE LIMITED',
        'url' => $site,
        'logo' => [
          '@type' => 'ImageObject',
          'url' => $site . 'assets/images/logo.png',
        ]
      ],
      'datePublished' => $post['published'],
      'dateModified' => $post['updated'],
      'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => $site . 'blog-details/' . $slug . '/',
      ],
    ],
    [
      '@type' => 'FAQPage',
      'mainEntity' => array_map(fn($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
      ], $post['faqs'] ?? []),
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

// Semantic block renderer
if (!function_exists('render_blog_block')) {
  function render_blog_block($block, $site, $idx = 0)
  {
    switch ($block['type']) {
      case 'h2':
        $anchor_id = 'section-' . ($idx + 1) . '-' . preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($block['text'])));
        $anchor_id = trim($anchor_id, '-');
        echo '<div class="group pt-8 -mt-2 mb-4">';
        echo '<h2 id="' . htmlspecialchars($anchor_id) . '" class="scroll-mt-28 text-xl sm:text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight flex items-baseline justify-between">';
        echo '<span>' . htmlspecialchars($block['text']) . '</span>';
        echo '<a href="#' . htmlspecialchars($anchor_id) . '" class="text-xs text-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity ml-3 hover:underline" title="Link to this section"><i class="fa-solid fa-hashtag"></i></a>';
        echo '</h2>';
        echo '<div class="h-1 w-14 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full mt-2"></div>';
        echo '</div>';
        break;

      case 'p':
        echo '<p class="text-gray-700 dark:text-gray-300 leading-relaxed sm:leading-loose mb-5 text-base sm:text-lg font-normal">' . htmlspecialchars($block['text']) . '</p>';
        break;

      case 'html':
        echo '<div class="my-6 p-4 sm:p-5 rounded-2xl bg-emerald-50/60 dark:bg-neutral-800/60 border-l-4 border-emerald-500 text-gray-800 dark:text-gray-200 text-base sm:text-lg leading-relaxed shadow-sm">' . str_replace('{{site}}', htmlspecialchars($site), $block['text']) . '</div>';
        break;

      case 'ul':
        echo '<ul class="space-y-3 text-gray-700 dark:text-gray-300 mb-6 text-base sm:text-lg pl-1">';
        foreach ($block['items'] as $item) {
          echo '<li class="flex items-start">';
          echo '<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 text-xs mr-3 mt-1 flex-shrink-0"><i class="fa-solid fa-check"></i></span>';
          echo '<span class="leading-relaxed">' . htmlspecialchars($item) . '</span>';
          echo '</li>';
        }
        echo '</ul>';
        break;

      case 'quote':
        echo '<blockquote class="border-l-4 border-emerald-500 pl-5 pr-4 py-4 italic text-gray-800 dark:text-gray-200 my-8 bg-emerald-50/50 dark:bg-neutral-800/60 rounded-r-2xl shadow-sm text-base sm:text-lg leading-relaxed">';
        echo '<div class="flex items-start gap-3">';
        echo '<i class="fa-solid fa-quote-left text-emerald-500 text-xl flex-shrink-0 mt-1"></i>';
        echo '<span>' . htmlspecialchars($block['text']) . '</span>';
        echo '</div>';
        echo '</blockquote>';
        break;

      case 'table':
        echo '<div class="my-8">';
        echo '<div class="sm:hidden text-xs text-emerald-600 dark:text-emerald-400 mb-2 flex items-center gap-1.5 font-medium"><i class="fa-solid fa-arrows-left-right"></i> Scroll table horizontally to view all details</div>';
        echo '<div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm">';
        echo '<table class="w-full text-left border-collapse text-sm sm:text-base min-w-[550px]">';
        echo '<thead><tr class="bg-gray-100 dark:bg-neutral-800 text-gray-900 dark:text-white border-b border-gray-200 dark:border-white/10">';
        foreach ($block['headers'] as $h) {
          echo '<th class="p-3.5 sm:p-4 font-bold tracking-wide">' . htmlspecialchars($h) . '</th>';
        }
        echo '</tr></thead><tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-neutral-900">';
        foreach ($block['rows'] as $row) {
          echo '<tr class="hover:bg-emerald-50/30 dark:hover:bg-neutral-800/40 transition-colors">';
          foreach ($row as $cell) {
            echo '<td class="p-3.5 sm:p-4 text-gray-700 dark:text-gray-300 leading-normal">' . htmlspecialchars($cell) . '</td>';
          }
          echo '</tr>';
        }
        echo '</tbody></table></div></div>';
        break;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include('seo-meta.php') ?>
  <title><?= htmlspecialchars($meta_title) ?></title>
  <?php include('link.php') ?>
  <script type="application/ld+json"><?= json_encode($blog_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

  <style>
    /* Reading progress bar */
    #reading-progress {
      transition: width 0.15s ease-out;
    }

    /* Custom smooth table scroll */
    .overflow-x-auto::-webkit-scrollbar {
      height: 6px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
      background: rgba(30, 199, 0, 0.4);
      border-radius: 9999px;
    }

    /* Floating action button animations */
    @keyframes pulseSoft {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    .floating-pulse {
      animation: pulseSoft 2.5s infinite ease-in-out;
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-slate-50 dark:bg-neutral-950 text-slate-800 dark:text-gray-100 font-sans transition-colors duration-300 selection:bg-emerald-500 selection:text-white">

  <!-- Sticky Top Reading Progress Bar -->
  <div id="reading-progress" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-[#1ec700] z-[60] shadow-sm" style="width: 0%;"></div>

  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Hero Section -->
    <section class="relative min-h-[460px] sm:min-h-[520px] w-full overflow-hidden flex items-center justify-center pt-32 sm:pt-36 pb-16 bg-neutral-950">
      <img src="<?= $site . $post['hero_image'] ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="absolute inset-0 w-full h-full object-cover filter brightness-50 transform hover:scale-105 transition-transform duration-1000">
      <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/70 to-black/75"></div>

      <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <!-- Category Pill & Verified Badge -->
        <div class="inline-flex items-center space-x-2 py-1.5 px-4 mb-4 rounded-full bg-white/10 backdrop-blur-md text-emerald-400 text-xs sm:text-sm font-semibold border border-white/10 shadow-lg">
          <?php if (strtolower($post['category']) === 'visa'): ?>
            <i class="fa-solid fa-passport"></i>
          <?php else: ?>
            <i class="fa-solid fa-plane-departure"></i>
          <?php endif; ?>
          <span><?= htmlspecialchars($post['category']) ?> Guide</span>
          <span class="text-white/40">&bull;</span>
          <span class="text-emerald-300 flex items-center gap-1"><i class="fa-solid fa-circle-check text-xs"></i> 2026 Verified</span>
        </div>

        <h1 class="text-white font-extrabold leading-tight text-2xl sm:text-4xl md:text-5xl mb-5 drop-shadow-2xl max-w-4xl tracking-tight">
          <?= htmlspecialchars($post['title']) ?>
        </h1>

        <!-- Hero Metadata Bar -->
        <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-gray-300 text-xs sm:text-sm font-light">
          <span class="flex items-center gap-1.5">
            <i class="fa-solid fa-feather-pointed text-emerald-400"></i>
            <span>By <strong class="text-white font-medium"><?= htmlspecialchars($post['author']) ?></strong></span>
          </span>
          <span class="text-white/30 hidden sm:inline">&bull;</span>
          <span class="flex items-center gap-1.5">
            <i class="fa-regular fa-calendar-check text-emerald-400"></i>
            <span>Published <?= htmlspecialchars($post['published_display']) ?></span>
          </span>
          <span class="text-white/30 hidden sm:inline">&bull;</span>
          <span class="flex items-center gap-1.5 bg-emerald-500/20 text-emerald-300 px-2.5 py-0.5 rounded-full font-medium">
            <i class="fa-regular fa-clock"></i>
            <span><?= htmlspecialchars($post['read_time']) ?></span>
          </span>
        </div>
      </div>
    </section>

    <!-- Breadcrumb Navigation -->
    <nav class="max-w-4xl mx-auto px-4 sm:px-6 pt-6 pb-2 text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1.5 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
      <a href="<?= $site ?>" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1">
        <i class="fa-solid fa-house text-xs"></i>
        <span>Home</span>
      </a>
      <span class="text-gray-400">/</span>
      <a href="<?= $site ?>blogs/" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Blog</a>
      <span class="text-gray-400">/</span>
      <span class="text-gray-800 dark:text-gray-200 truncate max-w-[240px] sm:max-w-md font-medium" title="<?= htmlspecialchars($post['title']) ?>">
        <?= htmlspecialchars($post['title']) ?>
      </span>
    </nav>

    <!-- Main Content Container -->
    <article class="py-6 sm:py-10 px-4 sm:px-6 md:px-8 lg:px-0">
      <div class="max-w-4xl mx-auto bg-white dark:bg-neutral-900 rounded-3xl shadow-xl border border-gray-200/80 dark:border-white/10 p-5 sm:p-10 md:p-14 text-slate-800 dark:text-gray-100">

        <!-- E-E-A-T Editorial Badge -->
        <div class="mb-6 p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-neutral-800/60 border border-slate-200 dark:border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-gray-600 dark:text-gray-300">
          <div class="flex items-center gap-2.5">
            <span class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
              <i class="fa-solid fa-shield-check"></i>
            </span>
            <div>
              <p class="font-semibold text-gray-900 dark:text-white">Fact-Checked &amp; Curated for 2026 Travel Guidelines</p>
              <p class="text-gray-500 dark:text-gray-400 text-[11px]">Reviewed by senior destination curators and visa consultants at Vocation Travels</p>
            </div>
          </div>
          <div class="flex items-center gap-2 self-start sm:self-auto">
            <span class="px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 font-medium text-[11px] border border-emerald-200 dark:border-emerald-800/40">
              <i class="fa-solid fa-rotate mr-1"></i> Updated <?= htmlspecialchars(date('M Y', strtotime($post['updated']))) ?>
            </span>
          </div>
        </div>

        <!-- Quick Answer / AI Overview (AEO Callout) -->
        <div class="p-5 sm:p-6 mb-8 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/40 dark:to-neutral-900 border border-emerald-300 dark:border-emerald-500/30 shadow-sm">
          <div class="flex items-center gap-2 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2.5">
            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">
              <i class="fa-solid fa-bolt"></i>
            </span>
            <span>Key Takeaway &amp; Summary</span>
          </div>
          <p class="text-gray-900 dark:text-emerald-100 text-base sm:text-lg leading-relaxed font-normal">
            <?= htmlspecialchars($post['quick_answer']) ?>
          </p>
        </div>

        <!-- Featured Image -->
        <div class="mb-10 overflow-hidden rounded-2xl border border-gray-100 dark:border-white/10 shadow-lg group">
          <img src="<?= $site . $post['featured_image'] ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-64 sm:h-80 md:h-96 object-cover transform group-hover:scale-102 transition duration-500">
          <div class="bg-gray-50 dark:bg-neutral-800 px-4 py-2 text-xs text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-white/10 flex justify-between items-center">
            <span><i class="fa-solid fa-camera mr-1"></i> <?= htmlspecialchars($post['title']) ?></span>
            <span class="font-medium text-emerald-600 dark:text-emerald-400">Vocation Travels Curated Guide</span>
          </div>
        </div>

        <!-- Table of Contents (TOC) with Alpine Collapsible on Mobile -->
        <?php if (!empty($toc_items)): ?>
          <div x-data="{ tocOpen: true }" class="mb-10 p-5 sm:p-6 rounded-2xl bg-slate-50 dark:bg-neutral-800/60 border border-slate-200 dark:border-white/10 shadow-sm">
            <div class="flex items-center justify-between cursor-pointer select-none" @click="tocOpen = !tocOpen">
              <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2.5">
                <i class="fa-solid fa-list-ul text-emerald-500"></i>
                <span>In This Guide (Table of Contents)</span>
              </h3>
              <button type="button" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1 focus:outline-none">
                <span x-text="tocOpen ? 'Hide' : 'Show'">Hide</span>
                <i :class="tocOpen ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="text-xs transition-transform"></i>
              </button>
            </div>
            <div x-show="tocOpen" x-transition class="mt-4 pt-4 border-t border-slate-200 dark:border-white/10">
              <ol class="space-y-2 text-sm sm:text-base">
                <?php foreach ($toc_items as $tidx => $item): ?>
                  <li>
                    <a href="#<?= htmlspecialchars($item['id']) ?>" class="text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors flex items-start gap-2">
                      <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 mt-1"><?= ($tidx + 1) ?>.</span>
                      <span class="hover:underline"><?= htmlspecialchars($item['title']) ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ol>
            </div>
          </div>
        <?php endif; ?>

        <!-- Article Body -->
        <div class="article-body">
          <?php foreach ($post['body'] as $bidx => $block): ?>
            <?php render_blog_block($block, $site, $bidx); ?>
          <?php endforeach; ?>
        </div>

        <!-- In-Content Contextual Cross-Pillar CTA -->
        <div class="my-10 p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-700 to-emerald-800 text-white shadow-xl relative overflow-hidden">
          <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl pointer-events-none">
            <i class="fa-solid fa-plane-departure"></i>
          </div>
          <div class="relative z-10 max-w-2xl">
            <?php if (strtolower($post['category']) === 'visa'): ?>
              <span class="inline-block px-3 py-1 mb-3 rounded-full text-xs font-bold bg-white/20 text-white uppercase tracking-wider backdrop-blur-sm">
                <i class="fa-solid fa-passport mr-1"></i> Pan-India Visa Advisory
              </span>
              <h3 class="text-xl sm:text-2xl font-bold mb-2">Need Professional Visa Assistance?</h3>
              <p class="text-white/90 text-sm sm:text-base leading-relaxed mb-6">
                Our accredited visa desk serves travelers across New Delhi, Bangalore, Hyderabad, Pune, Chennai, and Mumbai with slot booking, 100% document scrutiny, and mock interview training.
              </p>
              <div class="flex flex-wrap gap-3">
                <a href="https://api.whatsapp.com/send?phone=91<?= $clean_wp ?>&text=<?= urlencode('Hi Vocation Travels, I am reading your guide "' . $post['title'] . '" and would like visa assistance.') ?>" target="_blank" rel="noopener"
                  class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-xl text-sm transition flex items-center gap-2 shadow-lg">
                  <i class="fa-brands fa-whatsapp text-lg"></i>
                  <span>WhatsApp Consultant</span>
                </a>
                <a href="<?= $site ?>visa-services/"
                  class="px-5 py-2.5 bg-white text-emerald-800 hover:bg-gray-100 font-semibold rounded-xl text-sm transition flex items-center gap-2 shadow-lg">
                  <span>Explore Visa Services</span>
                  <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
              </div>
            <?php else: ?>
              <span class="inline-block px-3 py-1 mb-3 rounded-full text-xs font-bold bg-white/20 text-white uppercase tracking-wider backdrop-blur-sm">
                <i class="fa-solid fa-umbrella-beach mr-1"></i> Bespoke Holiday Concierge
              </span>
              <h3 class="text-xl sm:text-2xl font-bold mb-2">Turn This Dream Trip Into Reality</h3>
              <p class="text-white/90 text-sm sm:text-base leading-relaxed mb-6">
                Looking for a private custom itinerary with 5-star handpicked resorts, chauffeur transfers, and zero hassle? Speak with our luxury travel specialists today.
              </p>
              <div class="flex flex-wrap gap-3">
                <a href="https://api.whatsapp.com/send?phone=91<?= $clean_wp ?>&text=<?= urlencode('Hi Vocation Travels, I loved your article "' . $post['title'] . '" and want to customize a holiday package.') ?>" target="_blank" rel="noopener"
                  class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-xl text-sm transition flex items-center gap-2 shadow-lg">
                  <i class="fa-brands fa-whatsapp text-lg"></i>
                  <span>WhatsApp Trip Planner</span>
                </a>
                <a href="<?= $site ?>travel-package/"
                  class="px-5 py-2.5 bg-white text-emerald-800 hover:bg-gray-100 font-semibold rounded-xl text-sm transition flex items-center gap-2 shadow-lg">
                  <span>Browse Holiday Packages</span>
                  <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- FAQ Accordion (AEO + FAQPage Schema) -->
        <?php if (!empty($post['faqs'])): ?>
          <div class="mt-12 border-t border-gray-200 dark:border-white/10 pt-10" x-data="{ openFaq: null }">
            <div class="flex items-center gap-2 mb-2 text-emerald-600 dark:text-emerald-400 font-bold text-xs uppercase tracking-wider">
              <i class="fa-solid fa-circle-question"></i>
              <span>Common Questions &amp; Clear Answers</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white mb-6">Frequently Asked Questions</h2>
            <div class="space-y-4">
              <?php foreach ($post['faqs'] as $fidx => $faq): ?>
                <div class="bg-gray-50 dark:bg-neutral-800/70 rounded-2xl p-5 border border-gray-200 dark:border-white/10 hover:border-emerald-500/50 transition cursor-pointer select-none"
                     @click="openFaq = (openFaq === <?= $fidx ?> ? null : <?= $fidx ?>)">
                  <div class="flex justify-between items-center gap-4">
                    <h3 class="font-bold text-gray-900 dark:text-white text-base sm:text-lg flex items-center gap-2.5">
                      <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">Q.</span>
                      <span><?= htmlspecialchars($faq['q']) ?></span>
                    </h3>
                    <div class="w-8 h-8 rounded-full bg-white dark:bg-neutral-700 flex items-center justify-center flex-shrink-0 shadow-sm">
                      <i :class="openFaq === <?= $fidx ?> ? 'fa-solid fa-chevron-up text-emerald-500' : 'fa-solid fa-chevron-down text-gray-400'" class="text-xs transition-transform"></i>
                    </div>
                  </div>
                  <div x-show="openFaq === <?= $fidx ?>" x-transition class="mt-3.5 pt-3.5 border-t border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 leading-relaxed text-sm sm:text-base">
                    <?= htmlspecialchars($faq['a']) ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Author Bio Box -->
        <div class="mt-12 p-6 rounded-2xl bg-slate-50 dark:bg-neutral-800/60 border border-slate-200 dark:border-white/10 flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
          <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center text-2xl font-bold shadow-md flex-shrink-0">
            <i class="fa-solid fa-user-tie"></i>
          </div>
          <div>
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
              <h4 class="font-bold text-gray-900 dark:text-white text-lg"><?= htmlspecialchars($post['author']) ?></h4>
              <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-semibold">Editorial Team</span>
            </div>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-3">
              Authored by senior destination researchers and consular documentation specialists at Vocation Travels And Tours. Helping over 25,000+ travelers experience seamless global adventures and guaranteed visa compliance.
            </p>
            <a href="<?= $site ?>about/" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
              <span>Learn more about our advisory standards</span>
              <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
          </div>
        </div>

        <!-- Social Share & Interactive Copy Link -->
        <div class="mt-10 pt-6 border-t border-gray-200 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4" x-data="{ copied: false }">
          <span class="text-sm font-bold text-gray-700 dark:text-gray-300 flex items-center gap-2">
            <i class="fa-solid fa-share-nodes text-emerald-500"></i>
            <span>Share this travel guide:</span>
          </span>
          <div class="flex items-center gap-2.5 flex-wrap justify-center">
            <!-- WhatsApp -->
            <a href="https://api.whatsapp.com/send?text=<?= urlencode($post['title'] . ' - Read here: ' . $site . 'blog-details/' . $slug . '/') ?>" target="_blank" rel="noopener"
              class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-950/60 text-green-600 hover:bg-green-500 hover:text-white transition flex items-center justify-center border border-green-200 dark:border-green-800 shadow-sm" title="Share via WhatsApp">
              <i class="fab fa-whatsapp"></i>
            </a>
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($site . 'blog-details/' . $slug . '/') ?>" target="_blank" rel="noopener"
              class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-950/60 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center border border-blue-200 dark:border-blue-800 shadow-sm" title="Share on Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <!-- Twitter / X -->
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($site . 'blog-details/' . $slug . '/') ?>&text=<?= urlencode($post['title']) ?>" target="_blank" rel="noopener"
              class="w-10 h-10 rounded-full bg-slate-100 dark:bg-neutral-800 text-gray-800 dark:text-gray-200 hover:bg-black hover:text-white transition flex items-center justify-center border border-gray-200 dark:border-white/10 shadow-sm" title="Share on X">
              <i class="fa-brands fa-x-twitter"></i>
            </a>
            <!-- LinkedIn -->
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($site . 'blog-details/' . $slug . '/') ?>" target="_blank" rel="noopener"
              class="w-10 h-10 rounded-full bg-sky-50 dark:bg-sky-950/60 text-sky-700 hover:bg-sky-700 hover:text-white transition flex items-center justify-center border border-sky-200 dark:border-sky-800 shadow-sm" title="Share on LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <!-- Copy Link Button -->
            <button type="button"
              @click="navigator.clipboard.writeText('<?= $site . 'blog-details/' . $slug . '/' ?>'); copied = true; setTimeout(() => copied = false, 2500)"
              class="px-3.5 py-2 rounded-full bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 hover:bg-emerald-500 hover:text-white text-xs font-semibold transition flex items-center gap-1.5 border border-gray-200 dark:border-white/10 shadow-sm">
              <i :class="copied ? 'fa-solid fa-check text-white' : 'fa-regular fa-copy'"></i>
              <span x-text="copied ? 'Link Copied!' : 'Copy Link'">Copy Link</span>
            </button>
          </div>
        </div>

      </div>
    </article>

    <!-- Rich Related Posts Section -->
    <?php if (!empty($related_slugs)): ?>
      <section class="py-12 px-4 sm:px-6 md:px-8 bg-slate-100/70 dark:bg-neutral-900/50 border-t border-gray-200 dark:border-white/10">
        <div class="max-w-6xl mx-auto">
          <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 mb-2 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 uppercase tracking-wider">
              More Insights
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">Related Travel &amp; Visa Guides</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 max-w-xl mx-auto">Continue reading expert itineraries and consular advice curated by our team.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($related_slugs as $rslug):
              $rpost = $posts[$rslug] ?? null;
              if (!$rpost) continue;
            ?>
              <article class="bg-white dark:bg-neutral-900 rounded-2xl overflow-hidden shadow-md border border-gray-200 dark:border-white/10 flex flex-col hover:-translate-y-1.5 transition-all duration-300">
                <a href="<?= $site ?>blog-details/<?= htmlspecialchars($rslug) ?>/" class="block relative h-48 overflow-hidden group">
                  <img src="<?= $site . $rpost['featured_image'] ?>" alt="<?= htmlspecialchars($rpost['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                  <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold text-white bg-black/60 backdrop-blur-md">
                    <?= htmlspecialchars($rpost['category']) ?>
                  </span>
                  <span class="absolute bottom-3 right-3 px-2.5 py-0.5 rounded-full text-[11px] font-medium text-white bg-black/60 backdrop-blur-md">
                    <i class="fa-regular fa-clock mr-1"></i><?= htmlspecialchars($rpost['read_time']) ?>
                  </span>
                </a>
                <div class="p-5 flex flex-col flex-grow">
                  <h3 class="font-bold text-gray-900 dark:text-white text-base sm:text-lg mb-2 line-clamp-2 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                    <a href="<?= $site ?>blog-details/<?= htmlspecialchars($rslug) ?>/">
                      <?= htmlspecialchars($rpost['title']) ?>
                    </a>
                  </h3>
                  <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed mb-4 flex-grow">
                    <?= htmlspecialchars($rpost['excerpt']) ?>
                  </p>
                  <div class="pt-3 border-t border-gray-100 dark:border-white/10 flex items-center justify-between text-xs">
                    <span class="text-gray-400"><?= htmlspecialchars($rpost['published_display']) ?></span>
                    <a href="<?= $site ?>blog-details/<?= htmlspecialchars($rslug) ?>/" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                      <span>Read Guide</span>
                      <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                  </div>
                </div>
              </article>
            <?php endforeach; ?>
          </div>

          <div class="text-center mt-10">
            <a href="<?= $site ?>blogs/" class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-white font-semibold text-sm bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md transition transform hover:scale-105">
              <i class="fa-solid fa-book-open"></i>
              <span>View All 8 Travel &amp; Visa Blogs</span>
            </a>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <!-- Bottom Full-Width CTA Banner -->
    <section class="py-12 px-4 sm:px-6 md:px-8">
      <div class="bg-gradient-to-r from-emerald-700 via-teal-800 to-emerald-900 text-white rounded-3xl shadow-xl p-8 sm:p-12 text-center max-w-5xl mx-auto relative overflow-hidden">
        <div class="relative z-10">
          <span class="inline-block px-4 py-1.5 mb-3 rounded-full text-xs font-bold bg-white/20 text-white uppercase tracking-wider backdrop-blur-md">
            Pan-India Travel &amp; Visa Advisory
          </span>
          <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-3">Planning a Holiday or Visa Filing?</h3>
          <p class="text-white/90 text-sm sm:text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
            Talk to our senior travel and immigration consultants serving New Delhi, Bangalore, Hyderabad, Pune, Chennai, Mumbai and travelers across the globe.
          </p>
          <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="<?= $site ?>contact/#contactform"
              class="px-7 py-3.5 bg-white text-emerald-800 font-bold rounded-xl shadow-lg hover:bg-gray-100 hover:scale-105 transition duration-300 text-sm sm:text-base flex items-center gap-2">
              <i class="fa-regular fa-paper-plane"></i>
              <span>Send An Enquiry</span>
            </a>
            <a href="tel:+91<?= $clean_phone ?>"
              class="px-7 py-3.5 bg-emerald-500/30 hover:bg-emerald-500/40 text-white font-bold rounded-xl border border-white/20 backdrop-blur-sm transition duration-300 text-sm sm:text-base flex items-center gap-2">
              <i class="fa-solid fa-phone"></i>
              <span>Call +91 <?= htmlspecialchars($phone) ?></span>
            </a>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Floating Mobile Action Bar (Mobile Screens Only) -->
  <aside class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border-t border-gray-200 dark:border-white/10 p-3 z-40 flex items-center justify-between gap-3 shadow-2xl">
    <div class="flex items-center gap-2">
      <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
      <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">Got Questions?</span>
    </div>
    <div class="flex items-center gap-2">
      <a href="https://api.whatsapp.com/send?phone=91<?= $clean_wp ?>&text=<?= urlencode('Hi Vocation Travels, I need quick travel & visa assistance for: ' . $post['title']) ?>"
        target="_blank" rel="noopener"
        class="px-3.5 py-2 rounded-xl bg-green-500 text-white text-xs font-bold flex items-center gap-1.5 shadow-md">
        <i class="fa-brands fa-whatsapp text-sm"></i>
        <span>WhatsApp</span>
      </a>
      <a href="tel:+91<?= $clean_phone ?>"
        class="px-3.5 py-2 rounded-xl bg-neutral-800 text-white text-xs font-bold flex items-center gap-1.5 shadow-md">
        <i class="fa-solid fa-phone text-xs"></i>
        <span>Call</span>
      </a>
    </div>
  </aside>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <!-- Alpine.js & Main Scripts with Local + CDN Fallback -->
  <script src="<?= $site ?>unpkg.com/alpinejs%403.15.8/dist/cdn.min.js" defer></script>
  <script>
    // Fallback if local unpkg fails
    window.addEventListener('DOMContentLoaded', function() {
      if (typeof Alpine === 'undefined') {
        var s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.15.8/dist/cdn.min.js';
        s.defer = true;
        document.head.appendChild(s);
      }
    });

    // Reading progress calculation
    window.addEventListener('scroll', function() {
      var docElem = document.documentElement;
      var docBody = document.body;
      var scrollTop = docElem['scrollTop'] || docBody['scrollTop'];
      var scrollBottom = (docElem['scrollHeight'] || docBody['scrollHeight']) - window.innerHeight;
      var scrollPercent = scrollBottom > 0 ? (scrollTop / scrollBottom) * 100 : 0;
      var bar = document.getElementById('reading-progress');
      if (bar) {
        bar.style.width = Math.min(100, Math.max(0, scrollPercent)) + '%';
      }
    }, { passive: true });
  </script>
  <script src="<?= $site ?>assets/js/main.js"></script>
</body>

</html>
