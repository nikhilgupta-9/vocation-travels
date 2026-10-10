<?php
/**
 * DB-backed & Programmatic content source for city-specific Visa & Immigration Consultant landing pages
 * (public/visa-consultants.php). Covers Tier 1, Tier 2, and Tier 3 cities across all of India.
 * Cities can be managed from admin/view-visa-cities.php or automatically resolved for Pan-India SEO.
 */

function __visa_city_row_to_array($row)
{
    return [
        'name' => $row['name'],
        'order' => (int) $row['city_order'],
        'meta_title' => $row['meta_title'],
        'meta_description' => $row['meta_description'],
        'keywords' => array_filter(array_map('trim', explode(',', (string) $row['meta_keywords']))),
        'hero_h1' => $row['hero_h1'],
        'hero_tagline' => $row['hero_tagline'],
        'intro_heading' => $row['intro_heading'],
        'intro' => $row['intro'],
        'services' => json_decode($row['services'], true) ?: [],
        'faqs' => json_decode($row['faqs'], true) ?: [],
    ];
}

/**
 * Programmatic fallback for any Indian city requested by users or search crawlers.
 */
function __generate_dynamic_city_profile($slug)
{
    $formattedName = ucwords(str_replace('-', ' ', $slug));
    
    // Custom mapping for well-known acronyms or compound city names
    $nameMap = [
        'delhi' => 'Delhi NCR',
        'noida' => 'Noida',
        'gurgaon' => 'Gurugram (Gurgaon)',
        'bengaluru' => 'Bangalore',
        'mysuru' => 'Mysuru',
        'goa' => 'Goa',
        'vizag' => 'Visakhapatnam',
        'cochin' => 'Kochi',
        'trivandrum' => 'Thiruvananthapuram',
        'trichy' => 'Tiruchirappalli',
    ];
    if (isset($nameMap[$slug])) {
        $formattedName = $nameMap[$slug];
    }

    return [
        'name' => $formattedName,
        'order' => 999,
        'meta_title' => "Best Visa Consultants in {$formattedName} | Tourist, Student & Work Visa Agency – Vocation Travels",
        'meta_description' => "Looking for top visa consultants in {$formattedName}? Vocation Travels offers trusted assistance for USA, UK, Canada, Schengen Europe, Australia & Dubai visas for applicants in {$formattedName}.",
        'keywords' => [
            "best visa consultants in {$formattedName}",
            "visa agency {$formattedName}",
            "tourist visa agents in {$formattedName}",
            "student visa consultants {$formattedName}",
            "schengen visa {$formattedName}",
            "us visa application {$formattedName}",
            "canada visitor visa {$formattedName}",
            "australia visa agent {$formattedName}"
        ],
        'hero_h1' => "Best Visa Consultants in {$formattedName}",
        'hero_tagline' => "Dedicated visa processing, checklist vetting, and VAC/VFS appointment booking for {$formattedName} travelers and students.",
        'intro_heading' => "Trusted Visa & Immigration Assistance in {$formattedName}",
        'intro' => "Planning an international trip, overseas business travel, or pursuing higher studies from {$formattedName}? Vocation Travels provides end-to-end visa filing and documentation support for applicants based in {$formattedName}. From accurate DS-160 and Schengen portal filing to mock interview training and biometric slot assistance, our specialists ensure a seamless, transparent experience.",
        'services' => [
            [
                'title' => 'US Tourist & Student Visa Filing',
                'desc' => "DS-160 application assistance, fee payment, slot booking, and personalized mock interview sessions for {$formattedName} applicants.",
                'icon' => 'fa-flag-usa',
                'country_link' => 'usa'
            ],
            [
                'title' => 'UK Visitor & Study Visa Consultants',
                'desc' => "Complete documentation support, financial proof verification, and online submission for travelers and students from {$formattedName}.",
                'icon' => 'fa-landmark',
                'country_link' => 'uk'
            ],
            [
                'title' => 'Canada Visitor & Super Visa Support',
                'desc' => "IRCC portal filing, invitation letter guidance, and comprehensive document review for family visits and tourism from {$formattedName}.",
                'icon' => 'fa-maple-leaf',
                'country_link' => 'canada'
            ],
            [
                'title' => 'Europe Schengen Visa Specialists',
                'desc' => "Itinerary planning, flight & hotel voucher verification, and VFS appointment coordination covering France, Germany, Switzerland, Italy, and 25+ countries.",
                'icon' => 'fa-earth-europe',
                'country_link' => 'europe'
            ],
            [
                'title' => 'Australia & New Zealand Visas',
                'desc' => "Subclass 600 tourist and business visa assistance with genuine temporary entrant (GTE) documentation guidance for {$formattedName} residents.",
                'icon' => 'fa-plane-departure',
                'country_link' => 'australia'
            ],
            [
                'title' => 'UAE & Dubai Express Visa Services',
                'desc' => "Fast-track 30-day and 60-day Dubai tourist and business e-visa processing with minimal documentation.",
                'icon' => 'fa-passport',
                'country_link' => 'uae'
            ]
        ],
        'faqs' => [
            [
                'q' => "Who are the most reliable visa consultants in {$formattedName}?",
                'a' => "Vocation Travels provides trusted, documentation-first visa guidance for travelers and students in {$formattedName}, with high success rates across US, UK, Canada, Schengen, and Australia visas."
            ],
            [
                'q' => "Can {$formattedName} applicants complete the visa process remotely?",
                'a' => "Yes! We coordinate your complete document checklist, form filing, and appointment slot booking online, so {$formattedName} residents only need to visit the nearest VAC/VFS centre for biometrics."
            ],
            [
                'q' => "Do you assist students from {$formattedName} with university visa filing?",
                'a' => "Yes, we guide {$formattedName} students with SOP reviews, proof of funds documentation, and visa interview preparation for universities in the US, UK, Canada, and Australia."
            ],
            [
                'q' => "Does your agency guarantee 100% visa approval?",
                'a' => "No legitimate consultant can guarantee approval as embassies make the final decision. We guarantee error-free applications and strong presentation, minimizing refusal risk."
            ]
        ]
    ];
}

