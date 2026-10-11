<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();
$logo = get_header_logo();
$phone = $contact['phone'] ?? '9999447373';
$wp_number = $contact['wp_number'] ?? '7982938239';
$instagram_url = !empty($contact['instagram']) ? $contact['instagram'] : 'https://www.instagram.com/vocationtravels/';
?>

<!-- Main Sticky / Glassmorphism Navigation Wrapper -->
<header id="main-header" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
  <!-- Top Announcement & Quick Contact Bar -->
  <div id="top-announcement-bar" class="hidden md:block bg-black/80 backdrop-blur-sm text-gray-200 text-xs py-2 border-b border-white/10 overflow-hidden">
    <div class="container mx-auto px-6 flex justify-between items-center">
      <div class="flex items-center space-x-6">
        <a href="tel:+91<?= preg_replace('/[^0-9]/', '', $phone) ?>" class="flex items-center space-x-1.5 hover:text-white transition">
          <i class="fa-solid fa-phone text-[#1ec700]"></i>
          <span>+91 <?= htmlspecialchars($phone) ?></span>
        </a>
        <a href="mailto:<?= htmlspecialchars($contact['email'] ?? 'visa@vocationtravels.com') ?>" class="flex items-center space-x-1.5 hover:text-white transition">
          <i class="fa-solid fa-envelope text-[#1ec700]"></i>
          <span><?= htmlspecialchars($contact['email'] ?? 'visa@vocationtravels.com') ?></span>
        </a>
        <span class="text-gray-400">|</span>
        <span class="text-gray-300"><i class="fa-solid fa-earth-asia text-emerald-400 mr-1"></i> Serving 40+ Cities Across India &amp; Global Travelers</span>
      </div>
      <div class="flex items-center space-x-4">
        <a href="<?= htmlspecialchars($instagram_url) ?>" target="_blank" rel="noopener" class="hover:text-pink-400 transition flex items-center space-x-1">
          <i class="fa-brands fa-instagram text-base"></i>
          <span>@vocationtravels</span>
        </a>
        <?php if (!empty($contact['linkdin'])): ?>
          <a href="<?= htmlspecialchars($contact['linkdin']) ?>" target="_blank" rel="noopener" class="hover:text-blue-400 transition">
            <i class="fa-brands fa-linkedin text-base"></i>
          </a>
        <?php endif; ?>
        <?php if (!empty($contact['facebook'])): ?>
          <a href="<?= htmlspecialchars($contact['facebook']) ?>" target="_blank" rel="noopener" class="hover:text-blue-500 transition">
            <i class="fa-brands fa-facebook-f text-sm"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Main Navigation Bar -->
  <nav id="main-nav-bar" class="transition-all duration-300 bg-black/40 backdrop-blur-md border-b border-white/10">
    <div class="container mx-auto flex items-center justify-between py-3 px-6">
      <!-- Brand Logo -->
      <div class="flex items-center">
        <a href="<?= $site ?>" class="block">
          <img src="<?= $site . $logo ?>" alt="<?= htmlspecialchars($contact['company_name'] ?? 'Vocation Travels') ?>" class="h-10 sm:h-12 w-auto object-contain hover:opacity-90 transition" />
        </a>
      </div>

      <!-- Desktop Navigation Menu -->
      <div class="hidden lg:flex items-center space-x-6">
        <a href="<?= $site ?>" class="nav-link text-white text-sm font-medium tracking-wide">Home</a>

        <!-- Travel Packages Dropdown -->
        <div class="relative group">
          <a href="<?= $site ?>travel-package/" class="nav-link text-white text-sm font-medium tracking-wide flex items-center gap-1.5 py-2">
            <span>Travel Packages</span>
            <i class="fa-solid fa-chevron-down text-[10px] text-gray-300 group-hover:rotate-180 transition-transform duration-200"></i>
          </a>
          <div class="absolute left-0 top-full pt-1 w-80 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="bg-neutral-900/95 backdrop-blur-md rounded-2xl p-3 border border-white/10 shadow-2xl space-y-1 text-xs">
              <div class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-emerald-400 border-b border-white/10">
                Popular Holiday Packages
              </div>
              <a href="<?= $site ?>package/kashmir-paradise-tour/" class="block px-3 py-2 rounded-xl text-gray-200 hover:text-white hover:bg-white/10 transition">
                <i class="fa-solid fa-mountain text-emerald-400 mr-2"></i>Kashmir Paradise (5N/6D)
              </a>
              <a href="<?= $site ?>package/himachal-hill-stations/" class="block px-3 py-2 rounded-xl text-gray-200 hover:text-white hover:bg-white/10 transition">
                <i class="fa-solid fa-tree text-blue-400 mr-2"></i>Himachal &amp; Manali (5N/6D)
              </a>
              <a href="<?= $site ?>package/vaishno-devi-kashmir-tour/" class="block px-3 py-2 rounded-xl text-gray-200 hover:text-white hover:bg-white/10 transition">
                <i class="fa-solid fa-om text-amber-400 mr-2"></i>Mata Vaishno Devi &amp; Kashmir (6N/7D)
              </a>
              <a href="<?= $site ?>package/kerala-luxury-retreat/" class="block px-3 py-2 rounded-xl text-gray-200 hover:text-white hover:bg-white/10 transition">
                <i class="fa-solid fa-water text-green-400 mr-2"></i>Kerala Luxury Backwaters (5N/6D)
              </a>
              <a href="<?= $site ?>package/ladakh-high-altitude-expedition/" class="block px-3 py-2 rounded-xl text-gray-200 hover:text-white hover:bg-white/10 transition">
                <i class="fa-solid fa-compass text-purple-400 mr-2"></i>Leh Ladakh Expedition (6N/7D)
              </a>
              <a href="<?= $site ?>package/golden-triangle-package/" class="block px-3 py-2 rounded-xl text-gray-200 hover:text-white hover:bg-white/10 transition">
                <i class="fa-solid fa-landmark text-yellow-400 mr-2"></i>Golden Triangle Heritage (4N/5D)
              </a>
              <div class="pt-1.5 border-t border-white/10">
                <a href="<?= $site ?>travel-package/" class="block text-center px-3 py-2 rounded-xl bg-emerald-600/30 hover:bg-emerald-600 text-emerald-300 hover:text-white font-semibold transition">
                  Explore All 12+ Tour Packages &rarr;
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Visa Services Dropdown -->
        <div class="relative group">
          <a href="<?= $site ?>visa-services/" class="nav-link text-white text-sm font-medium tracking-wide flex items-center gap-1.5 py-2">
            <span>Visa Services</span>
            <i class="fa-solid fa-chevron-down text-[10px] text-gray-300 group-hover:rotate-180 transition-transform duration-200"></i>
          </a>
          <div class="absolute left-0 top-full pt-1 w-80 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="bg-neutral-900/95 backdrop-blur-md rounded-2xl p-3 border border-white/10 shadow-2xl space-y-1 text-xs">
              <div class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-pink-400 border-b border-white/10">
                Top Country Visas
              </div>
              <div class="grid grid-cols-2 gap-1 py-1">
                <a href="<?= $site ?>visa-services/usa/" class="px-2.5 py-1.5 rounded-lg text-gray-200 hover:text-white hover:bg-white/10 transition">🇺🇸 USA Visa</a>
                <a href="<?= $site ?>visa-services/uk/" class="px-2.5 py-1.5 rounded-lg text-gray-200 hover:text-white hover:bg-white/10 transition">🇬🇧 UK Visa</a>
                <a href="<?= $site ?>visa-services/canada/" class="px-2.5 py-1.5 rounded-lg text-gray-200 hover:text-white hover:bg-white/10 transition">🇨🇦 Canada Visa</a>
                <a href="<?= $site ?>visa-services/europe/" class="px-2.5 py-1.5 rounded-lg text-gray-200 hover:text-white hover:bg-white/10 transition">🇪🇺 Schengen</a>
                <a href="<?= $site ?>visa-services/australia/" class="px-2.5 py-1.5 rounded-lg text-gray-200 hover:text-white hover:bg-white/10 transition">🇦🇺 Australia</a>
                <a href="<?= $site ?>visa-services/uae/" class="px-2.5 py-1.5 rounded-lg text-gray-200 hover:text-white hover:bg-white/10 transition">🇦🇪 Dubai / UAE</a>
              </div>
              <div class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-amber-400 border-t border-white/10">
                Pan-India City Consultants
              </div>
              <div class="grid grid-cols-2 gap-1 py-1 text-[11px]">
                <a href="<?= $site ?>visa-consultants-delhi/" class="px-2 py-1 rounded text-gray-300 hover:text-white hover:bg-white/10">Delhi NCR</a>
                <a href="<?= $site ?>visa-consultants-bangalore/" class="px-2 py-1 rounded text-gray-300 hover:text-white hover:bg-white/10">Bangalore</a>
                <a href="<?= $site ?>visa-consultants-mumbai/" class="px-2 py-1 rounded text-gray-300 hover:text-white hover:bg-white/10">Mumbai</a>
                <a href="<?= $site ?>visa-consultants-hyderabad/" class="px-2 py-1 rounded text-gray-300 hover:text-white hover:bg-white/10">Hyderabad</a>
              </div>
              <div class="pt-1.5 border-t border-white/10">
                <a href="<?= $site ?>visa-services/" class="block text-center px-3 py-2 rounded-xl bg-pink-600/30 hover:bg-pink-600 text-pink-300 hover:text-white font-semibold transition">
                  View All 40+ Indian Cities &rarr;
                </a>
              </div>
            </div>
          </div>
        </div>

        <a href="<?= $site ?>vip-concierge/" class="nav-link text-white text-sm font-medium tracking-wide">VIP Concierge</a>
        <a href="<?= $site ?>services/" class="nav-link text-white text-sm font-medium tracking-wide">Services</a>
        <a href="<?= $site ?>about/" class="nav-link text-white text-sm font-medium tracking-wide">About</a>
        <a href="<?= $site ?>blogs/" class="nav-link text-white text-sm font-medium tracking-wide">Blog</a>
        <a href="<?= $site ?>contact/" class="nav-link text-white text-sm font-medium tracking-wide">Contact</a>
      </div>

      <!-- Desktop Header Action Buttons -->
      <div class="hidden lg:flex items-center space-x-3">
        <!-- Theme Toggle Button (Desktop) -->
        <button id="theme-toggle-btn" type="button" aria-label="Toggle Dark / Light Theme" title="Toggle Theme"
          class="theme-toggle-btn relative w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#1ec700] cursor-pointer shadow-sm">
          <i class="theme-icon-sun fa-solid fa-sun text-amber-300 text-sm hidden"></i>
          <i class="theme-icon-moon fa-solid fa-moon text-yellow-300 text-sm"></i>
        </button>

        <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $wp_number) ?>?text=Hi%20Vocation%20Travels,%20I%20want%20to%20plan%20a%20trip%20/%20visa" target="_blank" rel="noopener"
          class="flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-emerald-600/90 hover:bg-emerald-500 text-white text-xs font-semibold shadow-sm transition">
          <i class="fa-brands fa-whatsapp text-sm"></i>
          <span>WhatsApp</span>
        </a>
        <a href="<?= $site ?>contact/#contactform"
          class="px-5 py-2 rounded-full text-xs font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:shadow-lg hover:scale-105 transition transform duration-200">
          Enquire Now
        </a>
      </div>

      <!-- Mobile Hamburger & Actions -->
      <div class="flex items-center space-x-2.5 lg:hidden">
        <!-- Theme Toggle Button (Mobile) -->
        <button id="theme-toggle-mobile" type="button" aria-label="Toggle Dark / Light Theme" title="Toggle Theme"
          class="theme-toggle-btn p-2 rounded-full bg-white/10 text-white border border-white/20 focus:outline-none cursor-pointer">
          <i class="theme-icon-sun fa-solid fa-sun text-amber-300 text-sm hidden"></i>
          <i class="theme-icon-moon fa-solid fa-moon text-yellow-300 text-sm"></i>
        </button>

        <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $wp_number) ?>?text=Hi%20Vocation%20Travels,%20I%20want%20to%20inquire" target="_blank" rel="noopener"
          class="p-2 rounded-full bg-emerald-600 text-white text-sm shadow-md">
          <i class="fa-brands fa-whatsapp"></i>
        </a>
        <button id="nav-toggle" aria-label="Toggle navigation" class="p-2 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-white/20">
          <svg id="hamburger-icon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  </nav>
