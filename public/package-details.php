<?php
include_once __DIR__ . "/../config/connect.php";
include_once __DIR__ . "/../util/function.php";

$contact = contact_us();

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$slug = preg_replace('/[^a-zA-Z0-9-]/', '', $slug);

if (empty($slug)) {
    header("Location: " . $site . "travel-package/");
    exit;
}

// Fetch package from database
$stmt = $conn->prepare("SELECT * FROM packages WHERE slug = ? AND status = 1 LIMIT 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$package) {
    // Fallback search by ID if numeric passed
    if (is_numeric($slug)) {
        $pkg_id = (int)$slug;
        $stmt2 = $conn->prepare("SELECT * FROM packages WHERE id = ? AND status = 1 LIMIT 1");
        $stmt2->bind_param("i", $pkg_id);
        $stmt2->execute();
        $package = $stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        if ($package && !empty($package['slug'])) {
            header("Location: " . $site . "package/" . $package['slug'] . "/", true, 301);
            exit;
        }
    }
    
    if (!$package) {
        header("Location: " . $site . "travel-package/");
        exit;
    }
}

$id = (int)$package['id'];

// Fetch related package data
$highlights = [];
$res_hl = $conn->query("SELECT highlight FROM package_highlights WHERE package_id = $id ORDER BY display_order ASC, id ASC");
if ($res_hl) while ($r = $res_hl->fetch_assoc()) $highlights[] = $r['highlight'];

$inclusions = [];
$res_inc = $conn->query("SELECT inclusion FROM package_inclusions WHERE package_id = $id ORDER BY display_order ASC, id ASC");
if ($res_inc) while ($r = $res_inc->fetch_assoc()) $inclusions[] = $r['inclusion'];

$itinerary = [];
$res_itin = $conn->query("SELECT day_number, title, description FROM package_itinerary WHERE package_id = $id ORDER BY day_number ASC, display_order ASC");
if ($res_itin) while ($r = $res_itin->fetch_assoc()) $itinerary[] = $r;

$notes = [];
$res_notes = $conn->query("SELECT note FROM package_notes WHERE package_id = $id ORDER BY display_order ASC, id ASC");
if ($res_notes) while ($r = $res_notes->fetch_assoc()) $notes[] = $r['note'];

// Fetch other recommended packages
$other_packages = [];
$res_other = $conn->query("SELECT id, title, slug, duration, price, image, suitable_for FROM packages WHERE id != $id AND status = 1 ORDER BY RAND() LIMIT 3");
if ($res_other) while ($r = $res_other->fetch_assoc()) $other_packages[] = $r;

// SEO Metadata Configuration
$meta_title = htmlspecialchars($package['title']) . ' (' . htmlspecialchars($package['duration']) . ') Tour Package | Vocation Travels';
$desc_clean = !empty($package['short_description']) ? strip_tags($package['short_description']) : "Explore our exclusive {$package['title']} tour package with premium stays, private sightseeing, guided tours & 24/7 concierge support.";
$meta_description = mb_substr($desc_clean, 0, 155);
$meta_keywords = [
    $package['title'],
    $package['title'] . ' tour package',
    $package['title'] . ' holiday package',
    $package['type'] . ' tour packages India',
    'luxury holiday itinerary ' . $package['duration'],
    'vocation travels tour packages'
];
$canonical_path = 'package/' . $package['slug'] . '/';
$og_image = !empty($package['image']) ? $site . $package['image'] : $site . 'assets/images/luxury_travel_hero.jpg';

// Schema.org Structured Data (TouristTrip + Product + BreadcrumbList)
$schema_itinerary = [];
foreach ($itinerary as $day) {
    $schema_itinerary[] = [
        '@type' => 'Day',
        'name' => 'Day ' . $day['day_number'] . ': ' . $day['title'],
        'description' => strip_tags($day['description'])
    ];
}

