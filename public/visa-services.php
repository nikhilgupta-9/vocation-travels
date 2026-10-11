<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/visa_countries.php";
include_once __DIR__ . "/../util/visa_cities.php";

$contact = contact_us();
$countries = get_visa_countries();
uasort($countries, fn($a, $b) => $a['order'] <=> $b['order']);
$cities = get_visa_cities();
uasort($cities, fn($a, $b) => $a['order'] <=> $b['order']);

$meta_title = 'Best Visa Consultants in India | Tourist, Student & PR Visa Services (40+ Cities) – ' . ($contact['company_name'] ?? 'Vocation Travels');
$meta_description = 'India\'s top-rated visa consultants providing expert assistance across Delhi, Mumbai, Bangalore, Hyderabad, Pune, Chennai, Kolkata, Ahmedabad and 40+ Indian cities for USA, UK, Canada, Schengen, Australia, Japan, Dubai visas.';
$meta_keywords = ['visa consultants India', 'best visa agency India', 'tourist visa agent', 'student visa consultants', 'Schengen visa Delhi', 'US visa Bangalore', 'Canada visa Hyderabad', 'UK visa Mumbai', 'Australia visa Pune', 'Dubai visa online India'];
$canonical_path = 'visa-services/';

$visa_services_schema = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'CollectionPage',
      '@id' => $site . 'visa-services/#webpage',
      'url' => $site . 'visa-services/',
      'name' => $meta_title,
      'description' => $meta_description,
      'breadcrumb' => [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
          ['@type' => 'ListItem', 'position' => 2, 'name' => 'Visa Services', 'item' => $site . 'visa-services/'],
        ]
      ]
    ],
    [
      '@type' => 'Service',
      'name' => 'Global Visa Consultation & Application Processing',
      'serviceType' => 'Visa Consultancy',
      'provider' => [
        '@type' => 'TravelAgency',
        'name' => $contact['company_name'] ?? 'VOCATION TRAVELS AND TOURS PRIVATE LIMITED',
        'url' => $site,
        'telephone' => '+91-' . ($contact['phone'] ?? '9999447373'),
      ],
      'areaServed' => [
        '@type' => 'Country',
        'name' => 'India'
      ],
      'description' => $meta_description,
    ],
    [
      '@type' => 'FAQPage',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => 'Which countries does Vocation Travels provide visa assistance for?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'We provide expert tourist, business, student, and transit visa processing for the United States (B1/B2), United Kingdom, Canada, Schengen Europe (29 member countries), Australia, United Arab Emirates (Dubai), and Japan.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'Do you provide local visa consultancy across Indian cities?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Yes. We provide complete documentation and appointment booking support for applicants in Delhi NCR, Mumbai, Bangalore, Hyderabad, Chennai, Pune, Kolkata, Ahmedabad, and over 40 Indian cities.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'Can you also book flights and hotel packages after my visa is approved?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Yes, our team specializes in complete luxury travel packages, flight ticketing, and hotel reservations tailored to your approved travel dates.'
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include('seo-meta.php') ?>
  <title><?= htmlspecialchars($meta_title) ?></title>
  <?php include('link.php') ?>
  <script type="application/ld+json"><?= json_encode($visa_services_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

  <style>
    .country-card {
      background: #ffffff;
      border-radius: 1.25rem;
      border-bottom: 4px solid transparent;
      border-image: linear-gradient(to right, #1ec700, #e11d48) 1;
      transition: transform .3s ease, box-shadow .3s ease;
    }
    .country-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
    }
    .city-pill {
      transition: all 0.2s ease;
    }
    .city-pill:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(30, 199, 0, 0.2);
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-gray-50 text-gray-800">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Hero Section -->
    <section class="relative w-full overflow-hidden pt-36 pb-24 bg-neutral-950 text-white">
      <video class="absolute inset-0 w-full h-full object-cover opacity-25" autoplay muted loop playsinline preload="auto">
        <source src="<?= $site ?>assets/videos/about_1.mp4" type="video/mp4">
      </video>
      <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-neutral-950"></div>
      
      <div class="relative z-10 max-w-5xl mx-auto text-center px-4">
        <span class="inline-block py-1 px-4 mb-4 rounded-full bg-white/10 backdrop-blur-md text-emerald-400 text-xs sm:text-sm font-semibold tracking-wider uppercase border border-white/15">
          <i class="fa-solid fa-passport mr-1.5"></i> Pan-India Visa &amp; Immigration Assistance
        </span>
        <h1 class="text-white font-extrabold leading-tight text-3xl sm:text-5xl lg:text-6xl mb-6 drop-shadow-xl">
          Visa Services Across <span class="bg-gradient-to-r from-[#1ec700] via-emerald-400 to-[#e11d48] text-transparent bg-clip-text">40+ Indian Cities</span>
        </h1>
        <p class="text-gray-300 text-base sm:text-xl max-w-3xl mx-auto mb-8 font-light leading-relaxed">
          Trusted consultants assisting travelers and students across Delhi NCR, Mumbai, Bangalore, Hyderabad, Pune, Chennai, Kolkata, and all over India with tourist, business, student and PR visas.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a href="<?= $site ?>contact/#contactform"
            class="px-8 py-3.5 rounded-full text-white font-bold bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition shadow-xl">
            Get Free Visa Consultation
          </a>
          <a href="#cities-section"
            class="px-8 py-3.5 rounded-full text-white font-medium bg-white/10 hover:bg-white/20 border border-white/20 transition">
            Browse by City
          </a>
        </div>
      </div>
    </section>

    <!-- Value Highlights Strip -->
    <section class="py-12 bg-white border-b border-gray-100">
      <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="p-4">
          <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shadow-sm">
            <i class="fa-solid fa-file-shield"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">Checklist &amp; Form Accuracy</h3>
          <p class="text-gray-600 text-sm">Thorough documentation vetting to prevent common embassy refusal and delay factors.</p>
        </div>
        <div class="p-4">
          <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl shadow-sm">
            <i class="fa-solid fa-calendar-check"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">Priority Appointment Booking</h3>
          <p class="text-gray-600 text-sm">Fast-track slot tracking and appointment coordination across all VFS and VAC centers in India.</p>
        </div>
        <div class="p-4">
          <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-sm">
            <i class="fa-solid fa-user-tie"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">Mock Interview Preparation</h3>
          <p class="text-gray-600 text-sm">One-on-one preparation sessions for US F1/B1/B2, Schengen, and Canadian visa interviews.</p>
        </div>
      </div>
    </section>

    <!-- Country Grid -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
          <span class="text-xs uppercase tracking-widest text-[#1ec700] font-bold">Global Destinations</span>
          <h2 class="text-3xl font-extrabold text-gray-900 mt-1">Visa Processing by Country</h2>
          <p class="text-gray-600 text-sm sm:text-base mt-2">Select your travel destination to view eligibility, document checklist and processing steps</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <?php foreach ($countries as $slug => $country): ?>
            <a href="<?= $site ?>visa-services/<?= htmlspecialchars($slug) ?>/" class="country-card p-6 flex flex-col items-center text-center group shadow-sm hover:shadow-md">
              <span class="text-5xl mb-4 group-hover:scale-110 transition duration-300"><?= $country['flag'] ?></span>
              <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-emerald-600 transition"><?= htmlspecialchars($country['name']) ?> Visa</h3>
              <p class="text-gray-500 text-xs sm:text-sm mb-6 flex-grow"><?= htmlspecialchars($country['hero_tagline']) ?></p>
              <span class="inline-block px-5 py-2 rounded-full text-xs font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] group-hover:opacity-90">
                View Requirements
              </span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- City-Specific Visa Consultants Across India -->
    <section id="cities-section" class="py-16 bg-white border-t border-gray-100">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-10">
          <span class="text-xs uppercase tracking-widest text-[#e11d48] font-bold">Local SEO &amp; Support</span>
          <h2 class="text-3xl font-extrabold text-gray-900 mt-1">Visa Consultants Serving 40+ Cities Across India</h2>
          <p class="text-gray-600 text-sm sm:text-base mt-2 max-w-2xl mx-auto">
            Choose your city for localized assistance, appointment guidance for nearby VAC/VFS centers, and expert document support:
          </p>
          
          <!-- Quick Filter Input -->
          <div class="max-w-md mx-auto mt-6">
            <div class="relative">
              <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
              <input type="text" id="citySearch" placeholder="Type city name (e.g. Delhi, Pune, Lucknow, Jaipur...)"
                class="w-full pl-11 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm shadow-sm"
                onkeyup="filterVisaCities()">
            </div>
          </div>
        </div>

        <!-- City Pills Grid -->
        <div id="cityList" class="flex flex-wrap justify-center gap-3">
          <?php foreach ($cities as $cslug => $city): ?>
            <a href="<?= $site ?>visa-consultants-<?= htmlspecialchars($cslug) ?>/"
              data-city="<?= strtolower(htmlspecialchars($city['name'])) ?>"
              class="city-pill px-4 py-2 rounded-full bg-gray-100 hover:bg-emerald-500 hover:text-white text-gray-700 text-xs sm:text-sm font-semibold border border-gray-200">
              <i class="fa-solid fa-location-dot text-emerald-500 group-hover:text-white mr-1.5"></i>
              Visa Consultants in <?= htmlspecialchars($city['name']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- General FAQ -->
    <section class="py-16 bg-gray-50 border-t border-gray-100">
      <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center mb-10 text-gray-900">Frequently Asked Questions</h2>

        <div class="space-y-4">
          <?php
          $general_faqs = [
            ['q' => 'Do you provide visa services for all cities across India?', 'a' => 'Yes! We support applicants from Delhi NCR, Mumbai, Bangalore, Hyderabad, Chennai, Kolkata, Pune, Ahmedabad, Jaipur, Chandigarh, Lucknow, Kochi, and 30+ more cities with remote documentation and local VAC/VFS center appointment coordination.'],
            ['q' => 'Which countries do you provide visa assistance for?', 'a' => 'We handle tourist, business, student, and visitor visas for the USA, United Kingdom, Canada, European Schengen area (29 countries), Australia, Japan, Singapore, UAE/Dubai, and more.'],
            ['q' => 'Can any visa consultant guarantee 100% visa approval?', 'a' => 'No consultant can legally guarantee approval because the final decision always rests with the sovereign embassy or high commission. However, our 98.7% accuracy rate ensures error-free filing, maximizing your chances of approval.'],
            ['q' => 'How can I get started with my visa application?', 'a' => 'Fill out our contact form or contact us via WhatsApp (+91 7982938239). Our visa advisor will review your passport details, travel purpose, and send a personalized document checklist within minutes.'],
          ];
          foreach ($general_faqs as $i => $faq): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
              <h3 class="font-bold text-gray-900 text-base mb-2">
                <i class="fa-solid fa-circle-question text-emerald-500 mr-2"></i><?= htmlspecialchars($faq['q']) ?>
              </h3>
              <p class="text-gray-600 text-sm leading-relaxed pl-6">
                <?= htmlspecialchars($faq['a']) ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Cross-Pillar Internal Linking: Tour Packages for Approved Travelers -->
    <section class="py-14 bg-white border-t border-gray-200">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-10">
          <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-2">
            Complete Vacation Planning
          </span>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            Planning a Holiday Tour After Visa Approval?
          </h3>
          <p class="text-gray-600 text-sm mt-2">
            Vocation Travels pairs seamless visa approval with handpicked luxury holiday itineraries across India and worldwide.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <a href="<?= $site ?>package/kashmir-paradise-tour/" class="group block p-4 rounded-2xl bg-gray-50 border border-gray-200 hover:border-emerald-500 hover:shadow-lg transition">
            <span class="text-xs font-bold text-emerald-600 uppercase">5N / 6D Tour</span>
            <h4 class="font-bold text-gray-900 group-hover:text-emerald-700 transition mt-1 text-sm">Kashmir Paradise Tour</h4>
            <p class="text-xs text-gray-500 mt-1">Srinagar Houseboat, Gulmarg Gondola &amp; Pahalgam</p>
            <span class="inline-block mt-3 text-xs font-semibold text-emerald-600 group-hover:translate-x-1 transition-transform">Explore Itinerary &rarr;</span>
          </a>

          <a href="<?= $site ?>package/himachal-hill-stations/" class="group block p-4 rounded-2xl bg-gray-50 border border-gray-200 hover:border-emerald-500 hover:shadow-lg transition">
            <span class="text-xs font-bold text-blue-600 uppercase">5N / 6D Tour</span>
            <h4 class="font-bold text-gray-900 group-hover:text-blue-700 transition mt-1 text-sm">Himachal Mountain Escapade</h4>
            <p class="text-xs text-gray-500 mt-1">Shimla, Kufri, Manali &amp; Solang Snow Valley</p>
            <span class="inline-block mt-3 text-xs font-semibold text-blue-600 group-hover:translate-x-1 transition-transform">Explore Itinerary &rarr;</span>
          </a>

          <a href="<?= $site ?>package/kerala-luxury-retreat/" class="group block p-4 rounded-2xl bg-gray-50 border border-gray-200 hover:border-emerald-500 hover:shadow-lg transition">
            <span class="text-xs font-bold text-teal-600 uppercase">5N / 6D Tour</span>
            <h4 class="font-bold text-gray-900 group-hover:text-teal-700 transition mt-1 text-sm">Kerala Luxury Backwaters</h4>
            <p class="text-xs text-gray-500 mt-1">Munnar Tea Valleys &amp; Alleppey Private Houseboat</p>
            <span class="inline-block mt-3 text-xs font-semibold text-teal-600 group-hover:translate-x-1 transition-transform">Explore Itinerary &rarr;</span>
          </a>

          <a href="<?= $site ?>travel-package/" class="group block p-4 rounded-2xl bg-emerald-950 text-white hover:bg-emerald-900 transition flex flex-col justify-between">
            <div>
              <span class="text-xs font-bold text-emerald-400 uppercase">All 12+ Packages</span>
              <h4 class="font-bold text-white mt-1 text-sm">Discover Domestic &amp; Global Tours</h4>
              <p class="text-xs text-gray-300 mt-1">Dubai, Bali, Vietnam, Ladakh &amp; more</p>
            </div>
            <span class="inline-block mt-3 text-xs font-semibold text-emerald-300 group-hover:translate-x-1 transition-transform">View All Packages &rarr;</span>
          </a>
        </div>
      </div>
    </section>

    <!-- Bottom CTA Strip -->
    <section class="py-14 bg-gradient-to-r from-emerald-950 via-neutral-900 to-rose-950 text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h3 class="text-2xl sm:text-3xl font-bold mb-4">Ready to Start Your Visa Application?</h3>
        <p class="text-gray-300 text-sm sm:text-base max-w-2xl mx-auto mb-6">
          Connect with India's trusted visa specialists today. Transparent guidance, fast filing, and zero hidden charges.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
          <a href="<?= $site ?>contact/#contactform"
            class="px-8 py-3.5 bg-gradient-to-r from-[#1ec700] to-[#e11d48] font-bold text-white rounded-full shadow-lg hover:scale-105 transition">
            Book Consultation
          </a>
          <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $contact['wp_number'] ?? '7982938239') ?>?text=Hi%20Vocation%20Travels,%20I%20need%20visa%20guidance" target="_blank" rel="noopener"
            class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 font-bold text-white rounded-full shadow-lg flex items-center space-x-2 transition">
            <i class="fa-brands fa-whatsapp text-lg"></i>
            <span>Chat with Visa Expert</span>
          </a>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <script>
    function filterVisaCities() {
      const input = document.getElementById('citySearch').value.toLowerCase();
      const pills = document.querySelectorAll('#cityList .city-pill');
      pills.forEach(pill => {
        const cityName = pill.getAttribute('data-city') || '';
        if (cityName.includes(input)) {
          pill.style.display = 'inline-flex';
        } else {
          pill.style.display = 'none';
        }
      });
    }
  </script>
</body>

</html>
