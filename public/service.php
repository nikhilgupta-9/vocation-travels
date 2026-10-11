<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/services_data.php";

$contact = contact_us();

$alias = isset($_GET['alias']) ? preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['alias'])) : '';
$service = $alias !== '' ? get_service($alias) : null;

if ($alias !== '' && !$service) {
  header("Location: " . $site . "services/");
  exit;
}

if ($service) {
  // ---- Single service detail page ----
  $meta_title = $service['meta_title'] ?? ($service['name'] . ' | ' . ($contact['company_name'] ?? 'Vocation Travels'));
  $meta_description = $service['meta_description'] ?? $service['description'];
  $meta_keywords = $service['keywords'] ?? ['travel services India', 'Vocation Travels'];
  $canonical_path = 'services/' . $alias . '/';

  $related = get_services_by_category($service['category']);
  unset($related[$alias]);
  $related = array_slice($related, 0, 4, true);

  $breadcrumb_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => $site . 'services/'],
      ['@type' => 'ListItem', 'position' => 3, 'name' => $service['name'], 'item' => $site . $canonical_path],
    ],
  ];

  $service_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => $service['name'],
    'description' => $service['description'],
    'image' => $site . $service['image'],
    'provider' => [
      '@type' => 'TravelAgency',
      'name' => $contact['company_name'] ?? 'VOCATION TRAVELS AND TOURS PRIVATE LIMITED',
      'url' => $site,
      'telephone' => '+91-' . ($contact['phone'] ?? '9999447373'),
      'email' => $contact['email'] ?? 'visa@vocationtravels.com',
    ],
    'areaServed' => [
      ['@type' => 'Country', 'name' => 'India'],
      ['@type' => 'City', 'name' => 'Delhi'],
      ['@type' => 'City', 'name' => 'Mumbai'],
      ['@type' => 'City', 'name' => 'Bangalore'],
      ['@type' => 'City', 'name' => 'Hyderabad'],
      ['@type' => 'City', 'name' => 'Pune'],
      ['@type' => 'City', 'name' => 'Chennai'],
      ['@type' => 'City', 'name' => 'Kolkata'],
      ['@type' => 'City', 'name' => 'Ahmedabad'],
    ],
    'serviceType' => $service['category'] === 'specialized' ? 'Specialized Corporate & Luxury Service' : 'Travel & Tour Service',
  ];

  $faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(function($f) {
      return [
        '@type' => 'Question',
        'name' => $f['q'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $f['a']
        ]
      ];
    }, $service['faqs'] ?? [])
  ];

  $schemas = [$breadcrumb_schema, $service_schema, $faq_schema];

} else {
  // ---- Services hub page ----
  $meta_title = 'Our Services | Tour Packages, Flights, Hotels & Corporate Travel – ' . ($contact['company_name'] ?? 'Vocation Travels');
  $meta_description = 'Explore our full range of travel services — holiday packages, flights, hotels, visa assistance, MICE, corporate travel management and specialized luxury services, all planned end to end.';
  $meta_keywords = ['travel services India', 'corporate travel management company', 'holiday package planner', 'MICE services India', 'travel agency services'];
  $canonical_path = 'services/';

  $core_services = get_services_by_category('core');
  $specialized_services = get_services_by_category('specialized');

  $breadcrumb_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => $site . 'services/'],
    ],
  ];

  $schemas = [$breadcrumb_schema];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($meta_title) ?></title>
  <?php include('link.php') ?>
  <?php include('seo-meta.php') ?>
  <?php foreach ($schemas as $s_item): ?>
    <script type="application/ld+json"><?= json_encode($s_item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <?php endforeach; ?>

  <style>
    .service-card {
      background: #fff;
      border-radius: 1.25rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
      transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    .service-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    .feature-card {
      transition: transform .3s ease, box-shadow .3s ease;
    }
    .feature-card:hover {
      transform: translateY(-4px);
    }
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen bg-neutral-950 text-gray-100 font-sans">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <?php if ($service): ?>

      <!-- Single Service Hero Banner -->
      <section class="relative min-h-[550px] sm:min-h-[620px] w-full overflow-hidden flex items-center justify-center pt-32 pb-20">
        <!-- Background Image with Gradient Overlay -->
        <img src="<?= $site . $service['image'] ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/80 to-black/60"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
          <!-- Trust Badge -->
          <div class="inline-flex items-center space-x-2 py-1.5 px-4 mb-6 rounded-full bg-white/10 backdrop-blur-md text-white text-xs sm:text-sm font-medium border border-white/20 shadow-lg">
            <span class="w-2 h-2 rounded-full bg-[#1ec700] animate-pulse"></span>
            <span>★ 4.9/5 Rated &bull; Trusted by 2,500+ Travelers &amp; Corporate Clients</span>
          </div>

          <h1 class="text-white font-extrabold leading-tight text-3xl sm:text-5xl md:text-6xl mb-6 drop-shadow-2xl">
            <?= htmlspecialchars($service['name']) ?>
          </h1>

          <p class="text-gray-200 text-base sm:text-xl max-w-3xl mx-auto mb-8 font-light leading-relaxed drop-shadow">
            <?= htmlspecialchars($service['tagline']) ?>
          </p>

          <div class="flex flex-wrap gap-4 justify-center items-center">
            <a href="#service-enquiry"
              class="px-8 py-3.5 rounded-full font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition shadow-2xl text-sm sm:text-base">
              Get Custom Proposal
            </a>
            <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $contact['wp_number'] ?? '7982938239') ?>?text=Hi%20Vocation%20Travels,%20I%20am%20inquiring%20about%20<?= urlencode($service['name']) ?>"
              target="_blank" rel="noopener"
              class="px-8 py-3.5 rounded-full font-bold text-white bg-emerald-600 hover:bg-emerald-500 transition shadow-2xl text-sm sm:text-base flex items-center space-x-2">
              <i class="fa-brands fa-whatsapp text-lg"></i>
              <span>WhatsApp Specialist</span>
            </a>
          </div>
        </div>
      </section>

      <!-- Breadcrumbs -->
      <nav class="bg-neutral-900 border-b border-white/10 py-3">
        <div class="max-w-6xl mx-auto px-6 text-xs sm:text-sm text-gray-400 flex items-center space-x-2">
          <a href="<?= $site ?>" class="hover:text-white transition">Home</a>
          <span>/</span>
          <a href="<?= $site ?>services/" class="hover:text-white transition">Services</a>
          <span>/</span>
          <span class="text-[#1ec700] font-semibold"><?= htmlspecialchars($service['name']) ?></span>
        </div>
      </nav>

      <!-- Trust Metrics Bar -->
      <section class="bg-neutral-950 border-b border-white/10 py-6">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          <div class="border-r border-white/10 last:border-none px-2">
            <div class="text-xl sm:text-2xl font-extrabold text-[#1ec700]">100% Custom</div>
            <div class="text-xs text-gray-400 mt-1">Tailor-Made Solutions</div>
          </div>
          <div class="border-r border-white/10 last:border-none px-2">
            <div class="text-xl sm:text-2xl font-extrabold text-[#e11d48]">&lt; 60 Mins</div>
            <div class="text-xs text-gray-400 mt-1">Proposal Turnaround</div>
          </div>
          <div class="border-r border-white/10 last:border-none px-2">
            <div class="text-xl sm:text-2xl font-extrabold text-[#1ec700]">40+ Cities</div>
            <div class="text-xs text-gray-400 mt-1">Pan-India &amp; Global Support</div>
          </div>
          <div class="px-2">
            <div class="text-xl sm:text-2xl font-extrabold text-amber-400">24/7 Desk</div>
            <div class="text-xs text-gray-400 mt-1">Dedicated Trip Concierge</div>
          </div>
        </div>
      </section>

      <!-- Detailed Overview Section (Two Columns with Visual Image) -->
      <section class="py-16 sm:py-20 bg-neutral-900 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          <!-- Left Column: Rich Content -->
          <div class="lg:col-span-7 space-y-6">
            <div class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-widest text-[#1ec700]">
              <i class="<?= htmlspecialchars($service['icon']) ?>"></i>
              <span>Comprehensive Service Overview</span>
            </div>

            <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">
              Bespoke Planning &amp; Flawless Execution for <?= htmlspecialchars($service['name']) ?>
            </h2>

            <?php if (!empty($service['overview'])): ?>
              <div class="service-overview-content text-gray-300 text-sm sm:text-base leading-relaxed space-y-4">
                <?php if (is_array($service['overview'])): ?>
                  <?php foreach ($service['overview'] as $p_item): ?>
                    <?php if (!empty(trim($p_item))): ?>
                      <?php if (strip_tags($p_item) !== $p_item): ?>
                        <div class="rich-text-block space-y-3"><?= $p_item ?></div>
                      <?php else: ?>
                        <p><?= htmlspecialchars($p_item) ?></p>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="rich-text-block space-y-3"><?= $service['overview'] ?></div>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <!-- Highlights Checklist -->
            <div class="pt-4 border-t border-white/10 space-y-3">
              <h3 class="text-xs font-bold uppercase tracking-wider text-gray-300">Core Service Deliverables</h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <?php foreach ($service['highlights'] as $hl): ?>
                  <div class="flex items-start space-x-2 text-xs sm:text-sm text-gray-300">
                    <i class="fa-solid fa-circle-check text-[#1ec700] mt-1 shrink-0"></i>
                    <span><?= htmlspecialchars($hl) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <!-- Right Column: Visual Image Card -->
          <div class="lg:col-span-5">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-white/15 group">
              <img src="<?= $site . $service['image'] ?>" alt="<?= htmlspecialchars($service['name']) ?>"
                class="w-full h-80 sm:h-96 object-cover group-hover:scale-105 transition duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>

              <!-- Floating Badges -->
              <div class="absolute top-4 left-4 bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/20 text-xs font-bold text-white flex items-center space-x-1.5">
                <i class="fa-solid fa-shield-check text-[#1ec700]"></i>
                <span>Verified Quality Standards</span>
              </div>

              <div class="absolute bottom-4 inset-x-4 p-4 rounded-xl bg-neutral-900/90 backdrop-blur-md border border-white/10">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-xs text-gray-400">Need Immediate Help?</p>
                    <p class="text-sm font-bold text-white">+91 <?= htmlspecialchars($contact['phone'] ?? '9999447373') ?></p>
                  </div>
                  <a href="#service-enquiry" class="px-4 py-2 rounded-full text-xs font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48]">
                    Inquire Now
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Key Capabilities & Features Grid (6 Cards) -->
      <section class="py-16 sm:py-20 bg-neutral-950 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-6">
          <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-widest text-[#1ec700] font-bold">Unmatched Capabilities</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white mt-2 mb-4">
              What Is Included In Our <?= htmlspecialchars($service['name']) ?>
            </h2>
            <p class="text-gray-400 text-sm sm:text-base">
              Every detail is meticulously planned and managed by our experienced travel specialists so you enjoy complete peace of mind.
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($service['features'] as $feat): ?>
              <div class="feature-card bg-neutral-900/90 rounded-2xl p-6 border border-white/10 hover:border-[#1ec700] flex flex-col shadow-xl">
                <div class="w-12 h-12 rounded-xl bg-[#1ec700]/15 flex items-center justify-center text-[#1ec700] text-xl mb-4">
                  <i class="<?= htmlspecialchars($feat['icon']) ?>"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2"><?= htmlspecialchars($feat['title']) ?></h3>
                <p class="text-gray-400 text-xs sm:text-sm leading-relaxed"><?= htmlspecialchars($feat['desc']) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- 4-Step Execution Process -->
      <section class="py-16 sm:py-20 bg-neutral-900 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-6">
          <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-widest text-[#e11d48] font-bold">Simple, Reliable Workflow</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white mt-2 mb-4">
              How We Deliver Your <?= htmlspecialchars($service['name']) ?>
            </h2>
            <p class="text-gray-400 text-sm sm:text-base">
              From the initial briefing to your safe return, our 4-step framework guarantees precision and zero surprises.
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($service['process'] as $pr): ?>
              <div class="bg-neutral-950 rounded-2xl p-6 border border-white/10 relative shadow-xl flex flex-col">
                <span class="text-3xl font-extrabold text-white/20 mb-3"><?= htmlspecialchars($pr['step']) ?></span>
                <h3 class="text-base font-bold text-white mb-2"><?= htmlspecialchars($pr['title']) ?></h3>
                <p class="text-gray-400 text-xs leading-relaxed"><?= htmlspecialchars($pr['desc']) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Why Choose Vocation Travels -->
      <section class="py-16 sm:py-20 bg-neutral-950 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-6">
          <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-widest text-[#1ec700] font-bold">The Vocation Travels Advantage</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white mt-2 mb-4">
              Why Discerning Clients Choose Vocation Travels
            </h2>
            <p class="text-gray-400 text-sm sm:text-base">
              Trusted by high-profile travelers, corporate leaders, and families across 40+ Indian cities and globally since 2011.
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($service['why_choose'] as $wc): ?>
              <div class="bg-neutral-900 rounded-2xl p-6 border border-white/10 text-center flex flex-col items-center shadow-xl">
                <div class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-[#1ec700] text-xl mb-4">
                  <i class="<?= htmlspecialchars($wc['icon']) ?>"></i>
                </div>
                <h3 class="text-base font-bold text-white mb-2"><?= htmlspecialchars($wc['title']) ?></h3>
                <p class="text-gray-400 text-xs leading-relaxed"><?= htmlspecialchars($wc['desc']) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- FAQs Section -->
      <section class="py-16 sm:py-20 bg-neutral-900 border-b border-white/10">
        <div class="max-w-4xl mx-auto px-6">
          <div class="text-center mb-12">
            <span class="text-xs uppercase tracking-widest text-amber-400 font-bold">Clarifications &amp; Details</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white mt-2 mb-4">
              Frequently Asked Questions About <?= htmlspecialchars($service['name']) ?>
            </h2>
          </div>

          <div class="space-y-4">
            <?php foreach ($service['faqs'] as $faq): ?>
              <div class="bg-neutral-950 rounded-2xl p-6 border border-white/10 shadow-lg">
                <h3 class="text-base font-bold text-white mb-2 flex items-start space-x-3">
                  <i class="fa-solid fa-circle-question text-[#1ec700] mt-1 shrink-0"></i>
                  <span><?= htmlspecialchars($faq['q']) ?></span>
                </h3>
                <p class="text-gray-400 text-xs sm:text-sm leading-relaxed pl-7">
                  <?= htmlspecialchars($faq['a']) ?>
                </p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Direct Instant Inquiry Form Section -->
      <section id="service-enquiry" class="py-16 sm:py-20 bg-neutral-950 border-b border-white/10">
        <div class="max-w-3xl mx-auto px-6">
          <div class="bg-neutral-900 border border-white/15 rounded-3xl p-8 sm:p-12 shadow-2xl">
            <div class="text-center mb-8">
              <span class="text-xs font-bold uppercase tracking-wider text-[#1ec700]">Direct Booking &amp; Inquiry Desk</span>
              <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2 mb-2">
                Get a Custom Quote for <?= htmlspecialchars($service['name']) ?>
              </h2>
              <p class="text-gray-400 text-xs sm:text-sm">
                Share your requirements below and our senior travel specialist will contact you with a bespoke proposal within 60 minutes.
              </p>
            </div>

            <form action="<?= $site ?>util/process_contact.php" method="POST" class="space-y-5" autocomplete="off">
              <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
              <input type="hidden" name="service_slug" value="<?= htmlspecialchars($alias) ?>">
              <input type="hidden" name="destination" value="<?= htmlspecialchars($service['name']) ?>">
              <input type="hidden" name="timeline" value="Standard / Flexible">

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-semibold text-gray-300 mb-1">Your Full Name *</label>
                  <input type="text" name="name" required placeholder="e.g. Rahul Sharma"
                    class="w-full px-4 py-2.5 rounded-xl bg-neutral-950 border border-white/20 text-white placeholder-gray-500 text-sm focus:outline-none focus:border-[#1ec700]">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-gray-300 mb-1">Phone / WhatsApp Number *</label>
                  <input type="tel" name="phone" required placeholder="e.g. +91 9876543210"
                    class="w-full px-4 py-2.5 rounded-xl bg-neutral-950 border border-white/20 text-white placeholder-gray-500 text-sm focus:outline-none focus:border-[#1ec700]">
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-semibold text-gray-300 mb-1">Email Address *</label>
                  <input type="email" name="email" required placeholder="e.g. rahul@example.com"
                    class="w-full px-4 py-2.5 rounded-xl bg-neutral-950 border border-white/20 text-white placeholder-gray-500 text-sm focus:outline-none focus:border-[#1ec700]">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-gray-300 mb-1">Target Travel / Service Date *</label>
                  <input type="date" name="date" required
                    class="w-full px-4 py-2.5 rounded-xl bg-neutral-950 border border-white/20 text-white text-sm focus:outline-none focus:border-[#1ec700]">
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-semibold text-gray-300 mb-1">Number of Adults</label>
                  <input type="number" name="adults" min="1" value="2" required
                    class="w-full px-4 py-2.5 rounded-xl bg-neutral-950 border border-white/20 text-white text-sm focus:outline-none focus:border-[#1ec700]">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-gray-300 mb-1">Number of Children</label>
                  <input type="number" name="children" min="0" value="0"
                    class="w-full px-4 py-2.5 rounded-xl bg-neutral-950 border border-white/20 text-white text-sm focus:outline-none focus:border-[#1ec700]">
                </div>
              </div>

              <div>
                <label class="block text-xs font-semibold text-gray-300 mb-1">Specific Requirements / Preferences</label>
                <textarea name="comments" rows="3" placeholder="Tell us your preferred cities, hotel category, budget range, or special requests..."
                  class="w-full px-4 py-2.5 rounded-xl bg-neutral-950 border border-white/20 text-white placeholder-gray-500 text-sm focus:outline-none focus:border-[#1ec700]"></textarea>
              </div>

              <div class="text-center pt-2">
                <button type="submit"
                  class="w-full sm:w-auto px-10 py-3.5 rounded-full font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition shadow-2xl text-sm sm:text-base">
                  Submit Service Request
                </button>
              </div>
            </form>
          </div>
        </div>
      </section>

      <!-- Related Services Grid -->
      <?php if (!empty($related)): ?>
        <section class="py-16 bg-neutral-900 border-b border-white/10">
          <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-xl sm:text-2xl font-bold text-white mb-8 text-center">Explore Complementary Services</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              <?php foreach ($related as $rslug => $rservice): ?>
                <a href="<?= $site ?>services/<?= htmlspecialchars($rslug) ?>/"
                  class="service-card bg-neutral-950/90 rounded-2xl p-5 border border-white/10 hover:border-[#1ec700] flex flex-col group">
                  <div class="h-32 rounded-xl overflow-hidden mb-3 relative">
                    <img src="<?= $site . get_service_image($rslug) ?>" alt="<?= htmlspecialchars($rservice['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-black/40"></div>
                  </div>
                  <h3 class="text-sm font-bold text-white group-hover:text-[#1ec700] transition mb-1"><?= htmlspecialchars($rservice['name']) ?></h3>
                  <p class="text-gray-400 text-xs line-clamp-2 mb-3"><?= htmlspecialchars($rservice['highlights'][0]) ?></p>
                  <span class="mt-auto text-[11px] font-bold text-[#1ec700] flex items-center space-x-1">
                    <span>Learn More</span>
                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </span>
                </a>
              <?php endforeach; ?>
            </div>
            <div class="text-center mt-8">
              <a href="<?= $site ?>services/" class="inline-block px-6 py-2.5 rounded-full border border-white/20 text-xs font-bold text-white hover:bg-white hover:text-black transition">
                View All 65 Services
              </a>
            </div>
          </div>
        </section>
      <?php endif; ?>

    <?php else: ?>

      <!-- Services Hub Listing Page (/services/) -->
      <section class="relative min-h-[550px] sm:min-h-[620px] w-full overflow-hidden flex items-center justify-center pt-28 pb-16">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline preload="auto">
          <source src="<?=$site?>assets/videos/blogvideo.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-neutral-950/75"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-5xl mx-auto">
          <div class="inline-flex items-center space-x-2 py-1.5 px-4 mb-6 rounded-full bg-white/10 backdrop-blur-md text-white text-xs sm:text-sm font-medium border border-white/20 shadow-lg">
            <span class="w-2 h-2 rounded-full bg-[#1ec700] animate-pulse"></span>
            <span>Comprehensive Travel &amp; Corporate Mobility Portfolio</span>
          </div>

          <h1 class="text-white font-extrabold leading-tight text-3xl sm:text-5xl md:text-6xl mb-6 drop-shadow-2xl">
            Exclusive Solutions <span class="bg-gradient-to-r from-[#1ec700] via-emerald-400 to-[#e11d48] text-transparent bg-clip-text">Crafted for You</span>
          </h1>

          <p class="text-gray-200 text-base sm:text-xl max-w-2xl mb-8 font-light leading-relaxed">
            From bespoke domestic and world holiday packages to executive aviation, 5-star hotel contracts, MICE events, and 24/7 VIP concierge care.
          </p>

          <div class="flex flex-wrap gap-4 justify-center">
            <a href="#core-services"
              class="px-8 py-3.5 rounded-full font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition shadow-2xl text-sm sm:text-base">
              Explore All Services
            </a>
            <a href="<?= $site ?>contact/#contactform"
              class="px-8 py-3.5 rounded-full font-bold text-white bg-white/15 backdrop-blur-md border border-white/30 hover:bg-white hover:text-black transition text-sm sm:text-base">
              Schedule Consultation
            </a>
          </div>
        </div>
      </section>

      <!-- Trust Metrics Strip -->
      <section class="bg-neutral-900 border-y border-white/10 py-6">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          <div class="border-r border-white/10 last:border-none px-2">
            <div class="text-2xl font-extrabold text-[#1ec700]">65+ Services</div>
            <div class="text-xs text-gray-400 mt-1">End-to-End Travel Portfolio</div>
          </div>
          <div class="border-r border-white/10 last:border-none px-2">
            <div class="text-2xl font-extrabold text-[#e11d48]">Since 2011</div>
            <div class="text-xs text-gray-400 mt-1">15+ Years Travel Heritage</div>
          </div>
          <div class="border-r border-white/10 last:border-none px-2">
            <div class="text-2xl font-extrabold text-[#1ec700]">40+ Cities</div>
            <div class="text-xs text-gray-400 mt-1">Pan-India Support Reach</div>
          </div>
          <div class="px-2">
            <div class="text-2xl font-extrabold text-amber-400">24/7 Desk</div>
            <div class="text-xs text-gray-400 mt-1">One-Message Priority Care</div>
          </div>
        </div>
      </section>

      <!-- Core Services Grid (47 Services with Visual Banners) -->
      <section id="core-services" class="py-16 sm:py-20 bg-neutral-950 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6">
          <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-widest text-[#1ec700] font-bold">Holiday &amp; Leisure Excellence</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-2 mb-4">
              Tour Packages, Flights, Stays &amp; Concierge
            </h2>
            <p class="text-gray-400 text-sm sm:text-base">
              Every service is custom engineered around your schedule, luxury tier, and personal travel pace.
            </p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($core_services as $slug => $svc): ?>
              <a href="<?= $site ?>services/<?= htmlspecialchars($slug) ?>/"
                class="service-card bg-neutral-900 rounded-2xl overflow-hidden border border-white/10 hover:border-[#1ec700] flex flex-col group shadow-xl">
                <!-- Image Header -->
                <div class="h-40 overflow-hidden relative">
                  <img src="<?= $site . get_service_image($slug) ?>" alt="<?= htmlspecialchars($svc['name']) ?>"
                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                  <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-transparent to-transparent"></div>
                  <span class="absolute top-3 right-3 w-8 h-8 rounded-full bg-neutral-950/80 backdrop-blur-md flex items-center justify-center text-[#1ec700] text-sm">
                    <i class="<?= htmlspecialchars($svc['icon']) ?>"></i>
                  </span>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                  <h3 class="text-base font-bold text-white group-hover:text-[#1ec700] transition mb-2">
                    <?= htmlspecialchars($svc['name']) ?>
                  </h3>
                  <p class="text-gray-400 text-xs leading-relaxed line-clamp-3 mb-4 flex-grow">
                    <?= htmlspecialchars($svc['description']) ?>
                  </p>
                  <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="font-bold text-[#1ec700]">View In-Depth Details</span>
                    <i class="fa-solid fa-arrow-right text-[10px] text-gray-400 group-hover:text-[#1ec700] group-hover:translate-x-1 transition"></i>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Specialized Corporate & Luxury Services Grid (18 Services) -->
      <section class="py-16 sm:py-20 bg-neutral-900 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6">
          <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-widest text-[#e11d48] font-bold">Enterprise &amp; Ultra-Luxury</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-2 mb-4">
              Specialized Corporate &amp; Elite Services
            </h2>
            <p class="text-gray-400 text-sm sm:text-base">
              Dedicated corporate desks, protocol security, large-group logistics, and white-glove lifestyle management.
            </p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($specialized_services as $slug => $svc): ?>
              <a href="<?= $site ?>services/<?= htmlspecialchars($slug) ?>/"
                class="service-card bg-neutral-950 rounded-2xl overflow-hidden border border-white/10 hover:border-[#e11d48] flex flex-col group shadow-xl">
                <!-- Image Header -->
                <div class="h-40 overflow-hidden relative">
                  <img src="<?= $site . get_service_image($slug) ?>" alt="<?= htmlspecialchars($svc['name']) ?>"
                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                  <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>
                  <span class="absolute top-3 right-3 w-8 h-8 rounded-full bg-neutral-900/80 backdrop-blur-md flex items-center justify-center text-[#e11d48] text-sm">
                    <i class="<?= htmlspecialchars($svc['icon']) ?>"></i>
                  </span>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                  <h3 class="text-base font-bold text-white group-hover:text-[#e11d48] transition mb-2">
                    <?= htmlspecialchars($svc['name']) ?>
                  </h3>
                  <p class="text-gray-400 text-xs leading-relaxed line-clamp-3 mb-4 flex-grow">
                    <?= htmlspecialchars($svc['description']) ?>
                  </p>
                  <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="font-bold text-[#e11d48]">View In-Depth Details</span>
                    <i class="fa-solid fa-arrow-right text-[10px] text-gray-400 group-hover:text-[#e11d48] group-hover:translate-x-1 transition"></i>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Visa & Documentation Callout -->
      <section class="py-16 bg-neutral-950 border-b border-white/10">
        <div class="max-w-4xl mx-auto px-6 text-center">
          <div class="w-14 h-14 rounded-full bg-[#1ec700]/15 flex items-center justify-center text-[#1ec700] text-2xl mx-auto mb-4">
            <i class="fa-solid fa-passport"></i>
          </div>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
            Looking for Visa &amp; Immigration Assistance?
          </h2>
          <p class="text-gray-400 text-sm sm:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
            We run an all-India visa consultancy desk covering the USA, UK, Canada, Schengen Europe (29 countries), Australia, Japan, Singapore, and UAE with end-to-end documentation across 40+ Indian cities.
          </p>
          <a href="<?= $site ?>visa-services/"
            class="inline-block px-8 py-3 rounded-full text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition shadow-2xl">
            Explore Visa Services (40+ Cities)
          </a>
        </div>
      </section>

      <!-- Final CTA -->
      <section class="py-16 bg-neutral-900 border-b border-white/10">
        <div class="max-w-4xl mx-auto px-6 text-center">
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
            Not Sure Which Service Matches Your Need?
          </h2>
          <p class="text-gray-300 text-sm sm:text-base max-w-xl mx-auto mb-8">
            Tell us about your upcoming journey or your organization's travel requirements — our specialists will design the optimal solution.
          </p>
          <div class="flex flex-wrap justify-center gap-4">
            <a href="<?= $site ?>contact/#contactform"
              class="px-8 py-3 rounded-full text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition shadow-2xl">
              Talk to Our Travel Specialists
            </a>
            <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $contact['wp_number'] ?? '7982938239') ?>"
              target="_blank" rel="noopener"
              class="px-8 py-3 rounded-full text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 transition shadow-2xl flex items-center space-x-2">
              <i class="fa-brands fa-whatsapp text-base"></i>
              <span>Instant WhatsApp Consultation</span>
            </a>
          </div>
        </div>
      </section>

    <?php endif; ?>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <script src="<?= $site ?>assets/js/main.js"></script>
</body>
</html>
