<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/visa_cities.php";
include_once __DIR__ . "/../util/visa_countries.php";

$contact = contact_us();
$cities = get_visa_cities();
uasort($cities, fn($a, $b) => $a['order'] <=> $b['order']);

$slug = isset($_GET['city']) ? preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['city'])) : '';
$city = get_visa_city($slug);

if (!$city) {
  header("Location: " . $site . "visa-services.php");
  exit;
}

$countries = get_visa_countries();
$other_cities = array_filter($cities, fn($k) => $k !== $slug, ARRAY_FILTER_USE_KEY);

$meta_title = $city['meta_title'];
$meta_description = $city['meta_description'];
$meta_keywords = $city['keywords'];
$canonical_path = 'visa-consultants.php?city=' . $slug;

// Schema.org structured data (technical SEO): Service + FAQPage + BreadcrumbList.
// Note: this is a service-area business (no physical branch office claimed in this city),
// so we deliberately omit a street address in the schema rather than fabricate one.
$schema = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'Service',
      'serviceType' => 'Visa and Immigration Consultancy',
      'name' => $city['hero_h1'],
      'areaServed' => [
        '@type' => 'City',
        'name' => $city['name'],
      ],
      'provider' => [
        '@type' => 'TravelAgency',
        'name' => $contact['company_name'] ?? 'Vocation Travels And Tours',
        'telephone' => $contact['phone'] ?? '',
        'email' => $contact['email'] ?? '',
        'url' => $site . 'visa-consultants.php?city=' . $slug,
      ],
      'description' => $city['meta_description'],
    ],
    [
      '@type' => 'FAQPage',
      'mainEntity' => array_map(fn($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $faq['a'],
        ],
      ], $city['faqs']),
    ],
    [
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Visa Services', 'item' => $site . 'visa-services.php'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $city['hero_h1'], 'item' => $site . 'visa-consultants.php?city=' . $slug],
      ],
    ],
  ],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($meta_title) ?></title>
  <?php include('link.php') ?>
  <?php include('seo-meta.php') ?>
  <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

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

    .service-card {
      background: #fff;
      border-radius: 1.25rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      border-top: 4px solid transparent;
      border-image: linear-gradient(to right, #1ec700, #e11d48) 1;
      transition: transform .3s ease, box-shadow .3s ease;
    }

    .service-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.14);
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-gray-100">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Hero -->
    <section class="relative w-full overflow-hidden" style="padding-top: 10rem; padding-bottom: 5rem; background: linear-gradient(120deg, #0f2b12, #1a1a1a);">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="assets/videos/about_1.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 opacity-30" style="background: radial-gradient(circle at 20% 20%, #1ec700 0%, transparent 40%), radial-gradient(circle at 80% 80%, #e11d48 0%, transparent 40%);"></div>
      <div class="relative z-10 max-w-4xl mx-auto text-center px-4">
        <h1 class="text-white font-bold leading-tight text-4xl md:text-5xl mb-6 drop-shadow-lg">
          <?= htmlspecialchars($city['hero_h1']) ?>
        </h1>
        <p class="text-gray-200 text-lg md:text-xl max-w-2xl mx-auto mb-6 font-light">
          <?= htmlspecialchars($city['hero_tagline']) ?>
        </p>
        <a href="contact.php#contactform"
          class="inline-block px-8 py-3 rounded-full text-white font-medium bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition-all duration-200">
          Get Free Consultation
        </a>
      </div>
    </section>

    <!-- Breadcrumb -->
    <div class="max-w-5xl mx-auto px-6 pt-6 text-sm text-gray-500">
      <a href="index.php" class="hover:underline">Home</a> /
      <a href="visa-services.php" class="hover:underline">Visa Services</a> /
      <span class="text-gray-700"><?= htmlspecialchars($city['name']) ?></span>
    </div>

    <!-- Intro -->
    <section class="py-10 bg-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($city['intro_heading']) ?></h2>
        <p class="text-gray-600 text-lg leading-relaxed"><?= htmlspecialchars($city['intro']) ?></p>
      </div>
    </section>

    <!-- Services Grid -->
    <section class="py-14" style="background:#f9fafb;">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Our Visa &amp; Immigration Services in <?= htmlspecialchars($city['name']) ?></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($city['services'] as $service): ?>
            <div class="service-card p-6">
              <i class="fa-solid <?= htmlspecialchars($service['icon']) ?> text-3xl mb-4" style="color:#1ec700;"></i>
              <h3 class="text-lg font-bold text-gray-800 mb-2"><?= htmlspecialchars($service['title']) ?></h3>
              <p class="text-gray-600 text-sm leading-relaxed mb-3"><?= htmlspecialchars($service['desc']) ?></p>
              <?php if (!empty($service['country_link']) && isset($countries[$service['country_link']])): ?>
                <a href="visa-country.php?country=<?= htmlspecialchars($service['country_link']) ?>"
                  class="text-sm font-semibold" style="color:#e11d48;">
                  View <?= htmlspecialchars($countries[$service['country_link']]['name']) ?> Visa Details &rarr;
                </a>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Why <?= htmlspecialchars($city['name']) ?> Applicants Choose Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
          <div class="p-6">
            <i class="fa-solid fa-file-circle-check text-4xl mb-4" style="color:#1ec700;"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Checklist-Driven Documentation</h3>
            <p class="text-gray-600">We help you avoid the common documentation gaps that lead to visa delays or rejections.</p>
          </div>
          <div class="p-6">
            <i class="fa-solid fa-comments text-4xl mb-4" style="color:#1ec700;"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Transparent, No-Guarantee Guidance</h3>
            <p class="text-gray-600">No consultant can guarantee visa approval — we focus on helping you submit the strongest possible application.</p>
          </div>
          <div class="p-6">
            <i class="fa-solid fa-globe text-4xl mb-4" style="color:#1ec700;"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Pan-India &amp; International Reach</h3>
            <p class="text-gray-600">Serving <?= htmlspecialchars($city['name']) ?> and clients across India, with an international office presence in Dubai and Canada.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="py-16" style="background:#f9fafb;">
      <div class="max-w-4xl mx-auto px-6" x-data="{ openFaq: null }">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800"><?= htmlspecialchars($city['name']) ?> Visa Consultants FAQ</h2>
        <div class="space-y-4">
          <?php foreach ($city['faqs'] as $faq): ?>
            <div x-data="{ open: false }" @click="open = !open"
              class="bg-white rounded-xl shadow p-5 cursor-pointer border-l-4" style="border-color:#1ec700;">
              <div class="flex justify-between items-center">
                <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($faq['q']) ?></h3>
                <i :class="open ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="text-gray-500"></i>
              </div>
              <div x-show="open" x-transition class="mt-3 text-gray-600 leading-relaxed">
                <?= htmlspecialchars($faq['a']) ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Other City / Related Links -->
    <section class="py-12 bg-white">
      <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Explore More</h2>
        <div class="flex flex-wrap justify-center gap-4">
          <?php foreach ($other_cities as $oslug => $ocity): ?>
            <a href="visa-consultants.php?city=<?= htmlspecialchars($oslug) ?>"
              class="px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm transition">
              Visa Consultants in <?= htmlspecialchars($ocity['name']) ?>
            </a>
          <?php endforeach; ?>
          <a href="visa-services.php"
            class="px-5 py-2 rounded-full text-white font-medium text-sm bg-gradient-to-r from-[#1ec700] to-[#e11d48] transition">
            View All Visa Services
          </a>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-12 px-4 sm:px-8 md:px-16">
      <div class="bg-gradient-to-r from-green-600 to-red-600 text-white rounded-2xl shadow-lg p-8 text-center max-w-4xl mx-auto">
        <h3 class="text-xl md:text-2xl font-bold mb-4">Talk to Our <?= htmlspecialchars($city['name']) ?> Visa Team</h3>
        <p class="md:text-lg leading-relaxed">
          Get a free, no-obligation review of your visa documentation and next steps.
        </p>
        <a href="contact.php#contactform"
          class="mt-6 inline-block px-6 py-3 bg-white text-green-700 font-semibold rounded-lg shadow-md hover:scale-105 transition duration-300">
          Enquire Now
        </a>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <!-- Scripts -->
  <script src="../unpkg.com/alpinejs%403.15.8/dist/cdn.min.js" defer></script>
  <script src="assets/js/main.js"></script>
</body>

</html>
