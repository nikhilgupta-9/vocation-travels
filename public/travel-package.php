<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();

$meta_title = 'Tour Packages – Domestic & International Holiday Packages | ' . ($contact['company_name'] ?? 'Vocation Travels');
$meta_description = 'Browse exclusive domestic and international holiday tour packages crafted for unforgettable experiences. Curated itineraries for travelers across India (Delhi, Mumbai, Bangalore, Hyderabad & 40+ cities).';
$meta_keywords = ['travel packages India', 'international tour packages', 'domestic tour packages India', 'holiday packages Delhi', 'holiday packages Mumbai', 'holiday packages Bangalore', 'book travel package 2026'];
$canonical_path = 'travel-package/';

// Dynamic Package ItemList Schema
$pkg_items = [];
$p_idx = 1;
if ($conn && !$conn->connect_error) {
  $p_res = @mysqli_query($conn, "SELECT title, slug, price, duration FROM packages WHERE status = 1 ORDER BY featured DESC, id DESC LIMIT 12");
  if ($p_res) {
    while ($p = mysqli_fetch_assoc($p_res)) {
      $pkg_items[] = [
        '@type' => 'ListItem',
        'position' => $p_idx++,
        'name' => $p['title'],
        'url' => $site . 'package/' . $p['slug'] . '/',
      ];
    }
  }
}