function get_visa_cities()
{
    global $conn;

    $cities = [];
    if ($conn && !$conn->connect_error) {
        $sql = "SELECT * FROM visa_cities WHERE status = 'active' ORDER BY city_order ASC";
        $res = @mysqli_query($conn, $sql);

        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $cities[$row['slug']] = __visa_city_row_to_array($row);
            }
        }
    }

    // Additional prominent Indian cities for full Pan-India coverage if not already in DB
    $additionalProminentCities = [
        'noida' => 'Noida',
        'gurgaon' => 'Gurgaon',
        'goa' => 'Goa',
        'shimla' => 'Shimla',
        'jamshedpur' => 'Jamshedpur',
        'udaipur' => 'Udaipur',
        'jodhpur' => 'Jodhpur',
        'kanpur' => 'Kanpur',
        'allahabad' => 'Prayagraj (Allahabad)'
    ];

    foreach ($additionalProminentCities as $slug => $cName) {
        if (!isset($cities[$slug])) {
            $cities[$slug] = __generate_dynamic_city_profile($slug);
        }
    }

    return $cities;
}

function get_visa_city($slug)
{
    global $conn;

    if ($slug === '') {
        return null;
    }

    if ($conn && !$conn->connect_error) {
        $stmt = @mysqli_prepare($conn, "SELECT * FROM visa_cities WHERE slug = ? AND status = 'active' LIMIT 1");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $slug);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = $result ? mysqli_fetch_assoc($result) : null;
            mysqli_stmt_close($stmt);

            if ($row) {
                return __visa_city_row_to_array($row);
            }
        }
    }

    // Fallback: Check if valid alphanumeric city slug, dynamically generate programmatic profile
    if (preg_match('/^[a-z0-9-]+$/', $slug) && strlen($slug) >= 3 && strlen($slug) <= 40) {
        return __generate_dynamic_city_profile($slug);
    }

    return null;
}
