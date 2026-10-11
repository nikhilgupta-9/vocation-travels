<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();
$meta_title = 'Vocation Travels – Tour Packages & Visa Services Across India (Delhi, Mumbai, Bangalore, Hyderabad & 40+ Cities)';
$meta_description = 'Vocation Travels provides bespoke holiday packages and trusted visa consultancy across 40+ cities in India and globally. Expert processing for USA, UK, Canada, Schengen Europe, Australia, Japan, Dubai & more.';
$meta_keywords = ['tour and travel packages India', 'travel agency Delhi', 'travel agency Mumbai', 'travel agency Bangalore', 'travel agency Hyderabad', 'visa consultants India', 'domestic tour packages', 'international tour packages', 'Schengen visa agent India', 'USA visa consultant', 'Canada visa Bangalore', 'holiday packages 2026', 'luxury travel concierge India'];
$canonical_path = '';

// Structured Data (JSON-LD) for LocalBusiness & TravelAgency
$structured_data = [
    "@context" => "https://schema.org",
    "@type" => "TravelAgency",
    "name" => $contact['company_name'] ?? "VOCATION TRAVELS AND TOURS PRIVATE LIMITED",
    "url" => $site,
    "logo" => $site . "assets/images/logo.png",
    "image" => $site . "assets/images/luxury_travel_hero.jpg",
    "description" => $meta_description,
    "telephone" => "+91-" . ($contact['phone'] ?? "9999447373"),
    "email" => $contact['email'] ?? "visa@vocationtravels.com",
    "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => $contact['address'] ?? "Room No. 309, 3rd Floor, Transport Authority Building, District Centre, Near Janakpuri Police Station, Janakpuri",
        "addressLocality" => "New Delhi",
        "postalCode" => "110058",
        "addressCountry" => "IN"
    ],
    "areaServed" => [
        ["@type" => "Country", "name" => "India"],
        ["@type" => "City", "name" => "Delhi"],
        ["@type" => "City", "name" => "Mumbai"],
        ["@type" => "City", "name" => "Bangalore"],
        ["@type" => "City", "name" => "Hyderabad"],
        ["@type" => "City", "name" => "Chennai"],
        ["@type" => "City", "name" => "Kolkata"],
        ["@type" => "City", "name" => "Pune"],
        ["@type" => "City", "name" => "Ahmedabad"],
        ["@type" => "City", "name" => "Jaipur"],
        ["@type" => "City", "name" => "Chandigarh"],
        ["@type" => "City", "name" => "Lucknow"],
        ["@type" => "City", "name" => "Kochi"]
    ],
    "sameAs" => [
        "https://share.google/EzOt9py4AbwOfVnO1",
        "https://www.instagram.com/vocationtravels/",
        "https://www.facebook.com/share/1ZXsmimYf7/?mibextid=wwXIfr",
        "https://www.linkedin.com/company/vocationtravels/"
    ],
    "priceRange" => "$$"
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('seo-meta.php') ?>
    <title><?= htmlspecialchars($meta_title) ?></title>
    <?php include('link.php') ?>
    <script type="application/ld+json"><?= json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

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
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-8px);
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

