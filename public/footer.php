<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";
include_once __DIR__ . "/../util/visa_countries.php";
include_once __DIR__ . "/../util/visa_cities.php";

$footer_logo = get_footer_logo();
if (empty($footer_logo)) {
    $footer_logo = get_header_logo();
}
if (empty($footer_logo)) {
    $footer_logo = 'assets/images/logo.png';
}

$footer_visa_countries = get_visa_countries();
$footer_visa_cities = get_visa_cities();
uasort($footer_visa_cities, fn($a, $b) => $a['order'] <=> $b['order']);
$instagram_url = !empty($contact['instagram']) ? $contact['instagram'] : 'https://www.instagram.com/vocationtravels/';
$phone = $contact['phone'] ?? '9999447373';
$wp_number = $contact['wp_number'] ?? '7982938239';
?>
<footer class="bg-neutral-950 text-gray-300 pt-16 pb-8 border-t border-white/10">
  <div class="container mx-auto px-6">
    <!-- Top Grid: 4 Columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
      <!-- Col 1: About & Brand -->
      <div class="space-y-4">
        <a href="<?= $site ?>" class="inline-block">
          <img class="h-14 w-auto object-contain" src="<?= $site . $footer_logo ?>" alt="<?= htmlspecialchars($contact['company_name'] ?? 'Vocation Travels') ?>">
        </a>
        <p class="text-sm text-gray-400 leading-relaxed">
          Premium domestic &amp; international tour packages and trusted visa consultancy serving travelers and students across 40+ Indian cities and globally.
        </p>
        <div class="flex items-center space-x-3 pt-2">
          <a href="<?= htmlspecialchars($instagram_url) ?>" target="_blank" rel="noopener" aria-label="Instagram"
            class="w-9 h-9 rounded-full bg-white/10 hover:bg-gradient-to-tr hover:from-amber-500 hover:to-pink-500 text-white flex items-center justify-center transition">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <?php if (!empty($contact['facebook'])): ?>
            <a href="<?= htmlspecialchars($contact['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook"
              class="w-9 h-9 rounded-full bg-white/10 hover:bg-blue-600 text-white flex items-center justify-center transition">
              <i class="fa-brands fa-facebook-f text-sm"></i>
            </a>
          <?php endif; ?>
          <?php if (!empty($contact['linkdin'])): ?>
            <a href="<?= htmlspecialchars($contact['linkdin']) ?>" target="_blank" rel="noopener" aria-label="LinkedIn"
              class="w-9 h-9 rounded-full bg-white/10 hover:bg-blue-500 text-white flex items-center justify-center transition">
              <i class="fa-brands fa-linkedin-in text-sm"></i>
            </a>
          <?php endif; ?>
          <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $wp_number) ?>?text=Hi%20Vocation%20Travels" target="_blank" rel="noopener" aria-label="WhatsApp"
            class="w-9 h-9 rounded-full bg-white/10 hover:bg-emerald-600 text-white flex items-center justify-center transition">
            <i class="fa-brands fa-whatsapp text-base"></i>
          </a>
        </div>
      </div>

      <!-- Col 2: Quick Links -->
      <div>
        <h4 class="text-white font-bold text-base mb-4 tracking-wider uppercase border-l-2 border-[#1ec700] pl-3">Quick Navigation</h4>
        <ul class="space-y-2.5 text-sm text-gray-400">
          <li><a href="<?= $site ?>" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>Home</a></li>
          <li><a href="<?= $site ?>travel-package/" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>Holiday Tour Packages</a></li>
          <li><a href="<?= $site ?>visa-services/" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>Visa &amp; Immigration Services</a></li>
          <li><a href="<?= $site ?>vip-concierge/" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>VIP Concierge Services</a></li>
          <li><a href="<?= $site ?>services/" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>All Services</a></li>
          <li><a href="<?= $site ?>about/" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>About Our Agency</a></li>
          <li><a href="<?= $site ?>blogs/" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>Travel Guides &amp; Blog</a></li>
          <li><a href="<?= $site ?>contact/" class="hover:text-white transition flex items-center"><i class="fa-solid fa-angle-right text-xs mr-2 text-[#1ec700]"></i>Contact &amp; Inquiries</a></li>
        </ul>
      </div>

      <!-- Col 3: Popular Visa Destinations -->
      <div>
        <h4 class="text-white font-bold text-base mb-4 tracking-wider uppercase border-l-2 border-[#e11d48] pl-3">Popular Visas</h4>
        <ul class="space-y-2.5 text-sm text-gray-400">
          <?php foreach ($footer_visa_countries as $fslug => $fcountry): ?>
            <li>
              <a href="<?= $site ?>visa-services/<?= htmlspecialchars($fslug) ?>/" class="hover:text-white transition flex items-center">
                <span class="mr-2"><?= $fcountry['flag'] ?></span>
                <span><?= htmlspecialchars($fcountry['name']) ?> Visa</span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Col 4: Contact & Global Presence -->
      <div>
        <h4 class="text-white font-bold text-base mb-4 tracking-wider uppercase border-l-2 border-emerald-400 pl-3">Reach Us</h4>
        <div class="space-y-3 text-sm text-gray-400">
          <p class="flex items-start space-x-3">
            <i class="fa-solid fa-phone text-[#1ec700] mt-1"></i>
            <a href="tel:+91<?= preg_replace('/[^0-9]/', '', $phone) ?>" class="hover:text-white transition">+91 <?= htmlspecialchars($phone) ?></a>
          </p>
          <p class="flex items-start space-x-3">
            <i class="fa-brands fa-whatsapp text-emerald-400 mt-1"></i>
            <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $wp_number) ?>" target="_blank" rel="noopener" class="hover:text-white transition">+91 <?= htmlspecialchars($wp_number) ?></a>
          </p>
          <p class="flex items-start space-x-3">
            <i class="fa-solid fa-envelope text-[#e11d48] mt-1"></i>
            <a href="mailto:<?= htmlspecialchars($contact['email'] ?? 'visa@vocationtravels.com') ?>" class="hover:text-white transition"><?= htmlspecialchars($contact['email'] ?? 'visa@vocationtravels.com') ?></a>
          </p>
          <p class="flex items-start space-x-3">
            <i class="fa-solid fa-location-dot text-amber-400 mt-1"></i>
            <a href="<?= htmlspecialchars($contact['map'] ?? 'https://share.google/EzOt9py4AbwOfVnO1') ?>" target="_blank" rel="noopener" class="hover:text-white transition">
              <?= htmlspecialchars($contact['address'] ?? 'Room No. 309, 3rd Floor, Transport Authority Building, District Centre, Janakpuri, New Delhi - 110058') ?>
            </a>
          </p>
          <div class="pt-2 border-t border-white/10">
            <p class="text-xs font-semibold text-gray-300">Global Presence:</p>
            <p class="text-xs text-gray-400 mt-0.5"><i class="fa-solid fa-globe text-emerald-400 mr-1"></i> India | Dubai | Canada</p>
          </div>
        </div>
      </div>
    </div>

    <!-- SEO Section: Visa Consultants Across 40+ Indian Cities -->
    <div class="border-t border-white/10 pt-8 pb-6">
      <div class="text-center mb-6">
        <h4 class="text-white font-bold text-lg mb-2">Visa &amp; Immigration Consultants Across India</h4>
        <p class="text-gray-400 text-xs sm:text-sm max-w-3xl mx-auto">
          Providing specialized documentation, application filing &amp; appointment assistance in all major metros and Tier 1, 2 &amp; 3 cities:
        </p>
      </div>

      <div class="flex flex-wrap justify-center gap-2 max-w-6xl mx-auto text-xs">
        <?php foreach ($footer_visa_cities as $cslug => $fcity): ?>
          <a href="<?= $site ?>visa-consultants-<?= htmlspecialchars($cslug) ?>/"
            class="px-3 py-1.5 rounded-full bg-white/5 hover:bg-white/15 text-gray-300 hover:text-white border border-white/10 transition">
            Visa Consultants in <?= htmlspecialchars($fcity['name']) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Copyright & Legal -->
    <div class="border-t border-white/10 pt-6 mt-4 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500">
      <p><?= htmlspecialchars($contact['copyright'] ?? '© 2026') ?> <?= htmlspecialchars($contact['company_name'] ?? 'Vocation Travels And Tours') ?>. All rights reserved.</p>
      <div class="flex space-x-4 mt-3 sm:mt-0">
        <a href="<?= $site ?>privacy-policy/" class="hover:text-gray-300 transition">Privacy Policy</a>
        <span class="text-gray-600">|</span>
        <a href="<?= $site ?>terms-and-conditions/" class="hover:text-gray-300 transition">Terms &amp; Conditions</a>
        <span class="text-gray-600">|</span>
        <a href="<?= $site ?>sitemap.xml" class="hover:text-gray-300 transition">Sitemap</a>
      </div>
    </div>
  </div>
</footer>