<?php
include_once __DIR__ . "/../util/visa_countries.php";
include_once __DIR__ . "/../util/visa_cities.php";
$footer_visa_countries = get_visa_countries();
$footer_visa_cities = get_visa_cities();
uasort($footer_visa_cities, fn($a, $b) => $a['order'] <=> $b['order']);
?>
<footer class="bg-[#222121] text-white pt-12 pb-6">
  <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-1 gap-2">
    <div class="logo-g text-center"> <img class="footeer_logo" src="<?= $site . $footer_logo ?>" alt="<?= $contact['company_name'] ?>"></div>
    <div class=" mx-auto px-6  text-center lg:text-left">
      <h2 class="text-3xl sm:text-4xl text-center font-bold"><?= $contact['company_name'] ?></h2>
    </div>
    <!-- Contact Us -->
    <div class="footer_logo text-center">

      <!--      <p class="font-bold mb-4">For Those Who Demand the Extraordinary.<br>-->
      <!--Travel Without Limits , The World Is Your Home.-->
      <!--</p>-->

    </div>
    <!-- Socials -->
    <div class="footer-social-links">
      <ul>
        <li>
          <a href="<?= $contact['company_name'] ?>"><i
              class="fa-brands fa-facebook-f"></i></a>
        </li>
        <!--<li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>-->
        <li><a href="<?= $contact['linkdin'] ?>"><i class="fa-brands fa-linkedin"></i></a></li>
        <!--<li><a href="#"><i class="fa-brands fa-pinterest"></i></a></li>-->
        <li><a href="<?= $contact['instagram'] ?>"><i
              class="fa-brands fa-instagram"></i></a></li>
      </ul>
    </div>
    <!-- Popular Visa Destinations -->
    <div style="margin:10px 0px; text-align:center;">
      <h4 class="font-bold mb-3">Popular Visa Destinations</h4>
      <ul class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm text-gray-300">
        <?php foreach ($footer_visa_countries as $fslug => $fcountry): ?>
          <li><a href="<?= $site ?>visa-country.php?country=<?= htmlspecialchars($fslug) ?>" class="hover:text-white"><?= htmlspecialchars($fcountry['name']) ?> Visa</a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Visa Consultants by City -->
    <div style="margin:10px 0px; text-align:center;">
      <h4 class="font-bold mb-3">Visa Consultants by City</h4>
      <ul class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm text-gray-300">
        <?php foreach ($footer_visa_cities as $cslug => $fcity): ?>
          <li><a href="<?= $site ?>visa-consultants.php?city=<?= htmlspecialchars($cslug) ?>" class="hover:text-white">Visa Consultants in <?= htmlspecialchars($fcity['name']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Global Offices -->
    <hr style="
      width: 5%; 
      height: 3px; 
      border: none; 
      margin: 20px auto; 
      border-radius: 20px; 
      background: linear-gradient(to right, #1ec700, #1ec700, #e11d48);
    ">
    <div style="margin:20px 0px; text-align:center;">
      <h4 class="font-bold mb-4">OUR OFFICES</h4>
      <!--<h5 class="text-2xl sm:text-4xl text-center font-bold">Dubai, Canada , India</h5>-->
      <ul class="space-y-2">
        <li>Dubai | Canada | India</li>

      </ul>
    </div>
  </div>

  <!-- Brand Name / Big Title -->


  <!-- Copyright & Privacy -->
  <div class="container mx-auto px-6 mt-6 text-center text-sm space-y-1"
    style="border-top: 1px solid #ffffff38; padding: 25px;">
    <p><?= $contact['copyright'] ?>. <?= $contact['company_name'] ?>
    </p>
  </div>
</footer>


<script src="../cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="../cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>