</header>

<!-- Mobile Slide-out Drawer Menu -->
<div id="mobile-nav-backdrop" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden transition-opacity duration-300"></div>
<div id="nav-menu" class="fixed inset-y-0 right-0 w-[82%] max-w-sm bg-neutral-950/95 border-l border-white/10 z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col justify-between p-6 shadow-2xl">
  <div>
    <!-- Close Button & Logo -->
    <div class="flex items-center justify-between pb-6 border-b border-white/10">
      <img src="<?= $site . $logo ?>" alt="<?= htmlspecialchars($contact['company_name'] ?? 'Logo') ?>" class="h-10 w-auto object-contain" />
      <button id="menu-close" aria-label="Close menu" class="text-gray-300 hover:text-white p-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col space-y-4 pt-6 text-lg font-medium text-gray-200">
      <li><a href="<?= $site ?>" class="block hover:text-[#1ec700] transition py-1">Home</a></li>
      <li><a href="<?= $site ?>travel-package/" class="block hover:text-[#1ec700] transition py-1">Travel Packages</a></li>
      <li><a href="<?= $site ?>visa-services/" class="block hover:text-[#1ec700] transition py-1">Visa Services</a></li>
      <li><a href="<?= $site ?>vip-concierge/" class="block hover:text-[#1ec700] transition py-1">VIP Concierge</a></li>
      <li><a href="<?= $site ?>services/" class="block hover:text-[#1ec700] transition py-1">Our Services</a></li>
      <li><a href="<?= $site ?>about/" class="block hover:text-[#1ec700] transition py-1">About Us</a></li>
      <li><a href="<?= $site ?>blogs/" class="block hover:text-[#1ec700] transition py-1">Travel Blog</a></li>
      <li><a href="<?= $site ?>contact/" class="block hover:text-[#1ec700] transition py-1">Contact Us</a></li>

      <!-- Theme Mode Switch in Drawer -->
      <li class="pt-3 border-t border-white/10">
        <button id="theme-toggle-drawer" type="button" class="w-full flex items-center justify-between py-2 text-base font-medium text-gray-200 hover:text-[#1ec700] transition">
          <span class="flex items-center space-x-2.5">
            <i class="theme-icon-sun fa-solid fa-sun text-amber-300 text-base hidden"></i>
            <i class="theme-icon-moon fa-solid fa-moon text-yellow-300 text-base"></i>
            <span class="theme-toggle-label">Theme Mode</span>
          </span>
          <span class="theme-mode-pill text-xs px-2.5 py-0.5 rounded-full bg-white/10 text-gray-300 border border-white/10">Theme</span>
        </button>
      </li>
    </ul>
  </div>

  <!-- Mobile Menu Footer Actions -->
  <div class="pt-6 border-t border-white/10 space-y-4">
    <a href="<?= $site ?>contact/#contactform"
      class="block w-full py-3 text-center rounded-xl font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] shadow-md">
      Enquire Now
    </a>
    <div class="flex justify-around text-gray-300 pt-2 text-xl">
      <a href="<?= htmlspecialchars($instagram_url) ?>" target="_blank" rel="noopener" class="hover:text-pink-400">
        <i class="fa-brands fa-instagram"></i>
      </a>
      <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $wp_number) ?>" target="_blank" rel="noopener" class="hover:text-emerald-400">
        <i class="fa-brands fa-whatsapp"></i>
      </a>
      <a href="tel:+91<?= preg_replace('/[^0-9]/', '', $phone) ?>" class="hover:text-green-400">
        <i class="fa-solid fa-phone"></i>
      </a>
      <?php if (!empty($contact['linkdin'])): ?>
        <a href="<?= htmlspecialchars($contact['linkdin']) ?>" target="_blank" rel="noopener" class="hover:text-blue-400">
          <i class="fa-brands fa-linkedin"></i>
        </a>
      <?php endif; ?>
    </div>
    <p class="text-center text-xs text-gray-400 pt-1">+91 <?= htmlspecialchars($phone) ?></p>
  </div>
