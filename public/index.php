<?php
include_once __DIR__ . "/../config/connect.php";

$meta_title = 'Vocation Travels And Tours – Tour Packages & Visa Services in Hyderabad & Bangalore';
$meta_description = 'Vocation Travels And Tours plans domestic and international tour packages and provides visa services for travelers in Hyderabad, Bangalore and across India — covering USA, UK, Canada, Europe, Australia, Japan, Singapore and UAE/Dubai visas.';
$meta_keywords = ['tour and travel packages India', 'travel agency Hyderabad', 'travel agency Bangalore', 'domestic tour packages', 'international tour packages', 'visa services Hyderabad', 'visa consultants Bangalore', 'visa agent India', 'USA visa', 'UK visa', 'Canada visa', 'Europe Schengen visa', 'Australia visa', 'Japan visa', 'Singapore visa', 'UAE Dubai visa', 'holiday packages India', 'best travel agency India'];
$canonical_path = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($meta_title) ?></title>
    <?php include('link.php') ?>
    <?php include('seo-meta.php') ?>


    <style>
        .body {
            padding: 0px !important;
        }

        .container {
            margin: auto !important;
        }

        .logo-g.text-center {
            display: flex;
            justify-content: center;
        }

        .service-card {
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 0%;
            /* Logo colors: green (#1ec700), blue (#1e40af), red (#e11d48) */
            background: linear-gradient(to top, #1ec700 0%, #1ec700 60%, #e11d48 100%);
            opacity: 0.85;
            z-index: 1;
            transition: height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1rem;
        }

        .service-card:hover::before {
            height: 100%;
        }

        .service-card .service-content {
            position: relative;
            z-index: 2;
            transition: color 0.3s;
        }

        .service-card:hover .service-content h3,
        .service-card:hover .service-content p {
            color: #fff !important;
        }

        .service-card img {
            transition: transform 0.3s;
        }

        .service-card:hover img {
            transform: scale(1.1);
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

        @media (min-width: 1536px) {
            .container {
                max-width: 1620px !important;
            }
        }
    </style>

</head>

<body class="relative flex flex-col min-h-screen">

    <?php include('header.php') ?>

    <!-- Main Content -->
    <main class="flex-grow">

        <!-- Hero Section -->
        <section class="relative h-screen w-full overflow-hidden">
            <video id="hero-video" class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="assets/videos/hero-banner.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                <h1 class="text-white text-shadow-2xs font-bold leading-tight
                   text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-6xl
                   max-w-3xl mb-6 drop-shadow-[0_4px_24px_rgba(0,0,0,0.7)]">
                    For Those <span
                        class="bg-gradient-to-r from-[#1ec700] via-[#1ec700] to-[#e11d48] text-transparent bg-clip-text drop-shadow-[0_2px_8px_rgba(0,0,0,0.7)]">
                        Who Demand </span>the <span
                        class="bg-gradient-to-r from-[#1ec700] via-[#1ec700] to-[#e11d48] text-transparent bg-clip-text drop-shadow-[0_2px_8px_rgba(0,0,0,0.7)]">Extraordinary.</span>
                </h1>
                <p style="color:#fff; margin-bottom:15px;">Travel Without Limits — The World Is Your Home</p>
                <a href="travel-package.html" class="inline-block px-6 py-3 border border-white rounded-full
                  text-white font-medium
                  hover:bg-white hover:text-black
                  transition-colors duration-200">
                    Explore
                </a>
            </div>
        </section>

        <!-- Domestic Packages -->
        <section id="work-slider" class="relative bg-white parallax-section">
            <div class="relative overflow-hidden">
                <!-- Rotated Domestic Packages Image -->
                <img src="assets/images/domestic-packages.png" alt="Domestic Packages"
                    class="hidden md:block absolute left-[-132px] top-1/2 -translate-y-1/2 rotate-[-90deg] h-[115px] z-20">
                <!-- Slides Container -->
                <div id="slides" class="flex transition-transform duration-500">

                    <!-- Slide 1 -->
                    <div class="min-w-full relative h-screen sm:h-screen md:h-screen">
                        <img src="assets/images/goa-fun-fiesta.jpg" alt="Brand USA"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                            <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white mb-4">
                                GOA <br>FUN FIESTA PACKAGE
                            </h2>
                            <p class="text-base sm:text-lg text-white mb-6">
                                5 Nights / 6 Days Goa Package Includes water sports & adventure activities
                            </p>
                            <a href="travel-package.html" class="px-6 py-3 border border-white rounded-full text-white font-medium
                    hover:bg-white hover:text-black transition">
                                Learn More
                            </a>
                        </div>
                    </div>


                    <!-- Slide 2 -->
                    <div class="min-w-full relative h-screen sm:h-screen md:h-screen">
                        <img src="assets/images/Delhi-Agra-Mathura-Tour-Itinerary.jpg" alt="Turkish Airlines"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                            <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white mb-4">
                                GOLDEN TRIANGLE PACKAGE <br>(DELHI - AGRA - MATHURA - DELHI)
                            </h2>
                            <p class="text-base sm:text-lg text-white mb-6">
                                4 Nights Stay in Delhi, Agra & Mathura Tour itinerary with 4-star hotel accommodations
                            </p>
                            <a href="travel-package.html" class="px-6 py-3 border border-white rounded-full text-white font-medium
                    hover:bg-white hover:text-black transition">
                                Learn More
                            </a>
                        </div>
                    </div>



                    <!-- Slide 3 -->
                    <div class="min-w-full relative h-screen sm:h-screen md:h-screen">
                        <img src="assets/images/rangelo-rajasthang.jpg" alt="Accor Hotels"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                            <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white mb-4">
                                RANGEELO RAJASTHAN<br> TOUR PACKAGE
                            </h2>
                            <p class="text-base sm:text-lg text-white mb-6">
                                6 Nights / 7 Days Rajasthan Package Detailed itinerary with 4-star hotel accommodations
                            </p>
                            <a href="travel-package.html" class="px-6 py-3 border border-white rounded-full text-white font-medium
                    hover:bg-white hover:text-black transition">
                                Learn More
                            </a>
                        </div>
                    </div>

                   

                </div>

                <!-- Navigation Dots -->
                <div id="slider-dots"
                    class="flex justify-center gap-2 absolute bottom-6 left-1/2 transform -translate-x-1/2">
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                </div>
            </div>
        </section>

        <!-- International Packages -->
        <section id="work-slider2" class="relative bg-white">
            <div class="relative overflow-hidden">
                <img src="assets/images/international-packages.png" alt="Domestic Packages"
                    class="hidden md:block absolute left-[-132px] top-1/2 -translate-y-1/2 rotate-[-90deg] h-[115px] z-20">
                <!-- Slides Container -->
                <div id="slides2" class="flex transition-transform duration-500">

                    <!-- Slide 1 -->
                    <div class="min-w-full relative h-screen sm:h-screen md:h-screen">
                        <img src="assets/images/bali.png" alt="Accor Hotels"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                            <h2 class="text-3xl sm:text-4xl md:text-7xl font-bold text-white mb-4">
                                Bali Bliss
                            </h2>
                            <p class="text-base sm:text-lg text-white mb-6">
                                4-Star Hotel Stay
                                <br>
                                Island Tours, Water Sports, Turtle Island Visit
                            </p>
                            <a href="travel-package.html" class="px-6 py-3 border border-white rounded-full text-white font-medium
                    hover:bg-white hover:text-black transition">
                                Learn More
                            </a>
                        </div>
                    </div>


                    <!-- Slide 2 -->
                    <div class="min-w-full relative h-screen sm:h-screen md:h-screen">
                        <img src="assets/images/dubai.png" alt="Accor Hotels"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                            <h2 class="text-3xl sm:text-4xl md:text-7xl font-bold text-white mb-4">
                                Dubai Delight
                            </h2>
                            <p class="text-base sm:text-lg text-white mb-6">
                                4-Star Hotel Stay with Breakfast <br>Dubai & Abu Dhabi City Tours, Desert Safari, Burj
                                Khalifa
                            </p>
                            <a href="travel-package.html" class="px-6 py-3 border border-white rounded-full text-white font-medium
                    hover:bg-white hover:text-black transition">
                                Learn More
                            </a>
                        </div>
                    </div>



                    <!-- Slide 3 -->
                    <div class="min-w-full relative h-screen sm:h-screen md:h-screen">
                        <img src="assets/images/vietnam.png" alt="Saudi Tourism Authority"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                            <h2 class="text-3xl sm:text-4xl md:text-7xl font-bold text-white mb-4">
                                Vietnam Escape
                            </h2>
                            <p class="text-base sm:text-lg text-white mb-6">
                                4-Star Hotel Stay
                                <br>
                                Itinerary covering Hanoi, Halong Bay & Turtle Island
                            </p>
                            <a href="travel-package.html" class="px-6 py-3 border border-white rounded-full text-white font-medium
                    hover:bg-white hover:text-black transition">
                                Learn More
                            </a>
                        </div>
                    </div>



                </div>

                <!-- Navigation Dots -->
                <div id="slider-dots2"
                    class="flex justify-center gap-2 absolute bottom-6 left-1/2 transform -translate-x-1/2">
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
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
                            Discover New Destinations,Create Lasting Memories!
                        </h2>
                        <p class="mt-3 text-black-600 text-lg text-center">
                            Join our travel community and explore breathtaking locations,
                            tailored packages, and unforgettable experiences across the globe.
                        </p>
                    </div>

                    <!-- CTA Button -->
                    <div class="flex justify-start md:justify-center">
                        <a href="contact.html" class="inline-block px-6 py-3 rounded-xl font-semibold text-white 
                  bg-gradient-to-r from-[#1ec700] via-[#1ec700] to-[#e11d48] 
                  shadow-lg hover:scale-105 hover:shadow-xl 
                  transition-all duration-300" style="border-radius: 35px;">
                            Start Your Journey
                        </a>
                    </div>

                </div>
            </div>
        </section>
        <!-- CTA Box Section End -->
        <!-- New Services Section with Video Background and Cards -->
        <section class="relative w-full overflow-hidden flex items-center justify-center" style="padding:70px 0px;">
            <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="assets/videos/clients.mp4" type="video/mp4">
                Your browser doesn’t support video.
            </video>
            <div class="absolute inset-0 bg-black bg-opacity-80"></div>
            <div class="relative z-10 flex flex-col items-center justify-center h-full px-4 py-3">
                <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-10 drop-shadow-lg text-center">
                    Exclusive Solutions Crafted for You</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full max-w-6xl">
                    <div class="service-card bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
                        style="border-bottom: 5px solid green;">
                        <div class="service-content flex flex-col items-center">
                            <img src="assets/images/currency.png" alt="Service 5" class="h-10 w-10 mb-4">
                            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">Currency Change Assistance
                            </h3>
                            <p class="text-gray-700 text-center text-base">Simplify your journey with our currency
                                change assistance. Upon request, contact for details</p>
                        </div>
                    </div>
                    <div class="service-card bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
                        style="border-bottom: 5px solid green;">
                        <div class="service-content flex flex-col items-center">
                            <img src="assets/images/travel.png" alt="Service 1" class="h-10 w-10 mb-4">
                            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">Planning around your
                                preference</h3>
                            <p class="text-gray-700 text-center text-base">Streamlined visa processing for teams and
                                families, ensuring smooth, timely travel for every member.</p>
                        </div>
                    </div>
                    <div class="service-card bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
                        style="border-bottom: 5px solid green;">
                        <div class="service-content flex flex-col items-center">
                            <img src="assets/images/vip.png" alt="Service 4" class="h-10 w-10 mb-4">
                            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">VIP<br> Concierge </h3>
                            <p class="text-gray-700 text-center text-base">Personalized 24/7 one-message support crafted
                                exclusively for elite travelers on constant journeys.</p>
                        </div>
                    </div>
                    <div class="service-card bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300"
                        style="border-bottom: 5px solid green;">
                        <div class="service-content flex flex-col items-center">
                            <img src="assets/images/visa.png" alt="Service 2" class="h-10 w-10 mb-4">
                            <h3 class="text-xl text-center font-semibold text-[#000] mb-2">VISA<br> made EASY</h3>
                            <p class="text-gray-700 text-center text-base">Personal travel concierge for flights,
                                hotels, visas, and beyond—crafting seamless journeys across the globe</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="reviews" style="padding:100px 0px; text-align: center;">
            <div class="container">
                <div>
                    <h2 class="text-2xl md:text-3xl text-center font-bold text-gray-800 leading-snug">
                        Trusted by Travelers Across the Globe!
                    </h2>
                </div>

                <div class="testimonial-slider ">
                    <div class="testimonial-track">
                        <!-- Testimonials inserted by JS -->
                    </div>
                </div>
            </div>
        </section>


        <!-- Partner Logos Marquee Section -->
        <section class="relative h-[60vh] sm:h-[70vh] md:h-[80vh] w-full overflow-hidden">
            <!-- Video Background -->
            <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="assets/videos/testimonial.mp4" type="video/mp4">
                Your browser doesn’t support video.
            </video>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            <!-- Marquee + Text Container -->
            <div class="relative z-10 flex flex-col items-center justify-center h-full px-4">
                <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-10 drop-shadow-lg text-center">
                    Glimpse of Our Client’s</h2>
                <!-- Logos Marquee Wrapper -->
                <div class="w-full overflow-hidden">
                    <div class="flex items-center space-x-8 animate-marquee">
                        <!-- First set of logos -->
                        <img src="assets/images/fastkeys.png" alt="Award 1"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/il-fs.jpg" alt="Award 2"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/c1-india.png" alt="Award 3"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/elisra.jpg" alt="Award 4"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/cinevesture.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/koreanembassy.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/pathways.jpeg.jpg" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/slashproduction.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/nfdc.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/sa-infrastructure.jpg" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/tulsiani.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/sm-air.jpeg.jpg" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/polyplastic.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <!-- Repeat the same logos for seamless loop -->
                        <img src="assets/images/fastkeys.png" alt="Award 1"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/il-fs.jpg" alt="Award 2"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/c1-india.png" alt="Award 3"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/elisra.jpg" alt="Award 4"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/cinevesture.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/koreanembassy.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/pathways.jpeg.jpg" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/slashproduction.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/nfdc.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/sa-infrastructure.jpg" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/tulsiani.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/sm-air.jpeg.jpg" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                        <img src="assets/images/polyplastic.png" alt="Award 5"
                            class="h-12 sm:h-16 md:h-20 object-contain bg-white">
                    </div>
                </div>

                <!-- Descriptive Text -->
                <p class="mt-8 max-w-3xl text-center text-white text-base sm:text-lg md:text-xl">
                    We are a multi-award-winning agency specializing in luxury travel experiences for families and
                    groups. With one of the world’s largest and most influential travel communities, we offer bespoke
                    trips to both domestic destinations like Rajasthan, Goa, Leh, and the Andamans, as well as
                    international escapes to Bali, Vietnam, Europe, Canada, and beyond. Our community of passionate
                    travelers shares a love for unique, unforgettable journeys, and we invite you to be part of it. Let
                    us craft your perfect getaway, tailored to your dreams and desires.
                </p>
            </div>
        </section>

        <!-- Tour & Travel + Visa Services SEO Content Block -->
        <section class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-gray-50 rounded-2xl shadow p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Tour &amp; Travel Packages in Hyderabad &amp; Bangalore</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        As a trusted travel agency serving Hyderabad, Bangalore and travelers across India, we design
                        domestic tour packages to Goa, Rajasthan, Kerala and the Golden Triangle, as well as
                        international tour packages to Dubai, Bali, Vietnam, Europe and beyond — with custom holiday
                        itineraries for families, couples and groups.
                    </p>
                    <a href="travel-package.php" class="inline-block px-5 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48]">
                        Explore Tour Packages
                    </a>
                </div>
                <div class="bg-gray-50 rounded-2xl shadow p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Visa Services in Hyderabad &amp; Bangalore</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Our visa consultants help applicants from Hyderabad, Bangalore and across India with tourist and
                        business visa services for the USA, UK, Canada, Europe (Schengen), Australia, Japan, Singapore
                        and UAE/Dubai — including documentation support, application filing and interview preparation.
                    </p>
                    <a href="visa-services.php" class="inline-block px-5 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48]">
                        Explore Visa Services
                    </a>
                </div>
            </div>
        </section>

        <?php include('footer.php') ?>



    </main>

    <!-- Load JS (which will inject the header) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<script src="<?=$site?>public/assets/js/main.js"></script>
</body>

</html>