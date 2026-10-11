<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/blog_posts.php";

$contact = contact_us();
$posts = get_blog_posts();
uasort($posts, fn($a, $b) => strtotime($b['published']) <=> strtotime($a['published']));

$meta_title = 'Travel & Visa Blog | Guides, Tips & Insights – ' . ($contact['company_name'] ?? 'Vocation Travels');
$meta_description = 'Expert travel guides, visa documentation tips, luxury holiday planning, and destination reviews from senior travel consultants at Vocation Travels.';
$meta_keywords = ['travel blog india', 'visa tips bangalore', 'visa tips hyderabad', 'tour packages blog', 'travel guide pune', 'travel guide chennai', 'luxury travel hacks'];
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
    .blog-card {
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
    }
    .blog-card:hover {
      transform: translateY(-6px);
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-slate-50 dark:bg-neutral-950 text-slate-800 dark:text-gray-100 font-sans transition-colors duration-300">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Hero Section with Fallback Background & Video -->
    <section class="relative min-h-[460px] sm:min-h-[520px] w-full overflow-hidden flex items-center justify-center pt-32 pb-16 bg-neutral-950">
      <!-- Background Fallback Image (Guarantees Instant Visibility) -->
      <img src="<?= $site ?>assets/images/luxury_travel_hero.jpg" alt="Vocation Travels Blog" class="absolute inset-0 w-full h-full object-cover filter brightness-50">
      
      <!-- Ambient Video Layer -->
      <video class="absolute inset-0 w-full h-full object-cover opacity-60" autoplay muted loop playsinline poster="<?= $site ?>assets/images/luxury_travel_hero.jpg">
        <source src="<?= $site ?>assets/videos/blogvideo.mp4" type="video/mp4">
        <source src="<?= $site ?>assets/videos/Services.mp4" type="video/mp4">
      </video>

      <!-- Gradient Overlays for High Legibility -->
      <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/60 to-black/70"></div>

      <!-- Hero Content -->
      <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center space-x-2 py-1.5 px-4 mb-4 rounded-full bg-white/10 backdrop-blur-md text-emerald-400 text-xs sm:text-sm font-semibold border border-white/10 shadow-lg">
          <i class="fa-solid fa-compass animate-spin text-xs" style="animation-duration: 8s;"></i>
          <span>Curated Travel Guides &bull; Visa Advisory &bull; Holiday Tips</span>
        </div>

        <h1 class="text-white font-extrabold leading-tight text-3xl sm:text-5xl md:text-6xl mb-4 drop-shadow-2xl">
          Travel Stories &amp; <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-rose-400 text-transparent bg-clip-text">Expert Insights</span>
        </h1>

        <p class="text-gray-200 text-sm sm:text-lg max-w-2xl mx-auto font-light leading-relaxed drop-shadow">
          Uncover destination itineraries, master visa application requirements across India, and travel the globe with effortless luxury.
        </p>

        <!-- Search Bar -->
        <div class="mt-8 max-w-xl mx-auto">
          <div class="relative">
            <input type="text" id="blogSearch" onkeyup="filterBlogs()" placeholder="Search articles (e.g., Visa, Kerala, Luxury, Bali)..."
              class="w-full px-5 py-3.5 pl-12 rounded-full bg-white/90 dark:bg-neutral-900/90 text-gray-900 dark:text-white placeholder-gray-500 border border-white/20 shadow-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm backdrop-blur-md">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
          </div>
        </div>
      </div>
    </section>

    <!-- Category Filter Pills -->
    <section class="py-6 bg-white dark:bg-neutral-900 border-b border-gray-200 dark:border-white/10 sticky top-[72px] z-20 backdrop-blur-md bg-opacity-90 dark:bg-opacity-90">
      <div class="max-w-7xl mx-auto px-6 flex items-center justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-2 overflow-x-auto py-1 text-xs font-semibold">
          <button onclick="filterCategory('all')" class="cat-pill active px-4 py-2 rounded-full bg-emerald-600 text-white shadow-sm transition">
            All Articles (<?= count($posts) ?>)
          </button>
          <button onclick="filterCategory('Travel')" class="cat-pill px-4 py-2 rounded-full bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 hover:bg-emerald-50 hover:text-emerald-600 transition">
            <i class="fa-solid fa-umbrella-beach mr-1 text-emerald-500"></i> Holiday Packages
          </button>
          <button onclick="filterCategory('Visa')" class="cat-pill px-4 py-2 rounded-full bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 hover:bg-emerald-50 hover:text-emerald-600 transition">
            <i class="fa-solid fa-passport mr-1 text-blue-500"></i> Visa Guidance
          </button>
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">
          <span>Updated Weekly by Senior Travel Specialists</span>
        </div>
      </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="py-14 px-6 md:px-12 lg:px-20">
      <div class="max-w-7xl mx-auto">
        <div id="blogGrid" class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
          <?php foreach ($posts as $pslug => $p): ?>
            <article class="blog-card flex flex-col justify-between bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden border border-gray-200 dark:border-white/10 shadow-lg hover:shadow-2xl transition duration-300"
              data-category="<?= htmlspecialchars($p['category']) ?>"
              data-title="<?= htmlspecialchars(strtolower($p['title'])) ?>"
              data-excerpt="<?= htmlspecialchars(strtolower($p['excerpt'])) ?>">
              
              <div>
                <!-- Image Wrapper -->
                <div class="relative overflow-hidden h-56 bg-slate-800">
                  <a href="<?= $site ?>blog-details/<?= htmlspecialchars($pslug) ?>/">
                    <img src="<?= $site . $p['hero_image'] ?>" alt="<?= htmlspecialchars($p['title']) ?>"
                      class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                      loading="lazy">
                  </a>
                  <!-- Category Badge -->
                  <div class="absolute top-4 left-4">
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 shadow-md">
                      <?= htmlspecialchars($p['category']) ?>
                    </span>
                  </div>
                  <!-- Read Time Badge -->
                  <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-sm text-white px-2.5 py-1 rounded-full text-[10px] font-medium">
                    <i class="fa-regular fa-clock mr-1"></i><?= htmlspecialchars($p['read_time']) ?>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                  <!-- Metadata Row -->
                  <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 mb-3">
                    <span><i class="fa-regular fa-calendar mr-1 text-emerald-500"></i><?= htmlspecialchars($p['published_display']) ?></span>
                    <span>&bull;</span>
                    <span><i class="fa-solid fa-feather mr-1 text-emerald-500"></i>Editorial Team</span>
                  </div>

                  <!-- Post Title -->
                  <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 hover:text-emerald-600 dark:hover:text-emerald-400 transition leading-snug">
                    <a href="<?= $site ?>blog-details/<?= htmlspecialchars($pslug) ?>/">
                      <?= htmlspecialchars($p['title']) ?>
                    </a>
                  </h2>

                  <!-- Excerpt -->
                  <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-4">
                    <?= htmlspecialchars($p['excerpt']) ?>
                  </p>
                </div>
              </div>

              <!-- Footer CTA Link -->
              <div class="px-6 pb-6 pt-2 border-t border-gray-100 dark:border-white/5 flex items-center justify-between">
                <a href="<?= $site ?>blog-details/<?= htmlspecialchars($pslug) ?>/"
                  class="inline-flex items-center font-bold text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition group">
                  <span>Read Article</span>
                  <i class="fa-solid fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
                <span class="text-xs text-gray-400"><i class="fa-solid fa-share-nodes"></i></span>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <!-- No Results Found State -->
        <div id="noResults" class="hidden text-center py-16 bg-white dark:bg-neutral-900 rounded-3xl border border-gray-200 dark:border-white/10 mt-6 p-8">
          <i class="fa-solid fa-book-open text-4xl text-gray-400 mb-3"></i>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">No articles matched your search</h3>
          <p class="text-sm text-gray-500 mt-1">Try searching for keywords like "visa", "package", "kerala", or "luxury".</p>
        </div>
      </div>
    </section>

    <!-- Bottom Cross-Pillar CTA Section -->
    <section class="py-14 bg-gradient-to-r from-emerald-950 via-slate-900 to-blue-950 text-white border-t border-white/10">
      <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="max-w-2xl text-center md:text-left">
          <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 mb-3">
            Ready to Travel?
          </span>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-2 leading-tight">
            Turn Travel Inspiration Into an Unforgettable Journey
          </h3>
          <p class="text-gray-300 text-sm leading-relaxed">
            From handcrafted domestic tours in Kashmir and Kerala to fast-track visa filing for the USA, UK, and Europe — let our concierge handle every detail.
          </p>
        </div>
        <div class="flex flex-wrap gap-3 flex-shrink-0">
          <a href="<?= $site ?>travel-package/" class="px-6 py-3 rounded-full font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:scale-105 shadow-lg transition text-sm">
            Explore Tour Packages
          </a>
          <a href="<?= $site ?>visa-services/" class="px-6 py-3 rounded-full font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 transition text-sm">
            Visa Services (40+ Cities)
          </a>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <!-- Interactive Filtering Script -->
  <script>
    function filterBlogs() {
      const query = document.getElementById('blogSearch').value.toLowerCase().trim();
      const articles = document.querySelectorAll('#blogGrid article');
      let visibleCount = 0;

      articles.forEach(article => {
        const title = article.getAttribute('data-title') || '';
        const excerpt = article.getAttribute('data-excerpt') || '';
        const match = title.includes(query) || excerpt.includes(query);

        if (match) {
          article.style.display = 'flex';
          visibleCount++;
        } else {
          article.style.display = 'none';
        }
      });

      const noResults = document.getElementById('noResults');
      if (noResults) {
        noResults.classList.toggle('hidden', visibleCount > 0);
      }
    }

    function filterCategory(category) {
      // Update active tab buttons
      document.querySelectorAll('.cat-pill').forEach(btn => {
        btn.classList.remove('bg-emerald-600', 'text-white');
        btn.classList.add('bg-gray-100', 'dark:bg-neutral-800', 'text-gray-700', 'dark:text-gray-300');
      });
      event.target.classList.add('bg-emerald-600', 'text-white');
      event.target.classList.remove('bg-gray-100', 'dark:bg-neutral-800', 'text-gray-700', 'dark:text-gray-300');

      const articles = document.querySelectorAll('#blogGrid article');
      let visibleCount = 0;

      articles.forEach(article => {
        const cat = article.getAttribute('data-category') || '';
        if (category === 'all' || cat.toLowerCase() === category.toLowerCase()) {
          article.style.display = 'flex';
          visibleCount++;
        } else {
          article.style.display = 'none';
        }
      });

      const noResults = document.getElementById('noResults');
      if (noResults) {
        noResults.classList.toggle('hidden', visibleCount > 0);
      }
    }
  </script>
</body>
</html>