<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/visa_countries.php";

$contact = contact_us();
$countries = get_visa_countries();

$slug = isset($_GET['country']) ? preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['country'])) : '';
$country = get_visa_country($slug);

if (!$country) {
  header("Location: " . $site . "visa-services.php");
  exit;
}

$meta_title = $country['meta_title'];
$meta_description = $country['meta_description'];
$meta_keywords = $country['keywords'];
$canonical_path = 'visa-country.php?country=' . $slug;

// Related countries for internal linking (excluding current one)
$related = array_filter($countries, fn($k) => $k !== $slug, ARRAY_FILTER_USE_KEY);
$related = array_slice($related, 0, 3, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($meta_title) ?></title>
  <?php include('link.php') ?>
  <?php include('seo-meta.php') ?>

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

    <!-- Hero -->
    <section class="relative w-full overflow-hidden" style="padding-top: 10rem; padding-bottom: 5rem; background: linear-gradient(120deg, #0f2b12, #1a1a1a);">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="assets/videos/ContactUs.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="relative z-10 max-w-4xl mx-auto text-center px-4">
        <span class="text-6xl mb-4 inline-block"><?= $country['flag'] ?></span>
        <h1 class="text-white font-bold leading-tight text-4xl md:text-5xl mb-6 drop-shadow-lg">
          <?= htmlspecialchars($country['name']) ?> Visa Services in Hyderabad &amp; Bangalore
        </h1>
        <p class="text-gray-200 text-lg md:text-xl max-w-2xl mx-auto mb-6 font-light">
          <?= htmlspecialchars($country['hero_tagline']) ?>
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
      <span class="text-gray-700"><?= htmlspecialchars($country['name']) ?></span>
    </div>

    <!-- Intro -->
    <section class="py-10 bg-white">
      <div class="max-w-4xl mx-auto px-6">
        <p class="text-gray-600 text-lg leading-relaxed"><?= htmlspecialchars($country['intro']) ?></p>
      </div>
    </section>

    <!-- Visa Types -->
    <section class="py-12" style="background:#f9fafb;">
      <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center"><?= htmlspecialchars($country['name']) ?> Visa Types We Assist With</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <?php foreach ($country['visa_types'] as $type): ?>
            <div class="bg-white rounded-xl shadow p-6 border-t-4" style="border-color:#1ec700;">
              <h3 class="font-bold text-gray-800 mb-2"><?= htmlspecialchars($type['name']) ?></h3>
              <p class="text-gray-600 text-sm leading-relaxed"><?= htmlspecialchars($type['desc']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Documents + Process -->
    <section class="py-12 bg-white">
      <div class="max-w-5xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div>
          <h2 class="text-2xl font-bold text-gray-800 mb-6">Documents Typically Required</h2>
          <ul class="space-y-3">
            <?php foreach ($country['documents'] as $doc): ?>
              <li class="flex items-start gap-3">
                <i class="fa-solid fa-circle-check mt-1" style="color:#1ec700;"></i>
                <span class="text-gray-600"><?= htmlspecialchars($doc) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="text-gray-400 text-xs mt-4">Document requirements are general guidance and may vary by applicant profile — we confirm the exact list during consultation.</p>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Application Process</h2>
          <ol class="space-y-5">
            <?php foreach ($country['process_steps'] as $i => $step): ?>
              <li class="flex items-start gap-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm bg-gradient-to-r from-[#1ec700] to-[#e11d48]"><?= $i + 1 ?></span>
                <div>
                  <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($step['title']) ?></h3>
                  <p class="text-gray-600 text-sm"><?= htmlspecialchars($step['desc']) ?></p>
                </div>
              </li>
            <?php endforeach; ?>
          </ol>
          <p class="text-gray-500 text-sm mt-6"><strong>Processing time:</strong> <?= htmlspecialchars($country['processing_time']) ?></p>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="py-12" style="background:#f9fafb;">
      <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center"><?= htmlspecialchars($country['name']) ?> Visa FAQ</h2>
        <div class="space-y-4">
          <?php foreach ($country['faqs'] as $faq): ?>
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

    <!-- Related Countries -->
    <section class="py-12 bg-white">
      <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Explore Other Visa Destinations</h2>
        <div class="flex flex-wrap justify-center gap-4">
          <?php foreach ($related as $rslug => $rcountry): ?>
            <a href="visa-country.php?country=<?= htmlspecialchars($rslug) ?>"
              class="px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm transition">
              <?= $rcountry['flag'] ?> <?= htmlspecialchars($rcountry['name']) ?> Visa
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
        <h3 class="text-xl md:text-2xl font-bold mb-4">Apply for Your <?= htmlspecialchars($country['name']) ?> Visa with Confidence</h3>
        <p class="md:text-lg leading-relaxed">
          Our consultants in Hyderabad and Bangalore are ready to guide your <?= htmlspecialchars($country['name']) ?> visa application from start to finish.
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