<body class="relative flex flex-col min-h-screen bg-neutral-950 text-gray-100 font-sans">

    <?php include('header.php') ?>

    <!-- Main Content -->
    <main class="flex-grow">

        <!-- Hero Section -->
        <section class="relative h-screen min-h-[600px] w-full overflow-hidden flex items-center justify-center">
            <video id="hero-video" class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline preload="auto">
                <source src="<?= $site ?>assets/videos/hero-banner.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-5xl mx-auto pt-16">
                <!-- Trust Badge -->
                <div class="inline-flex items-center space-x-2 py-1.5 px-4 mb-6 rounded-full bg-white/10 backdrop-blur-md text-white text-xs sm:text-sm font-medium border border-white/20 shadow-lg">
                    <span class="w-2 h-2 rounded-full bg-[#1ec700] animate-pulse"></span>
                    <span>Premier Travel &amp; Visa Consultancy Across India &amp; Worldwide</span>
                </div>

                <h1 class="text-white font-extrabold leading-tight text-3xl sm:text-5xl md:text-6xl lg:text-7xl mb-6 drop-shadow-2xl max-w-4xl">
                    Curated Tour Packages &amp; <span class="bg-gradient-to-r from-[#1ec700] via-emerald-400 to-[#e11d48] text-transparent bg-clip-text">Visa Solutions</span> for the Extraordinary.
                </h1>

                <p class="text-gray-200 text-base sm:text-xl max-w-2xl mb-8 font-light leading-relaxed">
                    Customized Tour Packages, Guaranteed Visa Filing Support Across 40+ Indian Cities &amp; 24/7 VIP Concierge.
                </p>

                <div class="flex flex-wrap gap-4 justify-center items-center">
                    <a href="<?= $site ?>travel-package/" class="px-8 py-3.5 rounded-full font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 hover:shadow-2xl transition duration-200 shadow-xl text-sm sm:text-base">
                        Explore Holiday Packages
                    </a>
                    <a href="<?= $site ?>visa-services/" class="px-8 py-3.5 rounded-full font-bold text-white bg-white/15 backdrop-blur-md border border-white/30 hover:bg-white hover:text-black transition duration-200 text-sm sm:text-base">
                        Visa Services (40+ Cities)
                    </a>
                </div>
            </div>
        </section>

        <!-- Trust & Value Metrics Strip -->
        <section class="bg-neutral-900 border-y border-white/10 text-white py-6">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="border-r border-white/10 last:border-none px-2">
                    <div class="text-2xl sm:text-3xl font-extrabold text-[#1ec700]">40+ Cities</div>
                    <div class="text-xs sm:text-sm text-gray-400 mt-1">Pan-India Visa Assistance</div>
                </div>
                <div class="border-r border-white/10 last:border-none px-2">
                    <div class="text-2xl sm:text-3xl font-extrabold text-[#e11d48]">98.7%</div>
                    <div class="text-xs sm:text-sm text-gray-400 mt-1">Application Accuracy</div>
                </div>
                <div class="border-r border-white/10 last:border-none px-2">
                    <div class="text-2xl sm:text-3xl font-extrabold text-[#1ec700]">500+</div>
                    <div class="text-xs sm:text-sm text-gray-400 mt-1">Bespoke Holiday Itineraries</div>
                </div>
                <div class="px-2">
                    <div class="text-2xl sm:text-3xl font-extrabold text-amber-400">24/7</div>
                    <div class="text-xs sm:text-sm text-gray-400 mt-1">VIP Concierge Care</div>
                </div>
            </div>
        </section>

        <!-- Domestic Packages Slider -->
        <section id="work-slider" class="relative bg-neutral-950">
            <div class="relative overflow-hidden">
                <!-- Rotated Domestic Packages Label -->
                <img src="<?= $site ?>assets/images/domestic-packages.png" alt="Domestic Packages"
                    class="hidden md:block absolute left-[-132px] top-1/2 -translate-y-1/2 rotate-[-90deg] h-[115px] z-20 opacity-80">
                
                <!-- Slides Container -->
                <div id="slides" class="flex transition-transform duration-500">
                    <!-- Slide 1 -->
                    <div class="min-w-full relative h-screen">
                        <img src="<?= $site ?>assets/images/goa-fun-fiesta.jpg" alt="Goa Tour Package"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto">
                            <span class="px-3.5 py-1 rounded-full bg-emerald-500/90 text-white text-xs font-bold uppercase tracking-wider mb-3">Popular Domestic</span>
                            <h2 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white mb-4">
                                GOA FUN FIESTA PACKAGE
                            </h2>
                            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl">
                                5 Nights / 6 Days Goa Beach Package includes luxury resort stay, water sports &amp; sunset cruises.
                            </p>
                            <a href="<?= $site ?>travel-package/" class="px-7 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition">
                                View Itinerary &amp; Details
                            </a>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="min-w-full relative h-screen">
                        <img src="<?= $site ?>assets/images/Delhi-Agra-Mathura-Tour-Itinerary.jpg" alt="Golden Triangle Tour"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto">
                            <span class="px-3.5 py-1 rounded-full bg-emerald-500/90 text-white text-xs font-bold uppercase tracking-wider mb-3">Heritage Special</span>
                            <h2 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white mb-4">
                                GOLDEN TRIANGLE PACKAGE
                            </h2>
                            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl">
                                4 Nights Stay in Delhi, Agra &amp; Mathura with private chauffeur, monuments guide &amp; 4-star hotels.
                            </p>
                            <a href="<?= $site ?>travel-package/" class="px-7 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition">
                                View Itinerary &amp; Details
                            </a>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="min-w-full relative h-screen">
                        <img src="<?= $site ?>assets/images/rangelo-rajasthang.jpg" alt="Rajasthan Tour"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto">
                            <span class="px-3.5 py-1 rounded-full bg-emerald-500/90 text-white text-xs font-bold uppercase tracking-wider mb-3">Royal Heritage</span>
                            <h2 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white mb-4">
                                RANGEELO RAJASTHAN TOUR
                            </h2>
                            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl">
                                6 Nights / 7 Days exploring Jaipur, Jodhpur &amp; Udaipur with royal heritage palace stays.
                            </p>
                            <a href="<?= $site ?>travel-package/" class="px-7 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition">
                                View Itinerary &amp; Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigation Dots -->
                <div id="slider-dots" class="flex justify-center gap-2 absolute bottom-6 left-1/2 transform -translate-x-1/2">
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                </div>
            </div>
        </section>

        <!-- International Packages Slider -->
        <section id="work-slider2" class="relative bg-neutral-950">
            <div class="relative overflow-hidden">
                <img src="<?= $site ?>assets/images/international-packages.png" alt="International Packages"
                    class="hidden md:block absolute left-[-132px] top-1/2 -translate-y-1/2 rotate-[-90deg] h-[115px] z-20 opacity-80">
                
                <!-- Slides Container -->
                <div id="slides2" class="flex transition-transform duration-500">
                    <!-- Slide 1 -->
                    <div class="min-w-full relative h-screen">
                        <img src="<?= $site ?>assets/images/bali.png" alt="Bali Bliss" class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto">
                            <span class="px-3.5 py-1 rounded-full bg-[#e11d48]/90 text-white text-xs font-bold uppercase tracking-wider mb-3">Top International</span>
                            <h2 class="text-3xl sm:text-5xl md:text-7xl font-extrabold text-white mb-4">Bali Bliss</h2>
                            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl">
                                4-Star Resort Stay, Island Tours, Water Sports &amp; Private Turtle Island Excursions.
                            </p>
                            <a href="<?= $site ?>travel-package/" class="px-7 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition">
                                Discover Package
                            </a>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="min-w-full relative h-screen">
                        <img src="<?= $site ?>assets/images/dubai.png" alt="Dubai Delight" class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto">
                            <span class="px-3.5 py-1 rounded-full bg-[#e11d48]/90 text-white text-xs font-bold uppercase tracking-wider mb-3">Luxury City</span>
                            <h2 class="text-3xl sm:text-5xl md:text-7xl font-extrabold text-white mb-4">Dubai Delight</h2>
                            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl">
                                4-Star Hotel Stay with Breakfast, Desert Safari, Burj Khalifa At The Top &amp; Abu Dhabi Tour.
                            </p>
                            <a href="<?= $site ?>travel-package/" class="px-7 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition">
                                Discover Package
                            </a>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="min-w-full relative h-screen">
                        <img src="<?= $site ?>assets/images/vietnam.png" alt="Vietnam Escape" class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto">
                            <span class="px-3.5 py-1 rounded-full bg-[#e11d48]/90 text-white text-xs font-bold uppercase tracking-wider mb-3">Scenic Adventure</span>
                            <h2 class="text-3xl sm:text-5xl md:text-7xl font-extrabold text-white mb-4">Vietnam Escape</h2>
                            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl">
                                Itinerary covering Hanoi, Halong Bay Overnight Cruise &amp; Ninh Binh with premium stays.
                            </p>
                            <a href="<?= $site ?>travel-package/" class="px-7 py-3 border border-white rounded-full text-white font-medium hover:bg-white hover:text-black transition">
                                Discover Package
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigation Dots -->
                <div id="slider-dots2" class="flex justify-center gap-2 absolute bottom-6 left-1/2 transform -translate-x-1/2">
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                </div>
            </div>
        </section>

        <!-- Exclusive Solutions Crafted For You (Modern Photo Cards) -->
        <section class="relative w-full overflow-hidden flex items-center justify-center py-20 bg-neutral-900 border-y border-white/10">
            <video class="absolute inset-0 w-full h-full object-cover opacity-20" autoplay muted loop playsinline>
                <source src="<?= $site ?>assets/videos/clients.mp4" type="video/mp4">
            </video>
            <div class="relative z-10 flex flex-col items-center justify-center h-full px-4 max-w-7xl mx-auto">
                <span class="text-xs uppercase tracking-widest text-[#1ec700] font-bold mb-2">Tailored Travel Excellence</span>
                <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg text-center">
                    Exclusive Travel &amp; Visa Solutions
                </h2>
                <p class="text-gray-300 text-center max-w-2xl text-sm sm:text-base mb-12">
                    From hassle-free visa approvals in 40+ Indian cities to bespoke luxury tour itineraries and 24/7 VIP concierge handling.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                    <!-- Card 1: Visa Assistance -->
                    <div class="service-card group bg-neutral-950/90 rounded-2xl overflow-hidden shadow-2xl border border-white/10 hover:border-[#1ec700] flex flex-col">
                        <div class="h-44 overflow-hidden relative">
                            <img src="<?= $site ?>assets/images/visa_consultant_pro.jpg" alt="Visa Assistance Across India" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-[#1ec700]/90 text-white text-[11px] font-bold">40+ Cities</span>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-[#1ec700] transition">Visa Services &amp; Filing</h3>
                            <p class="text-gray-400 text-xs leading-relaxed mb-4 flex-grow">
                                End-to-end documentation, slot booking, and interview preparation for USA, UK, Canada, Schengen, and Australia visas.
                            </p>
                            <a href="<?= $site ?>visa-services/" class="text-xs font-semibold text-white inline-flex items-center space-x-1 hover:text-[#1ec700]">
                                <span>Explore Visa Services</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: VIP Concierge -->
                    <div class="service-card group bg-neutral-950/90 rounded-2xl overflow-hidden shadow-2xl border border-white/10 hover:border-[#e11d48] flex flex-col">
                        <div class="h-44 overflow-hidden relative">
                            <img src="<?= $site ?>assets/images/vip_concierge_luxury.jpg" alt="VIP Concierge" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-[#e11d48]/90 text-white text-[11px] font-bold">24/7 Dedicated</span>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-[#e11d48] transition">VIP Concierge &amp; Jets</h3>
                            <p class="text-gray-400 text-xs leading-relaxed mb-4 flex-grow">
                                Personalized 24/7 one-message support, tarmac assistance, luxury transfers, and bespoke services for elite travelers.
                            </p>
                            <a href="<?= $site ?>vip-concierge/" class="text-xs font-semibold text-white inline-flex items-center space-x-1 hover:text-[#e11d48]">
                                <span>Discover VIP Concierge</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Curated World Packages -->
                    <div class="service-card group bg-neutral-950/90 rounded-2xl overflow-hidden shadow-2xl border border-white/10 hover:border-amber-400 flex flex-col">
                        <div class="h-44 overflow-hidden relative">
                            <img src="<?= $site ?>assets/images/world_tour_destinations.jpg" alt="Curated Packages" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-amber-500/90 text-white text-[11px] font-bold">Domestic &amp; Intl</span>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-amber-400 transition">Curated Tour Packages</h3>
                            <p class="text-gray-400 text-xs leading-relaxed mb-4 flex-grow">
                                Handcrafted holiday itineraries to Dubai, Bali, Vietnam, Rajasthan, Goa, and Europe with top 4-star &amp; 5-star stays.
                            </p>
                            <a href="<?= $site ?>travel-package/" class="text-xs font-semibold text-white inline-flex items-center space-x-1 hover:text-amber-400">
                                <span>Browse Tour Packages</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 4: Luxury Experience & Forex -->
                    <div class="service-card group bg-neutral-950/90 rounded-2xl overflow-hidden shadow-2xl border border-white/10 hover:border-blue-400 flex flex-col">
                        <div class="h-44 overflow-hidden relative">
                            <img src="<?= $site ?>assets/images/luxury_travel_hero.jpg" alt="Luxury Travel Planning" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-blue-500/90 text-white text-[11px] font-bold">End-to-End</span>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-blue-400 transition">Forex &amp; Custom Trips</h3>
                            <p class="text-gray-400 text-xs leading-relaxed mb-4 flex-grow">
                                International currency assistance, multi-city airline booking, private charters, and tailored corporate group trips.
                            </p>
                            <a href="<?= $site ?>services/" class="text-xs font-semibold text-white inline-flex items-center space-x-1 hover:text-blue-400">
                                <span>View All Services</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partner Logos Marquee Section -->
        <section class="relative py-16 w-full overflow-hidden bg-neutral-950 border-b border-white/10">
            <div class="relative z-10 flex flex-col items-center justify-center px-4 max-w-7xl mx-auto">
                <span class="text-xs uppercase tracking-widest text-[#e11d48] font-bold mb-2">Corporate &amp; Global Trust</span>
                <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold mb-8 text-center">
                    Trusted by Reputed Organizations &amp; Travelers
                </h2>
                <!-- Logos Marquee Wrapper -->
                <div class="w-full overflow-hidden">
                    <div class="flex items-center space-x-8 animate-marquee">
                        <img src="<?= $site ?>assets/images/fastkeys.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/il-fs.jpg" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/c1-india.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/elisra.jpg" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/cinevesture.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/koreanembassy.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/nfdc.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/polyplastic.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/fastkeys.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/il-fs.jpg" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/c1-india.png" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                        <img src="<?= $site ?>assets/images/elisra.jpg" alt="Client Logo" class="h-10 sm:h-12 object-contain bg-white/90 p-2 rounded-lg">
                    </div>
                </div>
            </div>
        </section>

        <!-- Pan-India SEO Section (All Big and Small Cities) -->
        <section class="py-16 bg-neutral-900 border-b border-white/10">
            <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-neutral-950 rounded-2xl p-8 border border-white/10 shadow-xl">
                    <div class="inline-flex items-center space-x-2 text-[#1ec700] text-xs font-bold uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span>Nationwide Reach</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-3">Holiday Tour Packages Across India &amp; Worldwide</h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        As a premier travel agency serving travelers across India — from Delhi NCR, Mumbai, Bengaluru and Hyderabad to Jaipur, Ahmedabad, Pune, Chandigarh, Kochi and beyond — we curate tailor-made domestic holiday packages (Goa, Rajasthan, Kerala, Golden Triangle, Kashmir) and exotic international tours (Dubai, Bali, Vietnam, Europe, Thailand, Maldives) with 4-star and 5-star accommodations.
                    </p>
                    <a href="<?= $site ?>travel-package/" class="inline-block px-5 py-2.5 rounded-full text-xs font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition">
                        Explore Holiday Packages
                    </a>
                    <div class="mt-4 pt-4 border-t border-white/10 text-xs text-gray-400">
                        <span class="font-semibold text-gray-300">Trending Packages: </span>
                        <a href="<?= $site ?>package/kashmir-paradise-tour/" class="hover:text-emerald-400 underline">Kashmir (5N/6D)</a>,
                        <a href="<?= $site ?>package/himachal-hill-stations/" class="hover:text-emerald-400 underline">Himachal (5N/6D)</a>,
                        <a href="<?= $site ?>package/vaishno-devi-kashmir-tour/" class="hover:text-emerald-400 underline">Vaishno Devi</a>,
                        <a href="<?= $site ?>package/kerala-luxury-retreat/" class="hover:text-emerald-400 underline">Kerala Retreat</a>,
                        <a href="<?= $site ?>package/ladakh-high-altitude-expedition/" class="hover:text-emerald-400 underline">Ladakh</a>,
                        <a href="<?= $site ?>package/golden-triangle-package/" class="hover:text-emerald-400 underline">Golden Triangle</a>.
                    </div>
                </div>

                <div class="bg-neutral-950 rounded-2xl p-8 border border-white/10 shadow-xl">
                    <div class="inline-flex items-center space-x-2 text-[#e11d48] text-xs font-bold uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-passport"></i>
                        <span>Pan-India Visa Expertise</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-3">Visa Consultants Across 40+ Indian Cities</h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Our seasoned visa consultants provide end-to-end documentation, appointment scheduling, mock interviews, and application filing for tourist, student, business, and PR tracks across 40+ Indian cities. Covering top destinations: USA, UK, Canada, Europe (Schengen), Australia, Japan, Singapore, UAE and more.
                    </p>
                    <a href="<?= $site ?>visa-services/" class="inline-block px-5 py-2.5 rounded-full text-xs font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition">
                        Explore Visa Services
                    </a>
                    <div class="mt-4 pt-4 border-t border-white/10 text-xs text-gray-400">
                        <span class="font-semibold text-gray-300">Popular hubs: </span>
                        <a href="<?= $site ?>visa-consultants-delhi/" class="hover:text-emerald-400 underline">Delhi NCR</a>,
                        <a href="<?= $site ?>visa-consultants-mumbai/" class="hover:text-emerald-400 underline">Mumbai</a>,
                        <a href="<?= $site ?>visa-consultants-bangalore/" class="hover:text-emerald-400 underline">Bangalore</a>,
                        <a href="<?= $site ?>visa-consultants-hyderabad/" class="hover:text-emerald-400 underline">Hyderabad</a>,
                        <a href="<?= $site ?>visa-consultants-pune/" class="hover:text-emerald-400 underline">Pune</a>,
                        <a href="<?= $site ?>visa-consultants-chennai/" class="hover:text-emerald-400 underline">Chennai</a>,
                        <a href="<?= $site ?>visa-consultants-ahmedabad/" class="hover:text-emerald-400 underline">Ahmedabad</a>,
                        <a href="<?= $site ?>visa-consultants-kolkata/" class="hover:text-emerald-400 underline">Kolkata</a>,
                        <a href="<?= $site ?>visa-consultants-jaipur/" class="hover:text-emerald-400 underline">Jaipur</a>,
                        <a href="<?= $site ?>visa-consultants-chandigarh/" class="hover:text-emerald-400 underline">Chandigarh</a> &amp; 30+ more.
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Box with Boat Video Background -->
        <section class="relative min-h-[550px] sm:min-h-[650px] py-28 sm:py-36 md:py-40 overflow-hidden flex items-center justify-center border-b border-white/10">
            <!-- Boat Video Background -->
            <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline preload="auto">
                <source src="<?= $site ?>assets/videos/testimonial.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/60"></div>

            <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white mb-4 drop-shadow-2xl">
                    Discover New Destinations, Create Lasting Memories!
                </h2>
                <p class="text-gray-200 text-sm sm:text-base max-w-2xl mx-auto mb-8 font-light drop-shadow">
                    Join our premier travel community. Get personalized vacation quotes or instant visa guidance from our experts today.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?= $site ?>contact/#contactform" class="px-8 py-3 rounded-full text-sm font-bold text-white bg-gradient-to-r from-[#1ec700] to-[#e11d48] hover:scale-105 transition shadow-2xl">
                        Plan My Trip Now
                    </a>
                    <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $contact['wp_number'] ?? '7982938239') ?>?text=Hi%20Vocation%20Travels,%20I%20want%20to%20plan%20a%20vacation" target="_blank" rel="noopener"
                        class="px-8 py-3 rounded-full text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 transition shadow-2xl flex items-center space-x-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>WhatsApp Specialist</span>
                    </a>
                </div>
            </div>
        </section>

        <?php include('footer.php') ?>

    </main>

    <!-- Load Scripts -->
    <script src="<?= $site ?>assets/js/gsap.min.js"></script>
    <script src="<?= $site ?>assets/js/ScrollTrigger.min.js"></script>
    <script src="<?= $site ?>assets/js/main.js"></script>
</body>

</html>