$travel_package_schema = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'CollectionPage',
      '@id' => $site . 'travel-package/#webpage',
      'url' => $site . 'travel-package/',
      'name' => $meta_title,
      'description' => $meta_description,
      'breadcrumb' => [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
          ['@type' => 'ListItem', 'position' => 2, 'name' => 'Travel Packages', 'item' => $site . 'travel-package/'],
        ]
      ]
    ],
    [
      '@type' => 'ItemList',
      'name' => 'Featured Tour & Holiday Packages',
      'itemListElement' => $pkg_items
    ],
    [
      '@type' => 'FAQPage',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => 'Can Vocation Travels tour packages be customized?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Yes, absolutely. Every tour package can be personalized according to your preferred travel dates, duration, hotel tier (4-star or 5-star), vehicle preferences, and private sightseeing desires.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'Do you provide international visa assistance with holiday packages?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Yes. Vocation Travels provides comprehensive in-house visa consultancy for international destinations including Dubai, Europe (Schengen), the UK, USA, Canada, and Australia.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'What is included in Vocation Travels holiday tour packages?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'All our packages include handpicked hotel accommodations, daily breakfast, private AC chauffeur-driven transfers, airport pick-up/drop, and curated guided sightseeing tours.'
          ]
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include('seo-meta.php') ?>
  <title><?= htmlspecialchars($meta_title) ?></title>
  <?php include('link.php') ?>
  <script type="application/ld+json"><?= json_encode($travel_package_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

  <style>
    .body {
      padding: 0px !important;
    }

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

    @keyframes fade-in-up {
      0% {
        opacity: 0;
        transform: translateY(40px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fade-in-down {
      0% {
        opacity: 0;
        transform: translateY(-40px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in-up {
      animation: fade-in-up 0.8s cubic-bezier(.4, 0, .2, 1) both;
    }

    .animate-fade-in-up.delay-100 {
      animation-delay: 0.1s;
    }

    .animate-fade-in-up.delay-200 {
      animation-delay: 0.2s;
    }

    .animate-fade-in-up.delay-300 {
      animation-delay: 0.3s;
    }

    .animate-fade-in-up.delay-400 {
      animation-delay: 0.4s;
    }

    .animate-fade-in-down {
      animation: fade-in-down 0.8s cubic-bezier(.4, 0, .2, 1) both;
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">
    <!-- Luxury Banner Section with Video Background -->
    <section class="relative h-screen w-full overflow-hidden">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline preload="auto">
        <source src="<?= $site ?>assets/videos/TravelPackages.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1
          class="text-white font-bold leading-tight text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl mb-6 drop-shadow-lg">
          Travel Packages</h1>
        <p class="text-indigo-100 text-lg sm:text-xl md:text-2xl max-w-2xl mb-4 font-light drop-shadow">
          Explore our exclusive travel packages designed to create unforgettable experiences.
        </p>
        <a href="<?= $site ?>contact/#contactform"
          class="inline-block px-6 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition-colors duration-200 mt-4">
          Book Now
        </a>
      </div>
    </section>

    <section style="padding: 4rem 0; background: #f9fafb">
      <div class="max-w-7xl mx-auto px-4">
        <!-- Domestic Tour Packages -->
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800 animate-fade-in-down">Incredible Indian Packages
        </h2>


        <!-- Tours Section -->
        <!-- ===== TOUR PACKAGES SECTION ===== -->
        <div class="flex flex-col lg:flex-row justify-center items-center gap-8 flex-wrap">
          <?php echo displayPackages('domestic'); ?>
        </div>

      </div>
    </section>

    <!-- CTA Box Section Start -->
    <section class="bg-gray-100 py-12">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-1 items-center gap-6">

          <!-- CTA Text -->
          <div class="md:col-span-3">
            <h2 class="text-2xl md:text-3xl text-center font-bold text-gray-800 leading-snug">
              Explore New Horizons, Create Timeless Memories
            </h2>
            <p class="mt-3 text-gray-600 text-lg text-center">
              Join our exclusive travel community and embark on journeys to breathtaking destinations, <br>curated
              itineraries, and unforgettable experiences around the world.
            </p>
          </div>

          <!-- CTA Button -->
          <div class="flex justify-center md:justify-center">
            <a href="<?= $site ?>contact/#contactform" class="inline-block px-6 py-3 rounded-xl font-semibold text-white 
                  bg-gradient-to-r from-[#1ec700] via-[#1ec700] to-[#e11d48] 
                  shadow-lg hover:scale-105 hover:shadow-xl 
                  transition-all duration-300" style="border-radius: 35px;">
              Start Your Journey
            </a>
          </div>

        </div>
      </div>
    </section>

    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4">
        <!-- International Tour Packages -->
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800 animate-fade-in-down">International Tour Packages
        </h2>
        <div class="flex flex-col lg:flex-row justify-center items-center gap-8 mb-16 flex-wrap">

          <div class="flex flex-col lg:flex-row justify-center items-center gap-8 flex-wrap">
            <?php echo displayPackages('international'); ?>
          </div>

        </div>

      </div>

    </section>

    <!-- ===== CUSTOMIZATION NOTE SECTION ===== -->
    <section class="py-12 px-4 sm:px-8 md:px-16">
      <div
        class="bg-gradient-to-r from-green-600 to-red-600 text-white rounded-2xl shadow-lg p-8 text-center max-w-4xl mx-auto">
        <h3 class="text-xl md:text-2xl font-bold mb-4">Ultra-Elite & Exclusive Tone Luxury Beyond Boundaries</h3>
        <p class="text-justify md:text-lg leading-relaxed">
          These packages reflect starting prices, but for our esteemed travelers, possibilities are limitless. From
          bespoke private transfers to stays in world-renowned suites, every journey is tailored to your personal
          preferences, ensuring an unparalleled and unforgettable experience.
        </p>
        <a href="<?= $site ?>contact/#contactform"
          class="mt-6 inline-block px-6 py-3 bg-white text-green-700 font-semibold rounded-lg shadow-md hover:scale-105 transition duration-300">
          Enquire for Luxury Upgrades
        </a>
      </div>
    </section>

    <!-- ===== CROSS-PILLAR VISA INTERNAL LINKING BANNER ===== -->
    <section class="py-10 px-4 sm:px-8 md:px-16 bg-slate-900 text-white">
      <div class="max-w-6xl mx-auto rounded-3xl bg-gradient-to-r from-emerald-900/60 via-slate-800 to-blue-950 p-8 md:p-12 border border-emerald-500/30 flex flex-col md:flex-row items-center justify-between gap-8 shadow-2xl">
        <div class="max-w-2xl">
          <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 mb-3">
            Hassle-Free Global Travel
          </span>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-3 leading-tight">
            Traveling Internationally? Get Fast-Track Visa Approval
          </h3>
          <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
            Avoid visa delays and rejections. Our in-house visa specialists handle document preparation, biometric appointments, and embassy submission for top destinations worldwide across 40+ Indian cities.
          </p>
          <div class="flex flex-wrap gap-2 mt-4 text-xs font-medium">
            <a href="<?= $site ?>visa-services/uae/" class="px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 transition text-gray-200">🇦🇪 Dubai / UAE</a>
            <a href="<?= $site ?>visa-services/europe/" class="px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 transition text-gray-200">🇪🇺 Schengen Europe</a>
            <a href="<?= $site ?>visa-services/uk/" class="px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 transition text-gray-200">🇬🇧 United Kingdom</a>
            <a href="<?= $site ?>visa-services/usa/" class="px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 transition text-gray-200">🇺🇸 United States</a>
          </div>
        </div>
        <div class="flex-shrink-0 text-center">
          <a href="<?= $site ?>visa-services/" class="inline-flex items-center px-8 py-4 rounded-full font-bold text-slate-900 bg-gradient-to-r from-emerald-400 to-teal-300 hover:from-emerald-300 hover:to-teal-200 shadow-xl hover:scale-105 transition duration-300">
            <span>Explore Visa Services</span>
            <i class="fa-solid fa-arrow-right ml-2.5"></i>
          </a>
          <p class="text-[11px] text-gray-400 mt-2">Free Consultation &bull; 99% Approval Rate</p>
        </div>
      </div>
    </section>

    <!-- ===== FREQUENTLY ASKED QUESTIONS (FAQ) ===== -->
    <section class="py-16 px-4 sm:px-8 md:px-16 bg-white">
      <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
          <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
            Got Questions?
          </span>
          <h2 class="text-3xl font-extrabold text-gray-900 mt-3">
            Frequently Asked Questions About Holiday Packages
          </h2>
        </div>

        <div class="space-y-4">
          <div class="border border-gray-200 rounded-2xl p-5 hover:border-emerald-500/50 transition">
            <h4 class="font-bold text-gray-900 text-base mb-2 flex items-center">
              <i class="fa-solid fa-circle-question text-emerald-600 mr-2.5"></i>
              Can Vocation Travels holiday tour packages be customized?
            </h4>
            <p class="text-sm text-gray-600 leading-relaxed pl-6">
              Yes, absolutely. Every tour package can be personalized according to your preferred travel dates, duration, hotel tier (4-star or 5-star), vehicle preferences, and private sightseeing desires. Reach out via our <a href="<?= $site ?>contact/#contactform" class="text-emerald-600 font-semibold underline">inquiry form</a> or WhatsApp for an instant custom quote.
            </p>
          </div>

          <div class="border border-gray-200 rounded-2xl p-5 hover:border-emerald-500/50 transition">
            <h4 class="font-bold text-gray-900 text-base mb-2 flex items-center">
              <i class="fa-solid fa-circle-question text-emerald-600 mr-2.5"></i>
              Do you provide international visa assistance with holiday packages?
            </h4>
            <p class="text-sm text-gray-600 leading-relaxed pl-6">
              Yes. Vocation Travels provides comprehensive in-house visa consultancy for international destinations including Dubai, Europe (Schengen), the UK, USA, Canada, and Australia. You can view full requirements on our <a href="<?= $site ?>visa-services/" class="text-emerald-600 font-semibold underline">Visa Services page</a>.
            </p>
          </div>

          <div class="border border-gray-200 rounded-2xl p-5 hover:border-emerald-500/50 transition">
            <h4 class="font-bold text-gray-900 text-base mb-2 flex items-center">
              <i class="fa-solid fa-circle-question text-emerald-600 mr-2.5"></i>
              What is included in Vocation Travels tour packages?
            </h4>
            <p class="text-sm text-gray-600 leading-relaxed pl-6">
              All our packages include handpicked hotel accommodations, daily breakfast, private AC chauffeur-driven transfers, airport pick-up and drop-off, and curated guided sightseeing tours. Specific inclusions vary per itinerary and are itemized on each dedicated package page.
            </p>
          </div>
        </div>
      </div>
    </section>

  </main>
  <?php include('footer.php') ?>

  <script src="<?= $site ?>assets/js/main.js"></script>


</body>

</html>