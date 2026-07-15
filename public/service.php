<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from travel.leadsteck.site/service.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Feb 2026 10:31:40 GMT -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Services – Vocation Travels And Tours</title>
  <?php include('link.php') ?>

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

    <!-- Hero Section -->
    <section class="relative h-screen w-full overflow-hidden">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="assets/videos/blogvideo.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1 class="text-white font-bold leading-tight text-5xl md:text-6xl lg:text-7xl xl:text-8xl mb-6 drop-shadow-lg">
          Exclusive Solutions<br> Crafted for YOU
        </h1>
        <p class="text-indigo-100 text-lg md:text-2xl max-w-2xl mb-6 font-light drop-shadow">
          It’s all about Travel.
        </p>
        <a href="contact.html"
          class="inline-block px-8 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition-all duration-200">
          Since 2011
        </a>
      </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 ">

      <!-- Service 1 -->
      <div class="relative flex items-center justify-center overflow-hidden" style="padding:80px 0px 80px;">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
          <source src="assets/videos/CurrencyChangeAssistance.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 w-full max-w-3xl px-6" x-data="{ open: false }">
          <div @click="open = !open"
            class="backdrop-blur-2xl bg-white/10 rounded-3xl border border-[#01ba03]/20 border-b-4 border-[#01ba03] shadow-2xl p-8 text-center cursor-pointer transition duration-500 hover:scale-105">
            <img src="assets/images/currency.png" alt="Currency Icon"
              class="h-14 w-14 mx-auto mb-4 animate-bounce bg-gradient-to-t from-[#1ec700] via-[#1ec700] to-[#e11d48] bg-clip-text text-transparent"
              style="filter: brightness(0) invert(1);">
            <h3 class="text-3xl font-bold text-white drop-shadow-lg">Currency Change Assistance</h3>
            <div x-show="open" x-transition class="mt-6">

              <p class="text-indigo-100 text-lg leading-relaxed">
                Travel with ease knowing that your currency exchange needs are taken care of — swiftly, securely, and at
                the best rates.
                Our team ensures you always have access to the right currency, avoiding delays or unnecessary hassles,
                so your focus remains on enjoying your trip.
              </p>
            </div>
            <div class="mt-4">
              <i :class="open ? 'fa-solid fa-chevron-up text-white' : 'fa-solid fa-chevron-down text-white'"
                class="text-xl transition-all"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Service 2 -->
      <div class="relative flex items-center justify-center overflow-hidden" style="padding:80px 0px 80px;">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
          <source src="assets/videos/Planning.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 w-full max-w-3xl px-6" x-data="{ open: false }">
          <div @click="open = !open"
            class="backdrop-blur-2xl bg-white/10 rounded-3xl border border-[#01ba03]/20 border-b-4 border-[#01ba03] shadow-2xl p-8 text-center cursor-pointer transition duration-500 hover:scale-105">
            <img src="assets/images/travel.png" alt="Planning Icon"
              class="h-14 w-14 mx-auto mb-4 animate-bounce bg-gradient-to-t from-[#1ec700] via-[#1ec700] to-[#e11d48] bg-clip-text text-transparent "
              style="filter: brightness(0) invert(1);">
            <h3 class="text-3xl font-bold text-white drop-shadow-lg">Tailored Travel, Crafted Around You</h3>
            <div x-show="open" x-transition class="mt-6">

              <p class="text-indigo-100 text-lg leading-relaxed">
                We believe your journey should reflect your unique preferences. Let us handle the details, while you
                focus on the experience.
                From designing bespoke itineraries to curating experiences that match your tastes, every trip is
                thoughtfully crafted to create lasting memories.
              </p>
            </div>
            <div class="mt-4">
              <i :class="open ? 'fa-solid fa-chevron-up text-white' : 'fa-solid fa-chevron-down text-white'"
                class="text-xl transition-all"></i>
            </div>
          </div>
        </div>
      </div>


      <!-- Service 3 -->

      <div class="relative flex items-center justify-center overflow-hidden" style="padding:80px 0px 80px;">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
          <source src="assets/videos/Royal.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 w-full max-w-3xl px-6" x-data="{ open: false }">
          <div @click="open = !open"
            class="backdrop-blur-2xl bg-white/10 rounded-3xl border border-[#01ba03]/20 border-b-4 border-[#01ba03] shadow-2xl p-8 text-center cursor-pointer transition duration-500 hover:scale-105">
            <img src="assets/images/vip.png" alt="VIP Icon"
              class="h-14 w-14 mx-auto mb-4 animate-bounce bg-gradient-to-t from-[#1ec700] via-[#1ec700] to-[#e11d48] bg-clip-text text-transparent"
              style="filter: brightness(0) invert(1);">
            <h3 class="text-3xl font-bold text-white drop-shadow-lg">VIP Concierge Service</h3>
            <div x-show="open" x-transition class="mt-6">

              <p class="text-indigo-100 text-lg leading-relaxed">
                Experience the ultimate in luxury travel with our exclusive VIP Concierge service — offering
                personalized care and attention at every step of your journey.
                From private transfers and exclusive reservations to on-demand assistance during your travels, we ensure
                your journey is effortless, comfortable, and unforgettable.
              </p>
            </div>
            <div class="mt-4">
              <i :class="open ? 'fa-solid fa-chevron-up text-white' : 'fa-solid fa-chevron-down text-white'"
                class="text-xl transition-all"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Service 4 -->
      <div class="relative flex items-center justify-center overflow-hidden" style="padding:80px 0px 80px;">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
          <source src="assets/videos/VisaServices.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 w-full max-w-3xl px-6" x-data="{ open: false }">
          <div @click="open = !open"
            class="backdrop-blur-2xl bg-white/10 rounded-3xl border border-[#01ba03]/20 border-b-4 border-[#01ba03] shadow-2xl p-8 text-center cursor-pointer transition duration-500 hover:scale-105">
            <img src="assets/images/visa.png" alt="Visa Icon"
              class="h-14 w-14 mx-auto mb-4 animate-bounce bg-gradient-to-t from-[#1ec700] via-[#1ec700] to-[#e11d48] bg-clip-text text-transparent"
              style="filter: brightness(0) invert(1);">
            <h3 class="text-3xl font-bold text-white drop-shadow-lg">VISA Made EASY</h3>
            <div x-show="open" x-transition class="mt-6">

              <p class="text-indigo-100 text-lg leading-relaxed">
                Navigating visas can be complex — we simplify the process, ensuring smooth travels with hassle-free visa
                arrangements.
                We guide you through every step, from document preparation to submission, so you can embark on your
                journey with complete peace of mind.
              </p>
            </div>
            <div class="mt-4">
              <i :class="open ? 'fa-solid fa-chevron-up text-white' : 'fa-solid fa-chevron-down text-white'"
                class="text-xl transition-all"></i>
            </div>
          </div>
        </div>
      </div>



    </section>




  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <!-- Scripts -->
  <script src="../unpkg.com/alpinejs%403.15.8/dist/cdn.min.js" defer></script>
  <script src="assets/js/main.js"></script>
</body>

<!-- Mirrored from travel.leadsteck.site/service.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Feb 2026 10:31:41 GMT -->

</html>