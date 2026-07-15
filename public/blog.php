<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from travel.leadsteck.site/blog.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Feb 2026 10:31:34 GMT -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog – Vocation Travels And Tours</title>
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
    <section class="relative h-[70vh] w-full overflow-hidden">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="assets/videos/Services.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1 class="text-white font-bold leading-tight text-5xl md:text-6xl lg:text-7xl mb-4 drop-shadow-lg">
          Travel Stories & Insights
        </h1>
        <p class="text-indigo-100 text-lg md:text-2xl max-w-2xl mb-6 font-light drop-shadow">
          Explore tips, guides, and stories from around the world
        </p>
      </div>
    </section>

    <!-- Blog Section -->
    <section class="py-16 px-6 md:px-12 lg:px-20">
      <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Latest Blogs</h2>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
          <!-- Blog Card -->
          <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
            <img src="assets/images/blog1.jpg" alt="Blog 1" class="w-full h-56 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">Top 10 Destinations for 2025</h3>
              <p class="text-gray-600 text-sm mb-4">Discover the hottest travel destinations for the upcoming year and
                why they should be on your bucket list.</p>
              <a href="blog-detail2340.html?post=top-10-destinations">Read More →</a>
            </div>
          </div>

          <!-- Blog Card -->
          <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
            <img src="assets/images/blog2.jpg" alt="Blog 2" class="w-full h-56 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">Luxury Travel Hacks</h3>
              <p class="text-gray-600 text-sm mb-4">Learn how to travel in luxury without breaking the bank, from
                flights to exclusive stays.</p>
              <a href="blog-detaile252.html?post=luxury-travel-hacks">Read More →</a>
            </div>
          </div>

          <!-- Blog Card -->
          <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
            <img src="assets/images/blog3.jpg" alt="Blog 3" class="w-full h-56 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">Hidden Gems of India</h3>
              <p class="text-gray-600 text-sm mb-4">Step away from the usual tourist spots and uncover India’s best-kept
                travel secrets.</p>
              <a href="blog-detailfd55.html?post=hidden-gems-india">Read More →</a>
            </div>
          </div>

          <!-- More Blog Cards can be added here -->
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

<!-- Mirrored from travel.leadsteck.site/blog.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Feb 2026 10:31:40 GMT -->

</html>