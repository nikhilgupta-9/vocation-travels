<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();
$logo = get_header_logo();
$footer_logo = get_footer_logo();
$gallery = get_gallery();
$about = fetch_about();
$banner = fetch_banner();
$testimonial = testimonial();
$products = get_all_product();
$product_home = get_home_product();
$trending_pro = get_trending_product();
$brand = get_best_brand();
?>

<header class="absolute inset-x-0 top-0 z-50 bg-transparent">
  <div class="container mx-auto flex items-center justify-between py-4 px-6">
    <!-- Logo -->
    <div class="flex items-center logo">
      <a href="<?= $site ?>">
        <img src="<?= $site . $logo ?>" alt="<?= $contact['company_name'] ?>" class=" w-auto" />
      </a>
    </div>

    <!-- Nav -->
    <nav class="relative">
      <!-- Hamburger (mobile) -->
      <button id="nav-toggle" class="sm:hidden focus:outline-none text-white relative z-50">
        <!-- Hamburger Icon -->
        <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Menu -->
      <ul id="nav-menu"
        class="hidden fixed inset-0 bg-black/95 flex flex-col items-center justify-center space-y-8 text-2xl
                 sm:static sm:flex sm:flex-row sm:space-y-0 sm:space-x-6 sm:bg-transparent sm:text-base sm:relative sm:inset-auto">

        <!-- Close Icon inside menu -->
        <button id="menu-close" class="absolute top-6 right-6 text-white focus:outline-none">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <li><a href="<?= $site ?>" class="nav-link">Home</a></li>
        <li><a href="<?= $site ?>about.php" class="nav-link">About Us</a></li>
        <li><a href="<?= $site ?>contact.php" class="nav-link">Contact Us</a></li>
        <li><a href="<?= $site ?>blog.php" class="nav-link">News</a></li>
        <li><a href="<?= $site ?>service.php" class="nav-link">Our Services</a></li>
        <li><a href="<?= $site ?>visa-services.php" class="nav-link">Visa Services</a></li>
        <li><a href="<?= $site ?>travel-package.php" class="nav-link">Travel Packages</a></li>
        <li><a href="<?= $site ?>vipconcierge.php" class="nav-link">Vip Concierge</a></li>
      </ul>
    </nav>
  </div>
</header>

<script>
  const navToggle = document.getElementById("nav-toggle");
  const navMenu = document.getElementById("nav-menu");
  const hamburgerIcon = document.getElementById("hamburger-icon");
  const menuClose = document.getElementById("menu-close");

  // Toggle menu open
  navToggle.addEventListener("click", () => {
    navMenu.classList.toggle("hidden");
  });

  // Close when clicking close button inside menu
  menuClose.addEventListener("click", () => {
    navMenu.classList.add("hidden");
  });

  // Auto close on mobile when clicking a link
  document.querySelectorAll("#nav-menu a").forEach(link => {
    link.addEventListener("click", () => {
      if (window.innerWidth < 640) {
        navMenu.classList.add("hidden");
      }
    });
  });
</script>

<style>
  .nav-link {
    position: relative;
    color: white;
    padding-bottom: 5px;
    transition: color 0.3s ease;
  }

  .nav-link:hover {
    color: #fff;
  }

  .nav-link::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    height: 2px;
    width: 0;
    border-radius: 2px;
    background: linear-gradient(to right, #1ec700, #1ec700, #e11d48);
    transition: width 0.3s ease;
  }

  .nav-link:hover::after {
    width: 100%;
  }

  @media (min-width: 767px) {
    button#menu-close {
      display: none;
    }
  }
</style>