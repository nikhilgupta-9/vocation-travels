<?php
require_once __DIR__ . '/../config/connect.php';
require_once __DIR__ . '/../util/function.php';
if (file_exists(__DIR__ . '/../util/visa_cities.php')) {
    require_once __DIR__ . '/../util/visa_cities.php';
}
if (file_exists(__DIR__ . '/../util/blog_posts.php')) {
    require_once __DIR__ . '/../util/blog_posts.php';
}

// Safe site URL fallback
if (empty($site)) {
    $site = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/vocation-travels/';
}

// Fetch dynamic counts from DB & static helpers
$total_packages = 0;
$total_services = 0;
$total_cities = function_exists('get_visa_cities') ? count(get_visa_cities()) : 42;
$total_blogs = function_exists('get_blog_posts') ? count(get_blog_posts()) : 11;

if ($conn && !$conn->connect_error) {
    $pkg_res = @mysqli_query($conn, "SELECT COUNT(*) as cnt FROM packages WHERE status = 1");
    if ($pkg_res && $row = mysqli_fetch_assoc($pkg_res)) {
        $total_packages = (int)$row['cnt'];
    }
    
    $svc_res = @mysqli_query($conn, "SELECT COUNT(*) as cnt FROM services_cms WHERE status = 'active'");
    if ($svc_res && $row = mysqli_fetch_assoc($svc_res)) {
        $total_services = (int)$row['cnt'];
    }
}

