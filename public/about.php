<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();

$meta_title = 'About Us | ' . $contact['company_name'] . ' – Visa & Travel Experts Since 2011';
$meta_description = 'Vocation Travels And Tours has curated bespoke luxury travel and visa experiences since 2011. Learn about our story, values and the team behind trusted visa and tour services across India (Delhi, Mumbai, Bangalore, Hyderabad & 40+ cities).';
$meta_keywords = ['about Vocation Travels', 'travel agency India', 'visa consultants India', 'luxury travel company India', 'visa and tour consultants Delhi Mumbai Bangalore'];
$canonical_path = 'about/';

$about_schema = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'AboutPage',
      '@id' => $site . 'about/#webpage',
      'url' => $site . 'about/',
      'name' => $meta_title,
      'description' => $meta_description,
      'breadcrumb' => [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
          ['@type' => 'ListItem', 'position' => 2, 'name' => 'About Us', 'item' => $site . 'about/'],
        ]
      ]
    ],
    [
      '@type' => 'TravelAgency',
      '@id' => $site . '#organization',
      'name' => $contact['company_name'] ?? 'VOCATION TRAVELS AND TOURS PRIVATE LIMITED',
      'url' => $site,
      'logo' => $site . 'assets/images/logo.png',
      'foundingDate' => '2011',
      'email' => $contact['email'] ?? 'visa@vocationtravels.com',
      'telephone' => '+91-' . ($contact['phone'] ?? '9999447373'),
      'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $contact['address'] ?? 'Room No. 309, 3rd Floor, Transport Authority Building, District Centre, Near Janakpuri Police Station, Janakpuri',
        'addressLocality' => 'New Delhi',
        'postalCode' => '110058',
        'addressCountry' => 'IN'
      ],
      'sameAs' => [
        'https://share.google/EzOt9py4AbwOfVnO1',
        'https://www.instagram.com/vocationtravels/',
        'https://www.facebook.com/share/1ZXsmimYf7/?mibextid=wwXIfr',
        'https://www.linkedin.com/company/vocationtravels/'
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
  <script type="application/ld+json"><?= json_encode($about_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
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

<body class="relative flex flex-col min-h-screen">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">
    <!-- Luxury Banner Section with Video Background -->
    <section class="relative h-screen w-full overflow-hidden">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline preload="auto">
        <source src="<?=$site?>assets/videos/about_1.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1
          class="text-white font-bold leading-tight text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl mb-6 drop-shadow-lg">
          VOCATION TRAVELS &<br> TOURS Pvt. Ltd
        </h1>
        <p class="text-indigo-100 text-lg sm:text-xl md:text-2xl max-w-2xl mb-4 font-light drop-shadow">
          It’s all about Travel.
        </p>
        <a href="<?=$site?>contact/"
          class="inline-block px-6 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition-colors duration-200 mt-4">
          Since 2011
        </a>
      </div>
    </section>

    <?php
    $about_sections = [];
    if (!empty($conn) && !$conn->connect_error) {
        $ab_res = @$conn->query("SELECT * FROM about_sections ORDER BY section_order ASC, id ASC");
        if ($ab_res) {
            while ($r = $ab_res->fetch_assoc()) {
                $about_sections[] = $r;
            }
        }
    }
    ?>

    <?php if (!empty($about_sections)): ?>
      <!-- Dynamic About Sections from Admin -->
      <section class="py-16 px-4 sm:px-8 md:px-16 lg:px-32 bg-white">
        <div class="max-w-5xl mx-auto space-y-12">
          <?php foreach ($about_sections as $idx => $sec): ?>
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 hover:shadow-2xl transition duration-300"
                 style="border-bottom: 5px solid green;">
              <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-indigo-900 mb-6 text-center tracking-tight">
                <?= htmlspecialchars($sec['title']) ?>
              </h2>
              <div class="text-gray-700 text-base md:text-lg leading-relaxed text-center font-light space-y-4">
                <?= nl2br(htmlspecialchars($sec['content'])) ?>
              </div>
              <?php if (!empty($sec['image_url'])): ?>
                <div class="mt-8 overflow-hidden rounded-xl shadow-md max-w-2xl mx-auto">
                  <img src="<?= (strpos($sec['image_url'], 'http') === 0 || strpos($sec['image_url'], 'admin/') === 0) ? $site . ltrim($sec['image_url'], '/') : $site . ltrim($sec['image_url'], '/') ?>" 
                       alt="<?= htmlspecialchars($sec['title']) ?>" 
                       class="w-full h-64 sm:h-80 object-cover hover:scale-105 transition duration-500">
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php else: ?>
      <!-- Default About Section Fallback -->
      <section class="py-16 px-4 sm:px-8 md:px-16 lg:px-32 bg-white">
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl p-8 border border-gray-100"
          style="border-bottom: 5px solid green;">
          <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-indigo-900 mb-8 text-center tracking-tight">Welcome
            to a Journey Beyond Travel</h2>
          <p class="text-gray-700 text-lg md:text-xl mb-8 text-center font-light">
            If you’re here, you seek more than just a trip — you desire a partner who understands the true essence of
            every journey.
          </p>
          <p class="text-gray-700 text-lg md:text-xl mb-8 text-center font-light">
            Since 2011, we’ve grown from humble beginnings into a prestigious agency, renowned for curating bespoke luxury
            experiences. What began as a dream has evolved into an agency trusted by discerning travelers who expect
            nothing less than perfection.
          </p>
          <h3 class="text-3xl sm:text-3xl md:text-3xl font-bold text-indigo-900 mb-8 text-center tracking-tight">Why
            Choose Us</h3>
          <p class="text-gray-700 text-lg md:text-xl mb-8 text-center font-light">
            Tailored Luxury: Personalized experiences crafted to reflect your unique tastes.<br>
            Seamless Service: From private transfers to exclusive accommodations, we ensure every detail is flawless.<br>
            Unforgettable Moments: Curating extraordinary experiences for once-in-a-lifetime memories.
          </p>
        </div>
      </section>
    <?php endif; ?>
    <!-- Partner Logos Marquee Section -->
    <section class="relative h-[60vh] sm:h-[70vh] md:h-[80vh] w-full overflow-hidden">
      <!-- Video Background -->
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="<?=$site?>assets/videos/testimonial.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>

      <!-- Dark Overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>

      <!-- Marquee + Text Container -->
      <div class="relative z-10 flex flex-col items-center justify-center h-full px-4">
        <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-10 drop-shadow-lg text-center">Glimpse of
          Our Client’s</h2>
        <!-- Logos Marquee Wrapper -->
        <div class="w-full overflow-hidden">
          <div class="flex items-center space-x-8 animate-marquee">
            <!-- First set of logos -->
            <img src="<?=$site?>assets/images/fastkeys.png" alt="Award 1" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/il-fs.jpg" alt="Award 2" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/c1-india.png" alt="Award 3" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/elisra.jpg" alt="Award 4" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/cinevesture.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/koreanembassy.png" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/pathways.jpeg.jpg" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/slashproduction.png" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/nfdc.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/sa-infrastructure.jpg" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/tulsiani.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/sm-air.jpeg.jpg" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/polyplastic.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <!-- Repeat the same logos for seamless loop -->
            <img src="<?=$site?>assets/images/fastkeys.png" alt="Award 1" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/il-fs.jpg" alt="Award 2" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/c1-india.png" alt="Award 3" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/elisra.jpg" alt="Award 4" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/cinevesture.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/koreanembassy.png" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/pathways.jpeg.jpg" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/slashproduction.png" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/nfdc.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/sa-infrastructure.jpg" alt="Award 5"
              class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/tulsiani.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/sm-air.jpeg.jpg" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
            <img src="<?=$site?>assets/images/polyplastic.png" alt="Award 5" class="h-12 sm:h-16 md:h-20 object-contain bg-white">
          </div>
        </div>

        <!-- Descriptive Text -->
        <p class="mt-8 max-w-3xl text-center text-white text-base sm:text-lg md:text-xl">
          We are a multi-award-winning agency specializing in luxury travel experiences for families and groups. With
          one of the world’s largest and most influential travel communities, we offer bespoke trips to both domestic
          destinations like Rajasthan, Goa, Leh, and the Andamans, as well as international escapes to Bali, Vietnam,
          Europe, Canada, and beyond. Our community of passionate travelers shares a love for unique, unforgettable
          journeys, and we invite you to be part of it. Let us craft your perfect getaway, tailored to your dreams and
          desires.
        </p>
      </div>
    </section>


    <!-- Mission Section -->
    <section class="py-16 px-4 sm:px-8 md:px-16 lg:px-32 bg-white">
      <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl p-8 border border-gray-100"
        style="border-bottom: 5px solid green;">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-indigo-900 mb-6 text-center tracking-tight">Our
          Mission</h2>
        <p class="text-gray-700 text-lg md:text-xl mb-6 text-center font-light">
          At Vocation, we believe travel is more than just a destination; it’s an experience. We are dedicated to making
          every journey seamless, unforgettable, and tailored to your unique desires. We are passionate about empowering
          you to explore the world with confidence and comfort. <strong>Let Vocation be your partner in crafting your
            next adventure.</strong>
        </p>
        <p class="text-gray-700 text-lg md:text-xl mb-6 text-center font-light">
          <span class="font-semibold text-indigo-700">Located in Canada, Dubai, New Delhi.</span>
        </p>
      </div>
    </section>

    <section
      class="relative h-[100vh] w-full overflow-hidden flex items-center justify-center py-16 px-4 sm:px-8 md:px-16 lg:px-32 bg-white">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="<?=$site?>assets/videos/about_3.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="relative max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl p-8 border border-gray-100"
        style="border-bottom: 5px solid green;">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-indigo-900 mb-6 text-center tracking-tight">Your
          Journey, Our Commitment</h2>
        <p class="text-gray-700 text-lg md:text-xl mb-6 text-center font-light">
          At Vocation Travels, we make a solemn promise — every journey you entrust to us will be meticulously crafted
          with unparalleled dedication and precision.
        </p>
        <p class="text-gray-700 text-lg md:text-xl mb-6 text-center font-light">
          We take the time to understand your unique needs, tailoring each experience to your personal desires. Whether
          it’s a tranquil retreat in the Himalayas, a high-powered business trip, or an unforgettable family vacation,
          we ensure every detail is executed flawlessly.
        </p>
        <p class="text-gray-700 text-lg md:text-xl mb-6 text-center font-light">
          Our commitment goes beyond expectations. We anticipate your needs before you even voice them, ensuring a
          seamless experience from planning to your safe return. This is not just a pledge — it’s a vow we’ve honored
          with distinction for over a decade.
        </p>


      </div>
    </section>


    <!-- Commitment Section -->
    <!-- <section class="py-16 px-4 sm:px-8 md:px-16 lg:px-32 bg-gradient-to-br from-indigo-50 via-white to-indigo-100">
      <div class="max-w-5xl mx-auto rounded-2xl shadow-xl p-8 border border-indigo-100">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-indigo-800 mb-6 text-center tracking-tight">Our Commitment</h2>
        <p class="text-gray-800 text-lg md:text-xl mb-6 font-light">
          At Vocation Travels, our commitment to excellence is unwavering. We pride ourselves on delivering exceptional service, attention to detail, and personalized care to each and every client. Whether you’re a seasoned globetrotter or embarking on your very first journey, you can trust us to go above and beyond to ensure your travel experience is nothing short of extraordinary.
        </p>
        <p class="text-indigo-700 text-lg md:text-xl mb-6 text-center font-semibold">
          Join us on a journey of discovery, adventure, and wonder. Experience the world with Vocation Travels – where every journey is an opportunity for transformation.
        </p>
      </div>
    </section> -->
    <!-- SEO Internal Linking Section: Explore Our Core Services & Packages -->
    <section class="py-16 px-4 sm:px-8 md:px-16 lg:px-24 bg-gradient-to-b from-gray-50 to-white border-t border-gray-200">
      <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-12">
          <span class="inline-block px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest text-emerald-700 bg-emerald-100 border border-emerald-200 mb-3">
            What We Do
          </span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
            Discover Our Comprehensive Travel &amp; Visa Offerings
          </h2>
          <p class="text-gray-600 mt-3 text-base sm:text-lg">
            Whether you are booking a breathtaking luxury holiday, applying for a fast-track global visa, or demanding VIP concierge transfers — Vocation Travels delivers excellence.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Card 1: Tour Packages -->
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-2xl transition duration-300 flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-plane-departure"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">Curated Tour Packages</h3>
              <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                Handcrafted domestic circuits and international holiday itineraries with 4/5-star accommodation, chauffeur transfers, and 24/7 on-ground assistance.
              </p>
              <ul class="text-xs text-gray-700 space-y-2 mb-6">
                <li><a href="<?=$site?>package/kashmir-paradise-tour/" class="hover:text-emerald-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-emerald-500 mr-2"></i>Kashmir Paradise (5N/6D)</a></li>
                <li><a href="<?=$site?>package/himachal-hill-stations/" class="hover:text-emerald-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-emerald-500 mr-2"></i>Himachal Mountain Escapade (5N/6D)</a></li>
                <li><a href="<?=$site?>package/kerala-luxury-retreat/" class="hover:text-emerald-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-emerald-500 mr-2"></i>Kerala Luxury Backwaters (5N/6D)</a></li>
              </ul>
            </div>
            <a href="<?=$site?>travel-package/" class="inline-flex items-center text-emerald-700 font-bold text-sm hover:text-emerald-800">
              Explore All 12+ Packages <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
          </div>

          <!-- Card 2: Visa Services -->
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-2xl transition duration-300 flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-passport"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">Global Visa Consultancy</h3>
              <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                End-to-end documentation, visa appointment scheduling, and mock interview coaching for top destinations across 40+ Indian cities.
              </p>
              <ul class="text-xs text-gray-700 space-y-2 mb-6">
                <li><a href="<?=$site?>visa-services/usa/" class="hover:text-blue-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-blue-500 mr-2"></i>USA B1/B2 Tourist &amp; Business Visa</a></li>
                <li><a href="<?=$site?>visa-services/uk/" class="hover:text-blue-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-blue-500 mr-2"></i>UK Standard Visitor Visa</a></li>
                <li><a href="<?=$site?>visa-services/europe/" class="hover:text-blue-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-blue-500 mr-2"></i>Schengen Europe Tourist Visa</a></li>
              </ul>
            </div>
            <a href="<?=$site?>visa-services/" class="inline-flex items-center text-blue-700 font-bold text-sm hover:text-blue-800">
              View Visa Services (40+ Cities) <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
          </div>

          <!-- Card 3: VIP Concierge -->
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-2xl transition duration-300 flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-crown"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">VIP Concierge &amp; Transfers</h3>
              <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                Private aircraft charters, ultra-luxury chauffeur transfers, 5-star suite reservations, and destination wedding management.
              </p>
              <ul class="text-xs text-gray-700 space-y-2 mb-6">
                <li><a href="<?=$site?>services/private-jet-charter/" class="hover:text-amber-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-amber-500 mr-2"></i>Private Jet Charter</a></li>
                <li><a href="<?=$site?>services/luxury-chauffeur-transfers/" class="hover:text-amber-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-amber-500 mr-2"></i>Luxury Chauffeur Fleet</a></li>
                <li><a href="<?=$site?>services/luxury-hotels-resorts/" class="hover:text-amber-600 font-medium flex items-center"><i class="fa-solid fa-angle-right text-amber-500 mr-2"></i>Bespoke 5-Star Hotel Suites</a></li>
              </ul>
            </div>
            <a href="<?=$site?>vip-concierge/" class="inline-flex items-center text-amber-700 font-bold text-sm hover:text-amber-800">
              Experience VIP Concierge <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <script src="<?=$site?>assets/js/main.js"></script>
</body>
</html>