$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'TouristTrip',
            'name' => $package['title'],
            'description' => $meta_description,
            'touristType' => $package['suitable_for'] ?: 'Family, Couples, Luxury Travelers',
            'offers' => [
                '@type' => 'Offer',
                'price' => (float)$package['price'],
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock',
                'url' => $site . 'package/' . $package['slug'] . '/',
                'validFrom' => date('Y-01-01')
            ],
            'itinerary' => [
                '@type' => 'ItemList',
                'itemListElement' => $schema_itinerary
            ],
            'provider' => [
                '@type' => 'TravelAgency',
                'name' => $contact['company_name'] ?? 'Vocation Travels And Tours',
                'telephone' => $contact['phone'] ?? '9999447373',
                'url' => $site
            ]
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Tour Packages', 'item' => $site . 'travel-package/'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $package['title'], 'item' => $site . 'package/' . $package['slug'] . '/']
            ]
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta_title) ?></title>
    <?php include('link.php'); ?>
    <?php include('seo-meta.php'); ?>

    <script type="application/ld+json">
        <?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>

    <style>
        .itinerary-timeline {
            position: relative;
            padding-left: 2rem;
        }
        .itinerary-timeline::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 1rem;
            bottom: 1rem;
            width: 2px;
            background: #e2e8f0;
        }
        .itinerary-dot {
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #dc2626);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.75rem;
            font-weight: bold;
            box-shadow: 0 0 0 4px #f8fafc;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">
    <?php include('header.php'); ?>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative bg-neutral-950 text-white py-20 lg:py-28 overflow-hidden">
            <?php $bg_img = !empty($package['image']) ? $site . $package['image'] : $site . 'assets/images/luxury_travel_hero.jpg'; ?>
            <div class="absolute inset-0 z-0">
                <img src="<?= htmlspecialchars($bg_img) ?>" alt="<?= htmlspecialchars($package['title']) ?>" class="w-full h-full object-cover opacity-35 filter brightness-75 scale-105 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/60 to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-sm text-slate-300 mb-6" aria-label="Breadcrumb">
                    <a href="<?= $site ?>" class="hover:text-white transition">Home</a>
                    <span class="text-slate-500">/</span>
                    <a href="<?= $site ?>travel-package/" class="hover:text-white transition">Tour Packages</a>
                    <span class="text-slate-500">/</span>
                    <span class="text-emerald-400 font-medium truncate max-w-xs sm:max-w-md"><?= htmlspecialchars($package['title']) ?></span>
                </nav>

                <div class="max-w-3xl">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-emerald-600/90 text-white">
                            <?= htmlspecialchars(ucfirst($package['type'])) ?> Tour
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-slate-200 border border-white/20">
                            <i class="far fa-clock me-1"></i> <?= htmlspecialchars($package['duration']) ?>
                        </span>
                        <?php if (!empty($package['suitable_for'])): ?>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-slate-200 border border-white/20">
                                <i class="fas fa-users me-1"></i> <?= htmlspecialchars($package['suitable_for']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4">
                        <?= htmlspecialchars($package['title']) ?>
                    </h1>

                    <p class="text-lg text-slate-200 leading-relaxed mb-6 font-light">
                        <?= !empty($package['short_description']) ? htmlspecialchars($package['short_description']) : 'Curated premium itinerary featuring five-star accommodations, chauffeur-driven transfers, and private guided sightseeing.' ?>
                    </p>

                    <div class="flex flex-wrap items-baseline gap-4 pt-2 border-t border-white/10">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-slate-400 block">Starting From</span>
                            <span class="text-3xl font-black text-emerald-400">$<?= number_format($package['price'], 0) ?></span>
                            <span class="text-xs text-slate-300">USD* / Package</span>
                        </div>
                        <?php if (!empty($package['price_note'])): ?>
                            <span class="text-xs text-slate-400 self-end mb-1"><?= htmlspecialchars($package['price_note']) ?></span>
                        <?php endif; ?>
                        <div class="ms-auto flex gap-3">
                            <a href="#inquiry-form" class="px-6 py-3 rounded-full font-semibold text-white bg-gradient-to-r from-emerald-600 to-red-600 shadow-lg hover:shadow-xl hover:scale-105 transition">
                                <i class="fas fa-paper-plane me-2"></i> Book / Inquire Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content & Sidebar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <!-- Left Column: Details -->
                <div class="lg:col-span-8 space-y-10">

                    <!-- Highlights Section -->
                    <?php if (!empty($highlights)): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">
                                    <i class="fas fa-star"></i>
                                </span>
                                Key Package Highlights
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <?php foreach ($highlights as $hl): ?>
                                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                        <i class="fas fa-check-circle text-emerald-600 mt-1 flex-shrink-0"></i>
                                        <span class="text-sm font-medium text-slate-700"><?= htmlspecialchars($hl) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Detailed Day-Wise Itinerary -->
                    <?php if (!empty($itinerary)): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
                            <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    Day-by-Day Detailed Itinerary
                                </h2>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-100 px-3 py-1 rounded-full">
                                    <?= count($itinerary) ?> Days Planned
                                </span>
                            </div>

                            <div class="space-y-8 pl-4">
                                <?php foreach ($itinerary as $day): ?>
                                    <div class="itinerary-timeline">
                                        <div class="itinerary-dot">
                                            <?= (int)$day['day_number'] ?>
                                        </div>
                                        <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 shadow-sm hover:border-slate-300 transition">
                                            <div class="flex items-baseline justify-between mb-2">
                                                <h3 class="text-lg font-bold text-slate-900">
                                                    Day <?= (int)$day['day_number'] ?>: <?= htmlspecialchars($day['title']) ?>
                                                </h3>
                                            </div>
                                            <div class="text-slate-600 text-sm leading-relaxed prose prose-sm max-w-none">
                                                <?= nl2br(htmlspecialchars($day['description'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Inclusions & Exclusions -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">
                                <i class="fas fa-clipboard-check"></i>
                            </span>
                            Inclusions & Services Covered
                        </h2>

                        <?php if (!empty($inclusions)): ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                                <?php foreach ($inclusions as $inc): ?>
                                    <div class="flex items-start gap-2.5 text-sm text-slate-700">
                                        <i class="fas fa-check text-emerald-600 mt-1 flex-shrink-0"></i>
                                        <span><?= htmlspecialchars($inc) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-slate-600 mb-4">
                                Includes luxury accommodation, daily breakfast, private AC transfers, sightseeing tours with licensed local guides, and 24/7 dedicated travel concierge.
                            </p>
                        <?php endif; ?>

                        <!-- Standard Exclusions -->
                        <div class="pt-6 border-t border-slate-100">
                            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3">Package Exclusions</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-500">
                                <div><i class="fas fa-times text-rose-500 me-1.5"></i> Personal expenses & tips</div>
                                <div><i class="fas fa-times text-rose-500 me-1.5"></i> Airfare / Train tickets (available on request)</div>
                                <div><i class="fas fa-times text-rose-500 me-1.5"></i> Entry tickets to monuments / activities not stated</div>
                                <div><i class="fas fa-times text-rose-500 me-1.5"></i> Travel insurance (recommended)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Travel Notes -->
                    <?php if (!empty($notes)): ?>
                        <div class="bg-amber-50/60 rounded-2xl border border-amber-200 p-6 sm:p-8">
                            <h2 class="text-xl font-bold text-amber-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-info-circle text-amber-600"></i> Important Travel Notes & Guidelines
                            </h2>
                            <ul class="space-y-2 text-sm text-amber-900/90 list-disc list-inside">
                                <?php foreach ($notes as $note): ?>
                                    <li><?= htmlspecialchars($note) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Right Column: Sticky Booking / Inquiry Sidebar -->
                <div class="lg:col-span-4">
                    <div class="sticky top-28 space-y-6">

                        <!-- Booking Inquiry Card -->
                        <div id="inquiry-form" class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 sm:p-8">
                            <div class="text-center pb-5 mb-5 border-b border-slate-100">
                                <span class="text-xs uppercase tracking-wider font-bold text-emerald-600">Plan Your Holiday</span>
                                <h3 class="text-2xl font-black text-slate-900 mt-1">Book This Package</h3>
                                <p class="text-xs text-slate-500 mt-1">Instant confirmation & bespoke customization</p>
                            </div>

                            <form action="<?= $site ?>contact/#contactform" method="POST" class="space-y-4">
                                <input type="hidden" name="package_name" value="<?= htmlspecialchars($package['title']) ?>">
                                <input type="hidden" name="source" value="Package Page: <?= htmlspecialchars($package['slug']) ?>">

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Your Full Name</label>
                                    <input type="text" name="name" required placeholder="John Doe" 
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                                    <input type="email" name="email" required placeholder="john@example.com" 
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Phone / WhatsApp</label>
                                    <input type="tel" name="phone" required placeholder="+91 99994 47373" 
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Travel Date</label>
                                        <input type="date" name="travel_date" 
                                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Guests</label>
                                        <select name="guests" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                            <option value="2 Adults">2 Adults</option>
                                            <option value="3-4 Adults">3-4 Adults</option>
                                            <option value="Family with Kids">Family w/ Kids</option>
                                            <option value="Group 5+">Group 5+</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Special Preferences</label>
                                    <textarea name="message" rows="2" placeholder="Dietary needs, flight bookings, room upgrades..." 
                                              class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                                </div>

                                <button type="submit" 
                                        class="w-full py-3.5 px-4 rounded-xl font-bold text-white bg-gradient-to-r from-emerald-600 via-emerald-600 to-red-600 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all">
                                    <i class="fas fa-check-circle me-1"></i> Send Booking Inquiry
                                </button>
                            </form>

                            <!-- Direct WhatsApp & Call CTA -->
                            <div class="mt-5 pt-5 border-t border-slate-100 flex items-center justify-between gap-3">
                                <a href="https://wa.me/917982938239?text=<?= urlencode('Hi Vocation Travels, I am interested in the ' . $package['title'] . ' package.') ?>" 
                                   target="_blank" 
                                   class="flex-1 py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-semibold text-center border border-emerald-200 transition">
                                    <i class="fab fa-whatsapp text-emerald-600 me-1"></i> WhatsApp
                                </a>
                                <a href="tel:<?= $contact['phone'] ?? '9999447373' ?>" 
                                   class="flex-1 py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold text-center border border-slate-200 transition">
                                    <i class="fas fa-phone-alt text-slate-600 me-1"></i> Call Expert
                                </a>
                            </div>
                        </div>

                        <!-- Trust & Assurance Badge -->
                        <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-sm">
                            <h4 class="font-bold text-sm uppercase tracking-wider text-emerald-400 mb-3">Why Travel With Us</h4>
                            <ul class="space-y-3 text-xs text-slate-300">
                                <li class="flex items-center gap-2.5">
                                    <i class="fas fa-shield-alt text-emerald-400"></i>
                                    <span><strong>100% Customized Itineraries:</strong> Tailored to your exact budget & taste.</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i class="fas fa-headset text-emerald-400"></i>
                                    <span><strong>24/7 Dedicated Concierge:</strong> On-trip assistance whenever you need it.</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i class="fas fa-award text-emerald-400"></i>
                                    <span><strong>Verified Stays & Transport:</strong> Strictly vetted 4-star & 5-star properties.</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Other Recommended Packages -->
            <?php if (!empty($other_packages)): ?>
                <div class="mt-20 pt-12 border-t border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Explore Other Popular Tour Packages</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach ($other_packages as $op): ?>
                            <a href="<?= $site ?>package/<?= htmlspecialchars($op['slug']) ?>/" 
                               class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 block">
                                <div class="relative h-48 overflow-hidden bg-slate-100">
                                    <?php $op_img = !empty($op['image']) ? $site . $op['image'] : $site . 'assets/images/placeholder.jpg'; ?>
                                    <img src="<?= htmlspecialchars($op_img) ?>" alt="<?= htmlspecialchars($op['title']) ?>" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    <span class="absolute top-3 right-3 bg-black/60 backdrop-blur-sm text-white text-xs px-2.5 py-1 rounded-full font-medium">
                                        <?= htmlspecialchars($op['duration']) ?>
                                    </span>
                                </div>
                                <div class="p-5">
                                    <h3 class="font-bold text-slate-900 group-hover:text-emerald-600 transition truncate mb-2">
                                        <?= htmlspecialchars($op['title']) ?>
                                    </h3>
                                    <div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
                                        <span>Starting From:</span>
                                        <span class="text-sm font-black text-emerald-600">$<?= number_format($op['price'], 0) ?> USD</span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include('footer.php'); ?>
    <script src="<?= $site ?>assets/js/main.js"></script>
</body>

</html>
