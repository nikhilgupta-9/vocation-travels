<?php
// Script to initialize page_seo and services_cms tables
require_once dirname(__DIR__) . '/config/connect.php';
require_once dirname(__DIR__) . '/util/services_data.php';
require_once dirname(__DIR__) . '/util/services_detail.php';

echo "1. Creating page_seo table...\n";
$conn->query("CREATE TABLE IF NOT EXISTS `page_seo` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `page_slug` VARCHAR(150) NOT NULL UNIQUE,
  `page_name` VARCHAR(150) NOT NULL,
  `focus_keyword` VARCHAR(150) DEFAULT '',
  `meta_title` VARCHAR(255) NOT NULL,
  `meta_description` TEXT,
  `canonical_url` VARCHAR(255) DEFAULT '',
  `og_image` VARCHAR(255) DEFAULT '',
  `schema_type` VARCHAR(50) DEFAULT 'WebPage',
  `seo_score` INT DEFAULT 88,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$initial_pages = [
    [
        'slug' => 'home',
        'name' => 'Home Page',
        'keyword' => 'travel agency India tour packages visa consultants',
        'title' => 'Vocation Travels – Holiday Tour Packages & Visa Consultants Across India',
        'desc' => 'Discover luxury tour packages and trusted visa consultancy across 40+ Indian cities and globally. 24/7 VIP concierge, bespoke itineraries, and expert visa assistance.',
        'canonical' => '',
        'og_image' => 'assets/images/luxury_travel_hero.jpg',
        'score' => 95
    ],
    [
        'slug' => 'about',
        'name' => 'About Us',
        'keyword' => 'about vocation travels luxury travel company India',
        'title' => 'About Us | Vocation Travels And Tours – Visa & Travel Experts Since 2011',
        'desc' => 'Vocation Travels has curated bespoke luxury travel and visa experiences since 2011. Serving travelers across 40+ Indian cities with personalized care and IATA standards.',
        'canonical' => 'about/',
        'og_image' => 'assets/images/about_1.jpg',
        'score' => 92
    ],
    [
        'slug' => 'contact',
        'name' => 'Contact Us',
        'keyword' => 'contact vocation travels travel agency Delhi',
        'title' => 'Contact Us | Vocation Travels And Tours – Delhi, Bangalore & Hyderabad',
        'desc' => 'Get in touch with Vocation Travels for customized holiday tour packages and visa assistance. Head office in District Centre Janakpuri New Delhi. Fast response within 60 mins.',
        'canonical' => 'contact/',
        'og_image' => 'assets/images/contact.jpg',
        'score' => 94
    ],
    [
        'slug' => 'services',
        'name' => 'Services Hub',
        'keyword' => 'travel services India corporate travel management holiday packages',
        'title' => 'Our Services | Tour Packages, Flights, Hotels & Corporate Travel – Vocation Travels',
        'desc' => 'Explore our full spectrum of 65+ travel services — holiday packages, flight bookings, hotel reservations, visa consultancy, MICE, corporate travel and VIP charters.',
        'canonical' => 'services/',
        'og_image' => 'assets/images/services/world-tours.jpg',
        'score' => 96
    ],
    [
        'slug' => 'travel-package',
        'name' => 'Travel Packages',
        'keyword' => 'domestic international holiday tour packages India',
        'title' => 'Tour Packages | Domestic & International Holidays – Vocation Travels',
        'desc' => 'Explore handpicked domestic holiday packages (Goa, Rajasthan, Kerala, Kashmir) and exotic international tours (Dubai, Bali, Europe, Vietnam) with luxury stays.',
        'canonical' => 'travel-package/',
        'og_image' => 'assets/images/world_tour_destinations.jpg',
        'score' => 91
    ],
    [
        'slug' => 'visa-services',
        'name' => 'Visa Services Hub',
        'keyword' => 'visa consultants India US UK Schengen Canada Australia visa',
        'title' => 'Visa Services Across India | US, UK, Schengen, Canada & Australia Visa Consultants',
        'desc' => 'Professional visa consultancy covering documentation, VFS slot booking, and mock interviews for US, UK, Schengen, Canada, Australia and 40+ countries across India.',
        'canonical' => 'visa-services/',
        'og_image' => 'assets/images/services/visa-consultation.jpg',
        'score' => 97
    ],
    [
        'slug' => 'vip-concierge',
        'name' => 'VIP Concierge',
        'keyword' => 'vip travel concierge private jet charter luxury transfers',
        'title' => 'VIP Concierge & Jet Charters | Exclusive Travel Management – Vocation Travels',
        'desc' => 'Bespoke 24/7 VIP concierge travel management for high-net-worth individuals, business executives and celebrities. Private aviation, luxury transfers and five-star stays.',
        'canonical' => 'vip-concierge/',
        'og_image' => 'assets/images/vip_concierge_luxury.jpg',
        'score' => 93
    ],
    [
        'slug' => 'blogs',
        'name' => 'Travel Blog',
        'keyword' => 'travel guide visa tips holiday hacks India',
        'title' => 'Travel Blog & Guides | Visa Tips & Destination Insights – Vocation Travels',
        'desc' => 'Expert travel advice, visa documentation guides, luxury travel hacks, and destination reviews from senior travel consultants at Vocation Travels.',
        'canonical' => 'blogs/',
        'og_image' => 'assets/images/services/world-tours.jpg',
        'score' => 90
    ]
];

foreach ($initial_pages as $p) {
    $stmt = $conn->prepare("INSERT INTO `page_seo` (`page_slug`, `page_name`, `focus_keyword`, `meta_title`, `meta_description`, `canonical_url`, `og_image`, `seo_score`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE `page_name`=VALUES(`page_name`), `focus_keyword`=VALUES(`focus_keyword`), `meta_title`=VALUES(`meta_title`), `meta_description`=VALUES(`meta_description`), `seo_score`=VALUES(`seo_score`)");
    $stmt->bind_param("sssssssi", $p['slug'], $p['name'], $p['keyword'], $p['title'], $p['desc'], $p['canonical'], $p['og_image'], $p['score']);
    $stmt->execute();
    $stmt->close();
}
echo "page_seo seeded.\n";

echo "2. Creating services_cms table...\n";
$conn->query("CREATE TABLE IF NOT EXISTS `services_cms` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `name` VARCHAR(200) NOT NULL,
  `category` ENUM('core','specialized') DEFAULT 'core',
  `tagline` TEXT,
  `icon` VARCHAR(100) DEFAULT 'fa-solid fa-plane-departure',
  `image` VARCHAR(255) DEFAULT '',
  `overview_text` TEXT,
  `highlights_json` TEXT,
  `features_json` TEXT,
  `faqs_json` TEXT,
  `meta_title` VARCHAR(255) DEFAULT '',
  `meta_description` TEXT,
  `focus_keyword` VARCHAR(150) DEFAULT '',
  `seo_score` INT DEFAULT 88,
  `status` ENUM('active','inactive') DEFAULT 'active',
  `views_count` INT DEFAULT 0,
  `inquiries_count` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$all_services = get_services();
echo "Populating " . count($all_services) . " services into services_cms...\n";

foreach ($all_services as $slug => $svc) {
    $enriched = enrich_service($slug, $svc);
    
    $name = $enriched['name'] ?? $svc['name'];
    $category = $svc['category'] ?? 'core';
    $tagline = $enriched['tagline'] ?? $svc['description'] ?? '';
    $icon = $enriched['icon'] ?? $svc['icon'] ?? 'fa-solid fa-plane-departure';
    $image = $enriched['image'] ?? 'assets/images/services/world-tours.jpg';
    
    $overview_text = is_array($enriched['overview']) ? implode("\n\n", $enriched['overview']) : ($enriched['overview'] ?? '');
    $highlights_json = json_encode($enriched['highlights'] ?? [], JSON_UNESCAPED_UNICODE);
    $features_json = json_encode($enriched['features'] ?? [], JSON_UNESCAPED_UNICODE);
    $faqs_json = json_encode($enriched['faqs'] ?? [], JSON_UNESCAPED_UNICODE);
    
    $meta_title = $enriched['meta_title'] ?? ($name . ' | Vocation Travels');
    $meta_description = $enriched['meta_description'] ?? $tagline;
    $focus_keyword = !empty($svc['keywords']) ? (is_array($svc['keywords']) ? $svc['keywords'][0] : $svc['keywords']) : strtolower($name);
    $seo_score = 92;
    $status = 'active';

    $stmt = $conn->prepare("INSERT INTO `services_cms` 
        (`slug`, `name`, `category`, `tagline`, `icon`, `image`, `overview_text`, `highlights_json`, `features_json`, `faqs_json`, `meta_title`, `meta_description`, `focus_keyword`, `seo_score`, `status`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `category`=VALUES(`category`), `tagline`=VALUES(`tagline`), `image`=VALUES(`image`), `meta_title`=VALUES(`meta_title`), `meta_description`=VALUES(`meta_description`)");
    
    $stmt->bind_param("sssssssssssssis", 
        $slug, $name, $category, $tagline, $icon, $image, $overview_text, 
        $highlights_json, $features_json, $faqs_json, $meta_title, $meta_description, $focus_keyword, $seo_score, $status
    );
    $stmt->execute();
    $stmt->close();
}
echo "services_cms populated successfully.\n";

echo "3. Seeding about_sections if empty...\n";
$chk_about = $conn->query("SELECT COUNT(*) as c FROM about_sections")->fetch_assoc();
if ((int)$chk_about['c'] === 0) {
    $initial_about = [
        [
            'title' => 'Welcome to a Journey Beyond Travel',
            'content' => "If you’re here, you seek more than just a trip — you desire a partner who understands the true essence of every journey.\n\nSince 2011, we’ve grown from humble beginnings into a prestigious agency, renowned for curating bespoke luxury experiences. What began as a dream has evolved into an agency trusted by discerning travelers who expect nothing less than perfection.",
            'image' => 'assets/images/about_1.jpg',
            'order' => 1
        ],
        [
            'title' => 'Why Choose Us',
            'content' => "Tailored Luxury: Personalized experiences crafted to reflect your unique tastes.\n\nSeamless Service: From private transfers to exclusive accommodations, we ensure every detail is flawless.\n\nUnforgettable Moments: Curating extraordinary experiences for once-in-a-lifetime memories.",
            'image' => 'assets/images/services/luxury-travel.jpg',
            'order' => 2
        ],
        [
            'title' => 'Our Story',
            'content' => "At Vocation Travels, we make an unwavering commitment to craft every journey with the utmost dedication and precision.\n\nWe take the time to truly understand your unique needs, curating each experience to align with your desires. Whether you’re seeking a peaceful retreat in the Himalayas, a seamless business trip, or an unforgettable family getaway, we ensure every detail is flawlessly executed.",
            'image' => 'assets/images/services/world-tours.jpg',
            'order' => 3
        ],
        [
            'title' => 'Our Pan-India Reach & Excellence',
            'content' => "Serving discerning travelers and students across 40+ Indian cities (Delhi, Mumbai, Bengaluru, Hyderabad, Pune, Ahmedabad, Chandigarh) and worldwide. With over a decade of excellence, IATA accredited expertise, and 24/7 VIP concierge care, we are proud to be your lifelong travel partner.",
            'image' => 'assets/images/services/adventure-travel.jpg',
            'order' => 4
        ]
    ];

    foreach ($initial_about as $ab) {
        $stmt = $conn->prepare("INSERT INTO about_sections (title, content, image_url, section_order, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("sssi", $ab['title'], $ab['content'], $ab['image'], $ab['order']);
        $stmt->execute();
        $stmt->close();
    }
    echo "about_sections seeded.\n";
} else {
    echo "about_sections already contains " . $chk_about['c'] . " rows.\n";
}

echo "All initialization completed!\n";