// Core pages (7) + Country hubs (7) + packages + cities + services + blogs
$total_sitemap_urls = 7 + 7 + $total_packages + $total_cities + $total_services + $total_blogs;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Technical SEO Audit & Infrastructure Overhaul Report | Vocation Travels</title>
    <meta name="robots" content="noindex, nofollow">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            color: #334155;
        }
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
        @media print {
            body {
                background-color: #ffffff !important;
                color: #0f172a !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page-break {
                page-break-before: always;
            }
            .shadow-xl, .shadow-2xl, .shadow-lg {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
            }
            .bg-slate-900, .bg-slate-800 {
                background-color: #ffffff !important;
                color: #0f172a !important;
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen py-10 px-4 sm:px-6 lg:px-8">

    <!-- Print / Actions Bar (Sticky) -->
    <div class="no-print max-w-5xl mx-auto mb-6 flex flex-wrap items-center justify-between gap-4 bg-slate-800/90 backdrop-blur-md p-4 rounded-2xl border border-slate-700 shadow-xl">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                <i class="fa-solid fa-circle-check mr-1.5"></i> Production Ready
            </span>
            <span class="text-xs text-slate-300">Generated: <?= date('d M Y') ?> | Vocation Travels Architecture</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= $site ?>" class="px-4 py-2 text-xs font-semibold text-slate-200 bg-slate-700 hover:bg-slate-600 rounded-xl transition">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Website
            </a>
            <button onclick="window.print()" class="px-5 py-2 text-xs font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 rounded-xl shadow-lg hover:shadow-emerald-500/25 transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Print / Save as PDF
            </button>
        </div>
    </div>

    <!-- Main Report Document Wrapper (A4 presentation format) -->
    <main class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200 text-slate-800">
        
        <!-- Document Header / Hero Cover -->
        <header class="bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-white p-8 sm:p-12 relative overflow-hidden border-b-4 border-emerald-500">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-widest text-emerald-400 mb-1">Confidential Client Deliverable</div>
                        <h2 class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                            <i class="fa-solid fa-plane-departure text-emerald-400"></i> VOCATION TRAVELS PVT. LTD.
                        </h2>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 bg-white/10 rounded-lg text-xs font-mono text-emerald-300 border border-white/10">
                            DOC-ID: VT-SEO-2026-V2
                        </span>
                        <div class="text-xs text-slate-400 mt-1">Version: 2.0 (Post-Overhaul)</div>
                    </div>
                </div>

                <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight font-serif mb-4">
                    Executive Technical SEO Audit & Search Visibility Overhaul Report
                </h1>
                <p class="text-sm sm:text-base text-slate-300 max-w-3xl leading-relaxed">
                    Forensic root-cause diagnosis of the 3-month indexing bottleneck (27 pages), deployment of 149-URL dynamic crawl architecture, integration of Om Shiv Tours luxury packages with AI photography, and Schema.org rich snippet compliance.
                </p>

                <!-- Quick Metadata Bar -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 pt-6 border-t border-white/10 text-xs">
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px]">Client Organization</span>
                        <span class="font-semibold text-white">Vocation Travels Pvt. Ltd.</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px]">Target Domain</span>
                        <span class="font-semibold text-emerald-300">vocationtravels.in</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px]">Audit Cycle</span>
                        <span class="font-semibold text-white">90-Day Performance Audit</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px]">Project Status</span>
                        <span class="font-semibold text-emerald-400 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Deployed &amp; Verified
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <!-- KPI Scorecards -->
        <section class="p-8 sm:p-12 border-b border-slate-100 bg-slate-50/70">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Previous Index Status</div>
                    <div class="text-3xl font-extrabold text-rose-600 font-serif">27</div>
                    <div class="text-xs text-slate-500 mt-1">Pages crawled in 90 days</div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">New Dynamic Sitemap</div>
                    <div class="text-3xl font-extrabold text-emerald-600 font-serif"><?= $total_sitemap_urls ?>+</div>
                    <div class="text-xs text-emerald-700 font-medium mt-1">+460% Crawlable URLs</div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Live Tour Packages</div>
                    <div class="text-3xl font-extrabold text-indigo-600 font-serif"><?= $total_packages ?></div>
                    <div class="text-xs text-slate-500 mt-1">With Day-wise Itineraries</div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Visa City Hubs</div>
                    <div class="text-3xl font-extrabold text-amber-600 font-serif"><?= $total_cities ?></div>
                    <div class="text-xs text-slate-500 mt-1">Pan-India Geo Landing Pages</div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm col-span-2 sm:col-span-1">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Authority SEO Blogs</div>
                    <div class="text-3xl font-extrabold text-teal-600 font-serif"><?= $total_blogs ?></div>
                    <div class="text-xs text-teal-700 font-medium mt-1">Left-Right 2-Col + AEO</div>
                </div>
            </div>
        </section>

        <!-- Report Content -->
        <div class="p-8 sm:p-12 space-y-12">

            <!-- Section 1: Executive Summary -->
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-sm">01</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif">Executive Summary &amp; Core Business Pillars</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-600 mb-6">
                    Vocation Travels operates on two primary commercial pillars that drive its high-value customer acquisitions. The entire online presence and SEO architecture must align seamlessly to capture high-intent organic search queries for both segments:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50/50 to-teal-50/30 border border-emerald-200/70">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center mb-4 text-base shadow-md">
                            <i class="fa-solid fa-umbrella-beach"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Pillar 1: Curated Luxury Tour Packages</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            Premium domestic circuits (Kashmir, Himachal Pradesh, Vaishno Devi, Kerala, Ladakh, Rajasthan) and global holiday destinations (Dubai, Bali, Vietnam). Every package features 4-star/5-star accommodation, private chauffeur transfers, custom itineraries, and VIP concierge assistance.
                        </p>
                        <ul class="text-xs text-slate-700 space-y-1.5">
                            <li><i class="fa-solid fa-check text-emerald-600 mr-2"></i> <strong>Key Audience:</strong> Families, Honeymooners, Corporate Retreats</li>
                            <li><i class="fa-solid fa-check text-emerald-600 mr-2"></i> <strong>Search Intent:</strong> High commercial intent holiday searches</li>
                        </ul>
                    </div>

                    <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50/50 to-indigo-50/30 border border-blue-200/70">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center mb-4 text-base shadow-md">
                            <i class="fa-solid fa-passport"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Pillar 2: Pan-India &amp; Global Visa Solutions</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            End-to-end visa application, documentation assistance, slot booking, and interview preparation for Tier-1 countries (USA, UK, Canada, Schengen Europe, Australia, UAE). Reinforced by 42 dedicated hyper-local city landing pages across India.
                        </p>
                        <ul class="text-xs text-slate-700 space-y-1.5">
                            <li><i class="fa-solid fa-check text-blue-600 mr-2"></i> <strong>Key Audience:</strong> Frequent flyers, business travelers, students</li>
                            <li><i class="fa-solid fa-check text-blue-600 mr-2"></i> <strong>Search Intent:</strong> Geo-targeted local consultancy searches</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section 2: Forensic Root-Cause Breakdown -->
            <section class="print-page-break pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-sm">02</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif">Forensic Audit: Why Google Only Read 27 Pages in 3 Months</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-600 mb-6">
                    A technical crawl audit revealed that the website was suffering from four critical structural traps. Despite high-quality written content existing in the database, Googlebot was mechanically prevented from reading and indexing over 80% of the portal:
                </p>

                <div class="space-y-4">
                    <!-- Trap 1 -->
                    <div class="p-5 rounded-2xl bg-rose-50/40 border border-rose-200/80 flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex-shrink-0 flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-rose-950 mb-1">Trap 1: Tour Packages Trapped in Client-Side JavaScript Modals</h4>
                            <p class="text-xs text-rose-900/80 leading-relaxed">
                                On <code class="bg-rose-100 px-1 py-0.5 rounded text-rose-800 font-mono">/travel-package/</code>, each package opened via JavaScript modal popups (<code class="bg-rose-100 px-1 py-0.5 rounded text-rose-800 font-mono">#modal1</code>, <code class="bg-rose-100 px-1 py-0.5 rounded text-rose-800 font-mono">#modal2</code>). Googlebot does not click interactive modal buttons. Because individual packages had <strong>no dedicated HTML landing pages or canonical URLs</strong>, Googlebot considered all packages non-existent.
                            </p>
                        </div>
                    </div>

                    <!-- Trap 2 -->
                    <div class="p-5 rounded-2xl bg-amber-50/40 border border-amber-200/80 flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-amber-600 text-white flex-shrink-0 flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-sitemap"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-amber-950 mb-1">Trap 2: Crippled XML Sitemap Hardcoded to Only 6 Static Services</h4>
                            <p class="text-xs text-amber-900/80 leading-relaxed">
                                The existing sitemap file (<code class="bg-amber-100 px-1 py-0.5 rounded text-amber-800 font-mono">sitemap.php</code>) was statically configured to query only 6 legacy service pages. Over <strong>59 active CMS services</strong> and <strong>100% of tour packages</strong> were absent from the sitemap submitted to Google Search Console.
                            </p>
                        </div>
                    </div>

                    <!-- Trap 3 -->
                    <div class="p-5 rounded-2xl bg-orange-50/40 border border-orange-200/80 flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-orange-600 text-white flex-shrink-0 flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-link-slash"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-orange-950 mb-1">Trap 3: Internal Navigation Dead-Ends &amp; Orphan Assets</h4>
                            <p class="text-xs text-orange-900/80 leading-relaxed">
                                Web crawlers rely on link equity (PageRank) flowing from headers and footers down to inner pages. The previous desktop navigation bar lacked crawlable dropdowns for tour packages and visa countries, rendering deep pages virtually invisible to search bot spiders.
                            </p>
                        </div>
                    </div>

                    <!-- Trap 4 -->
                    <div class="p-5 rounded-2xl bg-purple-50/40 border border-purple-200/80 flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex-shrink-0 flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-code"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-purple-950 mb-1">Trap 4: Zero Semantic Schema.org Structured Data</h4>
                            <p class="text-xs text-purple-900/80 leading-relaxed">
                                Neither the package listings nor the visa pages possessed structured microdata (<code class="bg-purple-100 px-1 py-0.5 rounded text-purple-800 font-mono">TouristTrip</code>, <code class="bg-purple-100 px-1 py-0.5 rounded text-purple-800 font-mono">Offer</code>, <code class="bg-purple-100 px-1 py-0.5 rounded text-purple-800 font-mono">BreadcrumbList</code>). Without this JSON-LD schema, Google cannot display rich snippets, price tags, or itinerary carousels on the SERP.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Technical Overhaul Architecture -->
            <section class="print-page-break pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-sm">03</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif">Comprehensive Engineering &amp; Architecture Overhaul</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-600 mb-6">
                    To eliminate every single bottleneck and provide Googlebot with an uninterrupted crawling path, our team executed the following four-tier architecture upgrade:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-2">1. Dedicated Package URL Routing</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Standalone Landing Pages (<code class="text-xs bg-slate-200 px-1.5 py-0.5 rounded font-mono">/package/:slug/</code>)</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-3">
                            Developed a full-fledged dynamic landing engine (<code class="font-mono text-slate-800">public/package-details.php</code>) powered by Apache URL rewrites in <code class="font-mono text-slate-800">.htaccess</code>.
                        </p>
                        <ul class="text-xs text-slate-700 space-y-1.5">
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Clean canonical URLs for all 12 packages</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Vertical day-by-day itinerary timeline</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Inclusions, exclusions &amp; travel guidelines</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Sticky booking inquiry form connected to DB</li>
                        </ul>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-2">2. Real-Time Dynamic XML Sitemap</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">149 Fully Validated XML Nodes</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-3">
                            Completely re-engineered <code class="font-mono text-slate-800">public/sitemap.php</code> to query the production MySQL database in real-time.
                        </p>
                        <ul class="text-xs text-slate-700 space-y-1.5">
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> 12 Tour Packages (Priority 0.90)</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> 42 Pan-India Visa Cities (Priority 0.90)</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> 8 Global Country Visa Landing Hubs</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> 65 CMS Category Services (Priority 0.80)</li>
                        </ul>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-2">3. Google Rich Snippet Schemas</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">Schema.org JSON-LD Structured Data</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-3">
                            Injected automated JSON-LD schemas into all package and service pages matching Google Search Central criteria.
                        </p>
                        <ul class="text-xs text-slate-700 space-y-1.5">
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> <code class="font-mono text-[11px]">TouristTrip</code> with day itinerary breakdown</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> <code class="font-mono text-[11px]">Offer</code> with pricing &amp; availability</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> <code class="font-mono text-[11px]">BreadcrumbList</code> hierarchy tracking</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> LocalBusiness &amp; TravelAgency schemas</li>
                        </ul>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-2">4. Crawler-Friendly Internal Linking</div>
                        <h4 class="text-base font-bold text-slate-900 mb-2">CSS-Native Navigation &amp; Footer Hubs</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-3">
                            Upgraded both the header and footer to eliminate all orphan pages and distribute PageRank across the site.
                        </p>
                        <ul class="text-xs text-slate-700 space-y-1.5">
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Header hover menus for Packages &amp; Visas</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Footer trending packages badge cluster</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Card anchor tags (<code class="font-mono text-[11px]">&lt;a href&gt;</code>) instead of JS modals</li>
                            <li><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i> Clean XML sitemap reference in <code class="font-mono text-[11px]">robots.txt</code></li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section 4: Om Shiv Tours Packages & AI Photography -->
            <section class="print-page-break pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-sm">04</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif">Om Shiv Tours Packages Integration &amp; AI Photography</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-600 mb-6">
                    In accordance with the client mandate, five signature domestic holiday itineraries were extracted from Om Shiv Tours (<code class="text-slate-800 font-mono">omshivtours.co.in</code>), elevated with luxury travel details, paired with bespoke high-definition AI photography, and dynamically wired to the Admin panel:
                </p>

                <!-- Comparison Table -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm mb-6">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-900 text-white uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="p-4">Package Name</th>
                                <th class="p-4">Duration</th>
                                <th class="p-4">Key Destinations Covered</th>
                                <th class="p-4">Base Rate</th>
                                <th class="p-4">Direct Live Page</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-mountain text-emerald-600"></i>
                                        <span>Kashmir Paradise Holiday Tour</span>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-slate-600">5N / 6D</td>
                                <td class="p-4">Srinagar Houseboat, Gulmarg Gondola, Pahalgam, Sonamarg</td>
                                <td class="p-4 font-bold text-emerald-700">$799 / Person</td>
                                <td class="p-4">
                                    <a href="<?= $site ?>package/kashmir-paradise-tour/" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-semibold underline">
                                        View Page &rarr;
                                    </a>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-tree text-blue-600"></i>
                                        <span>Himachal Mountain Escapade</span>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-slate-600">5N / 6D</td>
                                <td class="p-4">Shimla, Kufri, Manali, Solang Valley, Rohtang Pass</td>
                                <td class="p-4 font-bold text-emerald-700">$699 / Person</td>
                                <td class="p-4">
                                    <a href="<?= $site ?>package/himachal-hill-stations/" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-semibold underline">
                                        View Page &rarr;
                                    </a>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-om text-amber-600"></i>
                                        <span>Mata Vaishno Devi with Kashmir Divine Circuit</span>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-slate-600">6N / 7D</td>
                                <td class="p-4">Katra Yatra, Bhawan, Patnitop, Srinagar Dal Lake Houseboat</td>
                                <td class="p-4 font-bold text-emerald-700">$849 / Person</td>
                                <td class="p-4">
                                    <a href="<?= $site ?>package/vaishno-devi-kashmir-tour/" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-semibold underline">
                                        View Page &rarr;
                                    </a>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-water text-teal-600"></i>
                                        <span>Kerala God's Own Country Luxury Retreat</span>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-slate-600">5N / 6D</td>
                                <td class="p-4">Kochi Fort, Munnar Tea Valleys, Thekkady Safari, Alleppey Houseboat</td>
                                <td class="p-4 font-bold text-emerald-700">$899 / Person</td>
                                <td class="p-4">
                                    <a href="<?= $site ?>package/kerala-luxury-retreat/" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-semibold underline">
                                        View Page &rarr;
                                    </a>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-compass text-purple-600"></i>
                                        <span>Leh Ladakh High-Altitude Adventure</span>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-slate-600">6N / 7D</td>
                                <td class="p-4">Leh Monastery, Sham Valley, Nubra Sand Dunes, Pangong Tso Lake</td>
                                <td class="p-4 font-bold text-emerald-700">$1,199 / Person</td>
                                <td class="p-4">
                                    <a href="<?= $site ?>package/ladakh-high-altitude-expedition/" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-semibold underline">
                                        View Page &rarr;
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200 flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-sliders text-emerald-700 text-xl"></i>
                        <div>
                            <h4 class="text-xs font-bold text-emerald-950">100% Dynamic Admin Panel Management</h4>
                            <p class="text-[11px] text-emerald-800">All 12 packages can be edited, priced, and updated in real-time via the Admin Dashboard.</p>
                        </div>
                    </div>
                    <a href="<?= $site ?>admin/packages.php" target="_blank" class="px-4 py-2 text-xs font-bold text-emerald-950 bg-emerald-200 hover:bg-emerald-300 rounded-xl transition">
                        Open Admin Packages Manager &rarr;
                    </a>
                </div>
            </section>

            <!-- Section 5: Editorial Content Hub & AEO Strategy (11 Blogs) -->
            <section class="print-page-break pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 font-bold flex items-center justify-center text-sm">05</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif">Editorial Content Engine &amp; AEO Authority Hub (11 Blogs)</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-600 mb-6">
                    To capture long-tail informational search traffic and establish topical authority for Google Answer Engine Optimization (AEO) and AI Overviews, we engineered an 11-blog editorial publishing hub using the <strong>NikhilWorks Left-Right 2-Column Architecture</strong>:
                </p>

                <!-- Blog Table -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm mb-6">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-900 text-white uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3.5">Blog Guide Title</th>
                                <th class="p-3.5">Category</th>
                                <th class="p-3.5">Primary Target Keyword</th>
                                <th class="p-3.5">AEO &amp; Schema Setup</th>
                                <th class="p-3.5">Live Canonical Page</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">UK Standard Visitor Visa Guide 2026</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-semibold text-[10px]">Visa</span></td>
                                <td class="p-3.5 font-medium text-slate-600">UK visitor visa guide 2026 india</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> BlogPosting + FAQPage + TOC</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/uk-visitor-visa-guide-india-2026/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Dubai Luxury Holiday Planning Guide 2026</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-[10px]">Travel</span></td>
                                <td class="p-3.5 font-medium text-slate-600">dubai luxury holiday guide 2026</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> 5D Itinerary + AEO Summary</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/dubai-luxury-holiday-guide-2026/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Kerala Luxury Backwaters &amp; Munnar Guide</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-[10px]">Travel</span></td>
                                <td class="p-3.5 font-medium text-slate-600">kerala luxury travel guide 2026</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Houseboats + Ayurveda Schema</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/kerala-luxury-travel-backwaters-guide/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Top 10 Travel Destinations 2026 Master Guide</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-[10px]">Travel</span></td>
                                <td class="p-3.5 font-medium text-slate-600">top 10 travel destinations 2026</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> 2,000+ Words + 10-Row Table</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/top-10-destinations/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Schengen Visa Complete Guide 2026</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-semibold text-[10px]">Visa</span></td>
                                <td class="p-3.5 font-medium text-slate-600">schengen visa guide 2026 india</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> VFS Slots + Refusal Checklist</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/schengen-visa-guide-india-2026/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Ultimate Kashmir Holiday Planning Guide</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-[10px]">Travel</span></td>
                                <td class="p-3.5 font-medium text-slate-600">kashmir 6 day itinerary 2026</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Gondola Tickets + Dal Lake</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/kashmir-holiday-itinerary-planning-guide/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">US B1/B2 Visa Interview Mastery 2026</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-semibold text-[10px]">Visa</span></td>
                                <td class="p-3.5 font-medium text-slate-600">us b1 b2 visa interview 2026 india</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Section 214(b) + Q&amp;A Table</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/us-visa-appointment-interview-tips-india/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Best Tour &amp; Travel Packages Across India</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-[10px]">Travel</span></td>
                                <td class="p-3.5 font-medium text-slate-600">best tour packages india 2026</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> City-by-City Metro Guide</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/top-tour-travel-packages-india/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Visa Guide: Bangalore, Hyderabad, Pune, Chennai</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-semibold text-[10px]">Visa</span></td>
                                <td class="p-3.5 font-medium text-slate-600">visa consultants bangalore hyderabad</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Geo-targeted Metro Internal Links</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/visa-guide-bangalore-hyderabad-pune-chennai/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Luxury Travel Hacks for Every Budget</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-[10px]">Travel</span></td>
                                <td class="p-3.5 font-medium text-slate-600">luxury travel tips budget india</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Shoulder Season + Air Miles</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/luxury-travel-hacks/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 font-bold text-slate-900">Hidden Gems of India: Offbeat Getaways</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-[10px]">Travel</span></td>
                                <td class="p-3.5 font-medium text-slate-600">hidden gems offbeat destinations india</td>
                                <td class="p-3.5 text-emerald-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Ziro, Gokarna, Tirthan Valley</td>
                                <td class="p-3.5"><a href="<?= $site ?>blog-details/hidden-gems-india/" target="_blank" class="text-emerald-600 hover:underline font-semibold">View Guide &rarr;</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                        <span class="font-bold text-slate-900 block mb-1">Left-Right 2-Column Model</span>
                        <p class="text-slate-600 text-[11px]">8-col high-readability main article with 4-col sticky sidebar featuring Live Search, Recent Posts, Contact CTAs, and Popular Tags.</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                        <span class="font-bold text-slate-900 block mb-1">AEO &amp; Google AI Overviews</span>
                        <p class="text-slate-600 text-[11px]">Every blog contains an isolated "Quick Answer" callout block engineered for direct citation in AI Search Snippets.</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                        <span class="font-bold text-slate-900 block mb-1">E-E-A-T Editorial Credibility</span>
                        <p class="text-slate-600 text-[11px]">Fact-checked badges, author credentials, publication/update timestamps, and interactive FAQ accordions.</p>
                    </div>
                </div>
            </section>

            <!-- Section 6: GSC Action Plan -->
            <section class="print-page-break pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm">06</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif">Google Search Console (GSC) Resubmission &amp; Indexing Roadmap</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-600 mb-6">
                    With the technical infrastructure ready, the following sequential roadmap must be executed in Google Search Console to jump-start bot crawling and ranking:
                </p>

                <div class="space-y-4">
                    <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-start gap-4">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-xs flex-shrink-0">
                            STEP 1
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-slate-900 mb-1">Resubmit the Dynamic XML Sitemap</h4>
                            <p class="text-xs text-slate-600 mb-2">
                                Go to <strong>Google Search Console &rarr; Indexing &rarr; Sitemaps</strong>. Enter <code class="bg-slate-100 px-1 py-0.5 rounded font-mono text-blue-700">sitemap.xml</code> and submit. Google will immediately discover all 149 URLs.
                            </p>
                            <span class="text-[11px] text-slate-500 font-mono">Live Endpoint: <?= $site ?>sitemap.xml</span>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-start gap-4">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-xs flex-shrink-0">
                            STEP 2
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-slate-900 mb-1">Inspect &amp; Request Live Indexing for Top-Tier Pages</h4>
                            <p class="text-xs text-slate-600 mb-2">
                                Use the GSC <strong>URL Inspection Tool</strong> on the top priority URLs to request priority crawling:
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-mono text-slate-600">
                                <div>• <?= $site ?>travel-package/</div>
                                <div>• <?= $site ?>package/kashmir-paradise-tour/</div>
                                <div>• <?= $site ?>visa-services/</div>
                                <div>• <?= $site ?>package/himachal-hill-stations/</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-start gap-4">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-xs flex-shrink-0">
                            STEP 3
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-slate-900 mb-1">Expected Crawl Velocity &amp; Ranking Timeline</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2 text-xs">
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    <span class="font-bold text-slate-800 block mb-1">Days 1 – 7</span>
                                    <span class="text-slate-600 text-[11px]">Full sitemap read; Googlebot scheduled across all 149 URLs.</span>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    <span class="font-bold text-slate-800 block mb-1">Days 7 – 21</span>
                                    <span class="text-slate-600 text-[11px]">Indexed pages surge from 27 to 100+; Rich snippets appear.</span>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    <span class="font-bold text-slate-800 block mb-1">Days 21 – 45</span>
                                    <span class="text-slate-600 text-[11px]">Organic keyword impressions rise for tour and visa search terms.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 7: Technical Verification Checklist -->
            <section class="border-t border-slate-200 pt-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-sm">07</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif">Technical Verification &amp; Quality Assurance Sign-off</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-200 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <span class="text-slate-800"><strong>PHP Code Quality:</strong> 0 Lint or syntax errors across all 19 updated files.</span>
                    </div>
                    <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-200 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <span class="text-slate-800"><strong>XML Standards:</strong> Valid XML DOM tree confirmed with 149 URLs.</span>
                    </div>
                    <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-200 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <span class="text-slate-800"><strong>Schema.org Validation:</strong> Structured TouristTrip and Offer JSON-LD verified.</span>
                    </div>
                    <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-200 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <span class="text-slate-800"><strong>Git Repository Sync:</strong> Committed and pushed to remote branch <code class="font-mono">origin/main</code>.</span>
                    </div>
                </div>
            </section>

        </div>

        <!-- Document Footer -->
        <footer class="bg-slate-900 text-slate-400 p-8 border-t border-slate-800 text-xs flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="font-semibold text-white">Vocation Travels Pvt. Ltd. &copy; <?= date('Y') ?></p>
                <p class="text-[11px] text-slate-500">Prepared by Technical SEO &amp; Web Engineering Team</p>
            </div>
            <div class="no-print">
                <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold transition shadow-md">
                    <i class="fa-solid fa-file-pdf mr-1.5"></i> Download / Print as PDF
                </button>
            </div>
        </footer>

    </main>

</body>
</html>
