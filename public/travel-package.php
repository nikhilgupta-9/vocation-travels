<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Package – <?= $contact['company_name'] ?></title>
  <?php include('link.php') ?>

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
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="assets/videos/TravelPackages.mp4" type="video/mp4">
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
        <a href="contact.php#contactform"
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
            <a href="contact.php#contactform" class="inline-block px-6 py-3 rounded-xl font-semibold text-white 
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
        <a href="contact.php#contactform"
          class="mt-6 inline-block px-6 py-3 bg-white text-green-700 font-semibold rounded-lg shadow-md hover:scale-105 transition duration-300">
          Enquire for Luxury Upgrades
        </a>
      </div>
    </section>

  </main>
  <?php include('footer.php') ?>

  <script src="assets/js/main.js"></script>


</body>

</html>