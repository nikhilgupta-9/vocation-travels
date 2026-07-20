<?php
if (session_status() === PHP_SESSION_NONE)
  session_start();
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us – <?= $contact['company_name'] ?></title>
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

    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }

      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    .animate-slideIn {
      animation: slideIn 0.5s ease-out;
    }

    /* Auto-hide after 5 seconds */
    #successMessage,
    #errorMessage,
    #validationErrors {
      transition: opacity 0.5s ease-out;
    }

    /* Optional: Add close button */
    .message-close {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      color: inherit;
      opacity: 0.5;
    }

    .message-close:hover {
      opacity: 1;
    }
  </style>
</head>

<body class="relative flex flex-col min-h-screen">
  <!-- Header -->
  <?php include('header.php') ?>

  <main class="flex-grow">

    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['contact_success'])): ?>
      <div
        class="fixed top-20 right-4 z-50 max-w-md bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg animate-slideIn"
        role="alert" id="successMessage">
        <div class="flex items-center">
          <div class="py-1">
            <svg class="h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <p class="font-bold">Success!</p>
            <p><?= htmlspecialchars($_SESSION['contact_success']) ?></p>
          </div>
        </div>
      </div>
      <?php unset($_SESSION['contact_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['contact_error'])): ?>
      <div
        class="fixed top-20 right-4 z-50 max-w-md bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg animate-slideIn"
        role="alert" id="errorMessage">
        <div class="flex items-center">
          <div class="py-1">
            <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <p class="font-bold">Error!</p>
            <p><?= htmlspecialchars($_SESSION['contact_error']) ?></p>
          </div>
        </div>
      </div>
      <?php unset($_SESSION['contact_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['contact_errors']) && is_array($_SESSION['contact_errors'])): ?>
      <div
        class="fixed top-20 right-4 z-50 max-w-md bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-lg animate-slideIn"
        role="alert" id="validationErrors">
        <div class="flex items-start">
          <div class="py-1">
            <svg class="h-6 w-6 text-yellow-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <div>
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="list-disc list-inside mt-2">
              <?php foreach ($_SESSION['contact_errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
      <?php unset($_SESSION['contact_errors']); ?>
    <?php endif; ?>


    <!-- Banner Section with Video Background -->
    <section class="relative h-screen w-full overflow-hidden">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="assets/videos/ContactUs.mp4" type="video/mp4">
        Your browser doesn’t support video.
      </video>
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1
          class="text-white font-bold leading-tight text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl max-w-3xl mb-6">
          Contact Vocation Travels And Tours
        </h1>
        <p class="text-white text-base sm:text-lg md:text-xl max-w-2xl mb-4">
          Reach out to us for travel packages, visa assistance, and more.<br> We’re here to help!
        </p>
      </div>
    </section>
    <section class="max-w-full py-12 bg-[#eaf6f9]">
      <div class="max-w-6xl mx-auto px-4 relative z-[100] -mt-4 sm:-mt-8 md:-mt-[149px]">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Canada Office -->
          <div
            class="bg-white  rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
            style="border-bottom: 5px solid green;">
            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">CANADA - ONTARIO</h3>
            <!--<p class="text-gray-700 mb-2">+1-437-937-3479‬ - Ms. Renu</p>-->
            <p class="text-gray-700 mb-2"><?= $contact['email'] ?></p>
          </div>
          <!-- DUBAI Office -->
          <div
            class="bg-white  rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
            style="border-bottom: 5px solid green;">
            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">DUBAI</h3>
            <!--<p class="text-gray-700 mb-2">+1-437-937-3479‬ - Ms. Renu</p>-->
            <p class="text-gray-700 mb-2">accounts@vocationtravels.com</p>
          </div>
          <!-- India Office -->
          <div
            class="bg-white  rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
            style="border-bottom: 5px solid green;">
            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">INDIA - NEW DELHI</h3>
            <p class="text-gray-700 mb-2 text-center">
              info@vocationtravels.com
            </p>
          </div>


        </div>

        <div style="margin-top:50px">
          <h4 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-6 text-center">
            Additional Details
          </h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 gap-8 justify-center items-center text-center mt-5">


          <div
            class="bg-white  rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
            style="border-bottom: 5px solid green;">
            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">Phone</h3>
            <p class="text-gray-700 mb-2">PH: <?= $contact['telephone'] ?> - Office</p>
            <p class="text-gray-700 mb-2"><?= $contact['phone'] ?> - Mr. Vinod</p>
            <p class="text-gray-700 mb-2"><?= $contact['wp_number'] ?> - Mr. Sawan</p>
            <p class="text-gray-700 mb-2">+1-437-937-3479‬ - Ms. Renu</p>
          </div>
          <!-- Email Section -->
          <!--<div class="bg-white  rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300" style="border-bottom: 5px solid green;">-->
          <!--  <h3 class="text-xl text-center font-semibold text-[#000] mb-2">Email</h3>-->
          <!--  <p class="text-gray-700 mb-2">Info@vocationtravels.com</p>-->
          <!--  <p class="text-gray-700 mb-2">Visa@vocationtravels.com</p>-->
          <!--  <p class="text-gray-700 mb-2">vocationtravels@gmail.com</p>-->

          <!--</div>-->

        </div>
      </div>
    </section>

    <!-- Travel Inquiry Form Section -->
    <section class="py-12 px-4 sm:px-8 md:px-16 lg:px-32 bg-[#eaf6f9]" id="contactform">
      <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg p-6" style="border-bottom: 5px solid green;">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6 text-center 
bg-gradient-to-r from-[#1ec700] to-[#e11d48] bg-[length:200%_100%] bg-clip-text text-transparent
">
          Special Request form
        </h2>


        <form action="<?= $site ?>util/process_contact.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6"
          autocomplete="off">


          <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

          <!-- Name -->
          <div class="col-span-1">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" id="name" name="name"
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
          </div>

          <!-- Phone Number -->
          <div class="col-span-1">
            <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone Number</label>
            <input type="tel" id="phone" name="phone"
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
          </div>

          <!-- Email -->
          <div class="col-span-1">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" id="email" name="email"
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
          </div>

          <!-- Date of Travel -->
          <div class="col-span-1">
            <label for="date" class="block text-gray-700 font-semibold mb-2">Date of Travel</label>
            <input type="date" id="date" name="date"
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
          </div>

          <!-- Number of People -->
          <div class="col-span-1 md:col-span-2">
            <label class="block text-gray-700 font-semibold mb-2">Number of People</label>
            <div class="grid grid-cols-2 gap-4">
              <!-- Adults -->
              <div>
                <label for="adults" class="block text-gray-600 text-sm mb-1">Adults</label>
                <input type="number" id="adults" name="adults" min="0"
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                  placeholder="e.g., 2" required>
              </div>
              <!-- Children -->
              <div>
                <label for="children" class="block text-gray-600 text-sm mb-1">Children</label>
                <input type="number" id="children" name="children" min="0"
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                  placeholder="e.g., 1">
              </div>
            </div>
          </div>

          <!-- Destination/Package -->
          <div class="col-span-1">
            <label for="destination" class="block text-gray-700 font-semibold mb-2">Destination/Package</label>
            <input type="text" id="destination" name="destination"
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="e.g., Kerala, Rajasthan Tour" required>
          </div>

          <!-- Package Timeline -->
          <div class="col-span-1">
            <label for="timeline" class="block text-gray-700 font-semibold mb-2">Package Timeline</label>
            <input type="text" id="timeline" name="timeline"
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="e.g., 5 Days / 4 Nights" required>
          </div>

          <!-- Additional Requirements / Comments -->
          <div class="col-span-1 md:col-span-2">
            <label for="comments" class="block text-gray-700 font-semibold mb-2">Preferences / Comments</label>
            <textarea id="comments" name="comments" rows="4"
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Any special requests, preferred hotel category, budget, etc."></textarea>
          </div>

          <!-- Submit -->
          <div class="col-span-1 md:col-span-2 text-center">
            <button type="submit"
              class="inline-block  bg-gradient-to-r from-green-600 to-red-600 text-white py-2 px-4 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
              Submit Inquiry
            </button>
          </div>
        </form>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('footer.php') ?>

  <script src="assets/js/main.js"></script>

  <script>
    // Auto-hide messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function () {
      setTimeout(function () {
        const successMsg = document.getElementById('successMessage');
        const errorMsg = document.getElementById('errorMessage');
        const validationMsg = document.getElementById('validationErrors');

        if (successMsg) {
          successMsg.style.opacity = '0';
          setTimeout(() => successMsg.remove(), 500);
        }
        if (errorMsg) {
          errorMsg.style.opacity = '0';
          setTimeout(() => errorMsg.remove(), 500);
        }
        if (validationMsg) {
          validationMsg.style.opacity = '0';
          setTimeout(() => validationMsg.remove(), 500);
        }
      }, 5000);
    });

    // Optional: Add close button functionality
    function closeMessage(elementId) {
      const element = document.getElementById(elementId);
      if (element) {
        element.style.opacity = '0';
        setTimeout(() => element.remove(), 500);
      }
    }
  </script>
</body>

</html>