</div>

<!-- Floating Quick Contact Buttons (Mobile & Desktop) -->
<div class="fixed bottom-6 right-6 z-40 flex flex-col space-y-3">
  <!-- WhatsApp Floating Button -->
  <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $wp_number) ?>?text=Hi%20Vocation%20Travels,%20I%20want%20to%20inquire%20about%20a%20tour%20package%20/%20visa"
    target="_blank" rel="noopener" aria-label="Chat on WhatsApp"
    class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center shadow-2xl hover:scale-110 transition duration-300 group relative">
    <i class="fa-brands fa-whatsapp text-2xl sm:text-3xl"></i>
    <span class="absolute right-16 bg-black/85 text-white text-xs px-2.5 py-1 rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition shadow pointer-events-none">
      Chat on WhatsApp
    </span>
  </a>
</div>

<script>
  (function() {
    const navToggle = document.getElementById("nav-toggle");
    const navMenu = document.getElementById("nav-menu");
    const menuClose = document.getElementById("menu-close");
    const backdrop = document.getElementById("mobile-nav-backdrop");
    const topBar = document.getElementById("top-announcement-bar");
    const mainNav = document.getElementById("main-nav-bar");

    function openMobileMenu() {
      navMenu.classList.remove("translate-x-full");
      backdrop.classList.remove("hidden");
      document.body.classList.add("overflow-hidden");
    }

    function closeMobileMenu() {
      navMenu.classList.add("translate-x-full");
      backdrop.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    }

    if (navToggle) navToggle.addEventListener("click", openMobileMenu);
    if (menuClose) menuClose.addEventListener("click", closeMobileMenu);
    if (backdrop) backdrop.addEventListener("click", closeMobileMenu);

    document.querySelectorAll("#nav-menu a").forEach(link => {
      link.addEventListener("click", closeMobileMenu);
    });

    // Header scroll behavior (collapse top bar & add solid background to navbar)
    function handleScroll() {
      const isScrolled = window.scrollY > 30;
      if (isScrolled) {
        if (topBar) topBar.classList.add("top-bar-hidden");
        if (mainNav) {
          mainNav.classList.add("bg-black/90", "shadow-xl", "is-scrolled");
          mainNav.classList.remove("bg-black/40");
        }
      } else {
        if (topBar) topBar.classList.remove("top-bar-hidden");
        if (mainNav) {
          mainNav.classList.remove("bg-black/90", "shadow-xl", "is-scrolled");
          mainNav.classList.add("bg-black/40");
        }
      }
    }

    window.addEventListener("scroll", handleScroll, { passive: true });
    // Check initial scroll position on load
    handleScroll();

    // Theme Switch Management
    function updateThemeUI(isDark) {
      const sunIcons = document.querySelectorAll(".theme-icon-sun");
      const moonIcons = document.querySelectorAll(".theme-icon-moon");
      const labels = document.querySelectorAll(".theme-toggle-label");
      const pills = document.querySelectorAll(".theme-mode-pill");

      sunIcons.forEach(icon => {
        if (isDark) icon.classList.remove("hidden");
        else icon.classList.add("hidden");
      });

      moonIcons.forEach(icon => {
        if (isDark) icon.classList.add("hidden");
        else icon.classList.remove("hidden");
      });

      labels.forEach(lbl => {
        lbl.textContent = isDark ? "Switch to Light Mode" : "Switch to Dark Mode";
      });

      pills.forEach(pill => {
        pill.textContent = isDark ? "Dark ON" : "Light ON";
        if (isDark) {
          pill.className = "theme-mode-pill text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30";
        } else {
          pill.className = "theme-mode-pill text-xs px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30";
        }
      });
    }

    function toggleTheme() {
      const isCurrentlyDark = document.documentElement.classList.contains("dark");
      const newTheme = isCurrentlyDark ? "light" : "dark";

      if (newTheme === "dark") {
        document.documentElement.classList.add("dark");
        document.documentElement.setAttribute("data-theme", "dark");
      } else {
        document.documentElement.classList.remove("dark");
        document.documentElement.setAttribute("data-theme", "light");
      }

      localStorage.setItem("vt_theme", newTheme);
      updateThemeUI(newTheme === "dark");
      window.dispatchEvent(new CustomEvent("themeChanged", { detail: { theme: newTheme } }));
    }

    window.toggleVocationTheme = toggleTheme;

    ["theme-toggle-btn", "theme-toggle-mobile", "theme-toggle-drawer"].forEach(id => {
      const btn = document.getElementById(id);
      if (btn) btn.addEventListener("click", toggleTheme);
    });

    // Initialize UI icons on page load
    const initialIsDark = document.documentElement.classList.contains("dark");
    updateThemeUI(initialIsDark);

    if (window.matchMedia) {
      window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", e => {
        if (!localStorage.getItem("vt_theme")) {
          if (e.matches) {
            document.documentElement.classList.add("dark");
            document.documentElement.setAttribute("data-theme", "dark");
          } else {
            document.documentElement.classList.remove("dark");
            document.documentElement.setAttribute("data-theme", "light");
          }
          updateThemeUI(e.matches);
        }
      });
    }
  })();
</script>

<style>
  #top-announcement-bar {
    max-height: 50px;
    transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.25s ease,
                padding 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                border-color 0.25s ease;
  }
  #top-announcement-bar.top-bar-hidden {
    max-height: 0 !important;
    opacity: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    border-bottom: 0px transparent !important;
    pointer-events: none;
  }
  .nav-link {
    position: relative;
    padding-bottom: 4px;
    transition: color 0.25s ease;
  }
  .nav-link::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    height: 2px;
    width: 0;
    border-radius: 9999px;
    background: linear-gradient(to right, #1ec700, #e11d48);
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .nav-link:hover::after {
    width: 100%;
  }
</style>