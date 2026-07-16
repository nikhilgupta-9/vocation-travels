<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/visa_countries.php";

$contact = contact_us();
$countries = get_visa_countries();
uasort($countries, fn($a, $b) => $a['order'] <=> $b['order']);

$meta_title = 'Visa Services in Hyderabad & Bangalore | International Visa Consultants – ' . $contact['company_name'];
$meta_description = 'Trusted visa consultants serving Hyderabad, Bangalore and all of India for USA, UK, Canada, Europe (Schengen), Australia, Japan, Singapore and UAE/Dubai visas. Documentation, application filing and interview preparation support.';
$meta_keywords = ['visa services Hyderabad', 'visa consultants Bangalore', 'visa agent India', 'international visa assistance', 'tourist visa consultants Hyderabad', 'business visa Bangalore', 'USA visa', 'UK visa', 'Canada visa', 'Europe Schengen visa', 'Australia visa', 'Japan visa', 'Singapore visa', 'UAE Dubai visa'];
$canonical_path = 'visa-services.php';
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

    .country-card {
      background: #fff;
      border-radius: 1.25rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      border-bottom: 5px solid transparent;
      border-image: linear-gradient(to right, #1ec700, #e11d48) 1;
      transition: transform .3s ease, box-shadow .3s ease;
    }

    .country-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.14);
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-gray-100">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Hero Section -->
    <section class="relative w-full overflow-hidden" style="padding-top: 10rem; padding-bottom: 6rem; background: linear-gradient(120deg, #0f2b12, #1a1a1a);">
      
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="assets/videos/about_1.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 opacity-30" style="background: radial-gradient(circle at 20% 20%, #1ec700 0%, transparent 40%), radial-gradient(circle at 80% 80%, #e11d48 0%, transparent 40%);"></div>
      <div class="relative z-10 max-w-5xl mx-auto text-center px-4">
        <h1 class="text-white font-bold leading-tight text-4xl md:text-5xl lg:text-6xl mb-6 drop-shadow-lg">
          Visa Services in Hyderabad &amp; Bangalore
        </h1>
        <p class="text-gray-200 text-lg md:text-xl max-w-3xl mx-auto mb-6 font-light">
          International visa consultants trusted by travelers across Hyderabad, Bangalore and all of India — for
          tourist, business and family-visit visas to the USA, UK, Canada, Europe, Australia, Japan, Singapore, UAE and more.
        </p>
        <a href="contact.php#contactform"
          class="inline-block px-8 py-3 rounded-full text-white font-medium bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition-all duration-200">
          Get Free Visa Consultation
        </a>
      </div>
    </section>

    <!-- Intro / Local SEO block -->
    <section class="py-14 bg-white">
      <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
          Visa Consultants Serving Hyderabad &amp; Bangalore Travelers, Pan-India and Beyond
        </h2>
        <p class="text-gray-600 text-lg leading-relaxed">
          Whether you're based in Hyderabad, Bangalore, or anywhere else in India, our visa team helps you prepare
          accurate documentation, complete online applications, book visa centre appointments and get interview-ready —
          for both leisure trips and business travel abroad. We combine India-wide reach with hands-on, country-specific
          expertise across all major visa destinations.
        </p>
      </div>
    </section>

    <!-- Country Grid -->
    <section class="py-16" style="background:#f9fafb;">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Visa Services by Destination Country</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <?php foreach ($countries as $slug => $country): ?>
            <a href="visa-country.php?country=<?= htmlspecialchars($slug) ?>" class="country-card p-6 flex flex-col items-center text-center">
              <span class="text-5xl mb-4"><?= $country['flag'] ?></span>
              <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($country['name']) ?> Visa</h3>
              <p class="text-gray-500 text-sm mb-4"><?= htmlspecialchars($country['hero_tagline']) ?></p>
              <span class="mt-auto inline-block px-5 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48]">
                View Details
              </span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Why Travelers Choose Our Visa Consultants</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
          <div class="p-6">
            <i class="fa-solid fa-passport text-4xl mb-4" style="color:#1ec700;"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">End-to-End Documentation Support</h3>
            <p class="text-gray-600">From checklists to form-filling, we help applicants across Hyderabad and Bangalore avoid common visa rejection reasons.</p>
          </div>
          <div class="p-6">
            <i class="fa-solid fa-calendar-check text-4xl mb-4" style="color:#1ec700;"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Appointment &amp; Application Booking</h3>
            <p class="text-gray-600">We handle visa application centre appointments and portal submissions so you don't have to navigate them alone.</p>
          </div>
          <div class="p-6">
            <i class="fa-solid fa-globe text-4xl mb-4" style="color:#1ec700;"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Pan-India &amp; International Reach</h3>
            <p class="text-gray-600">Serving clients across Hyderabad, Bangalore and India, with an international office presence in Dubai and Canada.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- General FAQ -->
    <section class="py-16" style="background:#f9fafb;">
      <div class="max-w-4xl mx-auto px-6" x-data="{ openFaq: null }">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Visa Services FAQ</h2>

        <div class="space-y-4">
          <?php
          $general_faqs = [
            ['q' => 'Do you provide visa services in Hyderabad and Bangalore?', 'a' => 'Yes, we assist travelers based in Hyderabad, Bangalore and across India with documentation, applications and appointment bookings for all major visa destinations.'],
            ['q' => 'Which countries do you help travelers apply visas for?', 'a' => 'We currently support USA, UK, Canada, Europe (Schengen), Australia, Japan, Singapore and UAE/Dubai visas, with more destinations added regularly.'],
            ['q' => 'Can you guarantee visa approval?', 'a' => 'No visa consultant can guarantee approval, as the final decision rests with the respective embassy or consulate. We focus on helping you submit the strongest possible application.'],
            ['q' => 'How do I get started?', 'a' => 'Reach out through our contact form or call us — we\'ll review your travel plans and recommend the right visa category and next steps.'],
          ];
          foreach ($general_faqs as $i => $faq): ?>
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

    <!-- CTA -->
    <section class="py-12 px-4 sm:px-8 md:px-16">
      <div class="bg-gradient-to-r from-green-600 to-red-600 text-white rounded-2xl shadow-lg p-8 text-center max-w-4xl mx-auto">
        <h3 class="text-xl md:text-2xl font-bold mb-4">Ready to Start Your Visa Application?</h3>
        <p class="md:text-lg leading-relaxed">
          Talk to our visa consultants serving Hyderabad, Bangalore and all of India — we'll guide you through every step.
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
