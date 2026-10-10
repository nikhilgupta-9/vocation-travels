<?php
/**
 * Service Details Enricher
 * Provides comprehensive content, images, features, process steps, FAQs, and trust pillars
 * for all 65 service inner pages at /services/{slug}/.
 */

if (!function_exists('get_service_image')) {
    function get_service_image($slug)
    {
        $image_map = [
            // Tour Packages & Holidays
            'domestic-tour-packages' => 'world-tours.jpg',
            'international-tour-packages' => 'dubai-skyline.png',
            'customized-holiday-packages' => 'tropical-island.png',
            'luxury-travel-packages' => 'luxury-travel.jpg',
            'honeymoon-packages' => 'luxury-travel.jpg',
            'family-vacations' => 'tropical-island.png',
            'group-tours' => 'world-tours.jpg',
            'corporate-tours' => 'corporate-travel.jpg',
            'adventure-tours' => 'adventure-travel.jpg',
            'pilgrimage-tours' => 'world-tours.jpg',
            'educational-tours' => 'world-tours.jpg',
            'cruise-holidays' => 'scenic-cruise.png',
            'multi-country-travel' => 'world-tours.jpg',
            'bespoke-travel' => 'luxury-travel.jpg',

            // Flights & Aviation
            'flight-booking' => 'private-jet.jpg',
            'business-class-flights' => 'private-jet.jpg',
            'private-jet-charter' => 'private-jet.jpg',
            'helicopter-charter' => 'private-jet.jpg',
            'charter-flight-management' => 'private-jet.jpg',

            // Stays & Luxury Accommodations
            'hotel-booking' => 'luxury-hotels.jpg',
            'resort-booking' => 'luxury-hotels.jpg',
            'villa-stays' => 'luxury-travel.jpg',
            'event-accommodation' => 'luxury-hotels.jpg',

            // Ground Transport & Chauffeur
            'airport-transfers' => 'chauffeur-transfers.jpg',
            'chauffeur-services' => 'chauffeur-transfers.jpg',
            'car-rentals' => 'chauffeur-transfers.jpg',
            'ground-transportation' => 'chauffeur-transfers.jpg',
            'group-movement-logistics' => 'chauffeur-transfers.jpg',

            // Visas, Passports, Insurance & Forex
            'visa-assistance' => 'visa-passports.jpg',
            'passport-assistance' => 'visa-passports.jpg',
            'travel-insurance' => 'visa-passports.jpg',
            'forex-assistance' => 'visa-consultation.jpg',

            // Corporate & MICE
            'corporate-travel-management' => 'corporate-travel.jpg',
            'executive-travel' => 'corporate-travel.jpg',
            'mice-services' => 'corporate-travel.jpg',
            'business-meeting-travel' => 'corporate-travel.jpg',
            'conference-travel' => 'corporate-travel.jpg',
            'trade-show-travel' => 'corporate-travel.jpg',
            'corporate-mobility' => 'corporate-travel.jpg',
            'employee-travel-programs' => 'corporate-travel.jpg',
            'incentive-travel' => 'corporate-travel.jpg',
            'travel-procurement' => 'corporate-travel.jpg',
            'travel-consultancy' => 'corporate-travel.jpg',
            'white-label-travel' => 'corporate-travel.jpg',
            'travel-desk-outsourcing' => 'corporate-travel.jpg',

            // Weddings & Social Events
            'destination-wedding-travel' => 'destination-weddings.jpg',
            'wedding-guest-travel' => 'destination-weddings.jpg',
            'event-logistics' => 'destination-weddings.jpg',

            // VIP, Celebrity, Protocol & HNWI
            'vip-celebrity-travel' => 'vip-lifestyle.jpg',
            'hnwi-travel' => 'vip-lifestyle.jpg',
            'luxury-lifestyle-travel' => 'vip-lifestyle.jpg',
            'vip-security' => 'vip-lifestyle.jpg',
            'government-delegation-travel' => 'corporate-travel.jpg',
            'international-delegation' => 'corporate-travel.jpg',
            'film-crew-travel' => 'adventure-travel.jpg',
            'sports-team-travel' => 'adventure-travel.jpg',
            'yacht-charter' => 'scenic-cruise.png',

            // Concierge & Support
            'concierge-services' => 'vip-lifestyle.jpg',
            'airport-meet-greet' => 'chauffeur-transfers.jpg',
            'lounge-access' => 'private-jet.jpg',
            'sightseeing-activities' => 'tropical-island.png',
            '247-travel-support' => 'visa-consultation.jpg',
            'emergency-travel-assistance' => 'visa-consultation.jpg',
            'travel-planning-management' => 'world-tours.jpg',
            'medical-tourism' => 'visa-consultation.jpg',
        ];

        $file = $image_map[$slug] ?? 'world-tours.jpg';
        return 'assets/images/services/' . $file;
    }
}

if (!function_exists('get_service_domain')) {
    function get_service_domain($slug)
    {
        if (preg_match('/(tour|holiday|vacation|trip|safari|cruise|honeymoon)/', $slug)) {
            return 'tour';
        }
        if (preg_match('/(flight|jet|helicopter|aviation|air)/', $slug)) {
            return 'flight';
        }
        if (preg_match('/(hotel|resort|villa|accommodation|stay)/', $slug)) {
            return 'stay';
        }
        if (preg_match('/(transfer|chauffeur|car|ground|transport)/', $slug)) {
            return 'transport';
        }
        if (preg_match('/(visa|passport|insurance|forex)/', $slug)) {
            return 'documentation';
        }
        if (preg_match('/(corporate|executive|mice|business|conference|meeting|trade|employee|incentive|procurement|mobility|outsourcing|white-label)/', $slug)) {
            return 'corporate';
        }
        if (preg_match('/(wedding|guest|event)/', $slug)) {
            return 'wedding';
        }
        if (preg_match('/(vip|celebrity|hnwi|lifestyle|yacht|security|delegation|film|sports)/', $slug)) {
            return 'vip';
        }
        return 'concierge';
    }
}

if (!function_exists('enrich_service')) {
    function enrich_service($slug, $service)
    {
        if (!$service) return null;

        $domain = get_service_domain($slug);
        $name = $service['name'];
        $image = get_service_image($slug);

        // Domain-specific content dictionaries
        $domain_content = [
            'tour' => [
                'tagline' => 'Handcrafted itineraries, handpicked 4-star & 5-star properties, and immersive local experiences planned end-to-end.',
                'overview' => [
                    "At Vocation Travels And Tours, our {$name} service is designed for travelers who demand more than off-the-shelf, cookie-cutter vacations. We believe that true travel is defined by effortless pacing, curated accommodations, and unforgettable cultural connections. Whether you are venturing into India’s royal palaces and serene backwaters or embarking on an exotic overseas voyage, our travel designers customize every day of your itinerary around your personal preferences, schedule, and budget.",
                    "From pre-trip destination briefings and private airport chauffeur transfers to verified local guides and seamless intercity transit, we take complete responsibility for your journey. We negotiate directly with luxury hospitality partners and boutique properties worldwide to deliver contracted, competitive rates with complimentary value additions such as room upgrades, curated breakfast experiences, and priority sightseeing passes.",
                    "Operating across 40+ major Indian hubs — including Delhi NCR, Mumbai, Bengaluru, Hyderabad, Chennai, Pune, Kolkata, and Ahmedabad — as well as international destinations across Europe, the Middle East, Southeast Asia, and the Americas, our dedicated travel desk provides 24/7 on-ground coordination so you can travel with complete peace of mind."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-hotel', 'title' => 'Handpicked 4-Star & 5-Star Stays', 'desc' => 'Rigorous hotel inspections, verified hospitality standards, and central luxury locations close to major attractions.'],
                    ['icon' => 'fa-solid fa-route', 'title' => '100% Customized Day-by-Day Itinerary', 'desc' => 'Flexible scheduling, private sightseeing excursions, and curated experiential stops tailored around your travel style.'],
                    ['icon' => 'fa-solid fa-car', 'title' => 'Private Chauffeur & Sanitized Vehicles', 'desc' => 'Dedicated air-conditioned sedans, SUVs, and luxury coaches with professional, courteous, and background-verified drivers.'],
                    ['icon' => 'fa-solid fa-passport', 'title' => 'Integrated Visa & Documentation Care', 'desc' => 'End-to-end visa filing support, entry requirement verification, and mandatory travel insurance coordination.'],
                    ['icon' => 'fa-solid fa-comments-dollar', 'title' => 'Transparent Pricing, Zero Hidden Fees', 'desc' => 'All-inclusive itemized quotes with clear inclusions, upfront taxes, and flexible payment gateway milestones.'],
                    ['icon' => 'fa-solid fa-headset', 'title' => '24/7 Dedicated Trip Concierge', 'desc' => 'A single point of contact available round-the-clock on WhatsApp and phone for instant changes or on-ground assistance.']
                ],
                'faqs' => [
                    ['q' => "How can I customize our {$name} itinerary?", 'a' => "You can customize every single detail! Simply share your target travel dates, preferred hotels, sightseeing preferences, and budget with our travel designers. We provide a bespoke day-by-day plan within 24 hours that you can modify until it perfectly matches your vision."],
                    ['q' => "Are flights, hotels, and local sightseeing included in the package?", 'a' => "Yes, we can package all domestic and international flights, luxury hotel stays, private intercity transfers, entry monument tickets, and verified local guides into one single comprehensive quotation."],
                    ['q' => "What is your payment and cancellation policy?", 'a' => "We offer flexible payment terms with a modest booking advance and structured milestones. Cancellation terms depend on airline and hotel partner guidelines, and we clearly present all refund windows before you confirm."],
                    ['q' => "Do you provide on-ground support during our vacation?", 'a' => "Absolutely. Every client is assigned a dedicated 24/7 travel desk coordinator who monitors your flight schedules, oversees driver arrivals, and remains on standby via WhatsApp throughout your entire journey."]
                ]
            ],

            'flight' => [
                'tagline' => 'Priority ticketing, business and first-class inventory, and bespoke private charter flight solutions worldwide.',
                'overview' => [
                    "Navigating global air travel requires agility, direct airline access, and deep ticketing expertise. With Vocation Travels’ {$name}, business leaders, families, and discerning travelers enjoy priority flight reservations, competitive corporate fare brackets, and personalized tarmac assistance across all major domestic and global corridors.",
                    "Whether you require urgent multi-city business class itineraries, private jet charters for executive teams, or chartered helicopter connections to remote luxury resorts, our aviation specialists source optimal routing with minimal layovers. We manage seat allocations, special meal preferences, excess baggage clearances, and frequent flyer mileage credits seamlessly.",
                    "In the event of weather disruptions, schedule shifts, or missed connections, our 24/7 flight operations desk intervenes immediately with instant rebooking, priority lounge access, and zero-hold-time customer assistance."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-plane-departure', 'title' => 'Global GDS Airline Inventory Access', 'desc' => 'Direct connections to international and domestic airlines with access to published, corporate, and private fare classes.'],
                    ['icon' => 'fa-solid fa-jet-fighter', 'title' => 'Private Jet & Aircraft Charters', 'desc' => 'Access to light, mid-size, and heavy private jets with private FBO terminal access and personalized in-flight catering.'],
                    ['icon' => 'fa-solid fa-couch', 'title' => 'Business & First Class Specialists', 'desc' => 'Preferred rates on long-haul flat-bed cabins, complimentary lounge passes, and priority check-in arrangements.'],
                    ['icon' => 'fa-solid fa-clock-rotate-left', 'title' => 'Urgent & Last-Minute Bookings', 'desc' => 'Rapid turnaround for urgent corporate delegations, same-day executive travel, and emergency family movements.'],
                    ['icon' => 'fa-solid fa-suitcase-rolling', 'title' => 'Baggage & Seating Management', 'desc' => 'Advance seat assignments, extra baggage pre-clearance, sports equipment handling, and specialized meal requests.'],
                    ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Flight Tracking & Disruption Defense', 'desc' => 'Proactive live monitoring of your flights with instant automated rebooking support in case of delays or cancellations.']
                ],
                'faqs' => [
                    ['q' => "Can you arrange last-minute flight tickets or private charters?", 'a' => "Yes. Our aviation desk operates 24/7 with direct access to private charter fleets and commercial GDS inventories. We frequently arrange executive charters with as little as 4 hours notice."],
                    ['q' => "Do you offer corporate discounts on business class flights?", 'a' => "Yes, through our established corporate partnerships and high-volume ticketing desk, we secure preferred corporate fare rules, reduced change penalties, and competitive pricing across major global carriers."],
                    ['q' => "What happens if our flight gets delayed or cancelled?", 'a' => "Our team tracks your flight status continuously. If an airline reschedules or cancels a flight, our 24/7 desk initiates immediate re-accommodation on the next best available flight without you having to wait in airport queues."],
                    ['q' => "Can you manage group flight bookings for events or delegations?", 'a' => "Yes, we specialize in group flight ticketing for 10 to 500+ passengers with consolidated passenger name manifests, blocked group fares, and flexible name change windows."]
                ]
            ],

            'stay' => [
                'tagline' => 'Preferred corporate rates, five-star luxury hotel suites, and private villa buyouts with exclusive VIP amenities.',
                'overview' => [
                    "A great journey begins with an exceptional stay. With Vocation Travels’ {$name}, travelers and corporate delegations unlock premier hospitality across 5-star international chains, boutique heritage havens, private beachside villas, and prestigious business hotels across India and 120+ countries.",
                    "Through our contracted trade affiliations and direct general manager relationships, our clients enjoy VIP treatment that standard booking engines cannot provide. From complimentary room upgrades and early check-ins to daily gourmet breakfasts, spa credits, and executive club lounge privileges, we ensure your stay is both luxurious and cost-effective.",
                    "Whether you require a single executive suite in Mumbai or London, a private tropical villa in Bali or Goa for a family reunion, or a 200-room hotel buyout for an international conference, we deliver verified quality and seamless billing."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-hotel', 'title' => 'Global 5-Star & Boutique Partnerships', 'desc' => 'Direct contracts with luxury hotel brands: Marriott, Taj, Oberoi, Four Seasons, Hyatt, Accor, and independent boutique estates.'],
                    ['icon' => 'fa-solid fa-star', 'title' => 'Exclusive VIP Perks & Upgrades', 'desc' => 'Complimentary breakfast, early check-in/late checkout subject to availability, room upgrades, and dining credits.'],
                    ['icon' => 'fa-solid fa-house-chimney-window', 'title' => 'Private Villa & Luxury Estate Stays', 'desc' => 'Exclusive private pool villas with dedicated personal chefs, butler services, and full privacy for families and groups.'],
                    ['icon' => 'fa-solid fa-file-invoice-dollar', 'title' => 'Consolidated Corporate Billing & GST', 'desc' => 'Compliant corporate GST invoicing, structured corporate credit facilities, and itemized travel expense reporting.'],
                    ['icon' => 'fa-solid fa-bed', 'title' => 'Rigorous Hygiene & Quality Audits', 'desc' => 'Pre-inspected properties ensuring top-tier safety standards, reliable high-speed Wi-Fi, and prime accessible locations.'],
                    ['icon' => 'fa-solid fa-user-tie', 'title' => 'Dedicated Hotel Concierge Liaison', 'desc' => 'Direct liaison with hotel management to arrange special room setups, VIP welcome amenities, and customized dietary menus.']
                ],
                'faqs' => [
                    ['q' => "How do your hotel rates compare with online booking portals?", 'a' => "Because we hold direct B2B contracted rates and corporate partner volume allocations, our net pricing is highly competitive and often includes complimentary benefits like breakfast, Wi-Fi, and flexible cancellation that retail portals charge extra for."],
                    ['q' => "Can you book private villas with private chefs and staff?", 'a' => "Yes, we have a curated portfolio of luxury private villas across Goa, Rajasthan, Kerala, Bali, Phuket, Dubai, and Europe with dedicated housekeepers, private pools, and personal private chefs."],
                    ['q' => "Do you provide GST invoices for corporate tax input credit?", 'a' => "Yes, 100%. All corporate hotel bookings are issued with compliant GST invoices containing your company name and GSTIN for seamless tax input credit claiming."],
                    ['q' => "What if we need to request an early check-in or late checkout?", 'a' => "We communicate directly with hotel front office management in advance to prioritize early arrivals and extended checkouts for our clients, saving you the hassle of waiting in lobbies."]
                ]
            ],

            'transport' => [
                'tagline' => 'Impeccable executive chauffeurs, luxury airport tarmac transfers, and reliable pan-India fleet management.',
                'overview' => [
                    "Punctuality, safety, and discreet professionalism are the hallmarks of Vocation Travels’ {$name}. Whether you are an executive rushing between boardroom presentations, a VIP arriving on a red-eye international flight, or an organization coordinating logistics for a 500-guest summit, our mobility division ensures seamless ground transit.",
                    "Our premium fleet includes luxury sedans (Mercedes-Benz S/E-Class, BMW 7/5-Series, Audi), executive MPVs (Toyota Vellfire, Innova Hycross/Crysta), and luxury air-conditioned coaches. Every vehicle is thoroughly detailed, sanitized, equipped with GPS tracking, and piloted by an experienced, background-verified chauffeur in professional uniform.",
                    "Available across 40+ Indian metros and Tier-1/2 cities, as well as key international hubs including Dubai, London, Singapore, and New York, our ground transport desk delivers zero-stress, flight-tracked pickups and drop-offs."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-car-side', 'title' => 'Prestige Luxury & Executive Fleet', 'desc' => 'Latest-model Mercedes-Benz, BMW, Audi, Toyota Vellfire, Innova Hycross, and luxury 18 to 45-seater coaches.'],
                    ['icon' => 'fa-solid fa-user-shield', 'title' => 'Vetted, Courteous Chauffeurs', 'desc' => 'English-speaking, background-verified, defensive-driving certified drivers trained in executive protocol and discretion.'],
                    ['icon' => 'fa-solid fa-plane-arrival', 'title' => 'Live Flight Tracking & Zero-Wait Pickups', 'desc' => 'Real-time flight arrival tracking ensures your chauffeur is stationed at the terminal even if your flight lands early or delayed.'],
                    ['icon' => 'fa-solid fa-wifi', 'title' => 'In-Car Executive Comforts', 'desc' => 'Complimentary mineral water, phone chargers, daily newspapers, high-speed Wi-Fi, and spacious climate-controlled cabins.'],
                    ['icon' => 'fa-solid fa-city', 'title' => 'Pan-India & Global Coverage', 'desc' => 'Uniform service quality across Delhi NCR, Mumbai, Bengaluru, Hyderabad, Chennai, Kolkata, Pune, and international hubs.'],
                    ['icon' => 'fa-solid fa-map-location-dot', 'title' => 'End-to-End Event Logistics Management', 'desc' => 'Dedicated on-site transport managers and dispatcher desks for corporate off-sites, conferences, and weddings.']
                ],
                'faqs' => [
                    ['q' => "How does your airport transfer service track flight delays?", 'a' => "Our dispatch software syncs directly with global aviation radar data. If your flight is delayed or rescheduled, your chauffeur’s dispatch time adjusts automatically with zero extra waiting fee."],
                    ['q' => "What vehicles are available for executive car rentals?", 'a' => "We offer luxury sedans (Mercedes-Benz S/E-Class, BMW 7/5-Series), premium MPVs (Toyota Vellfire, Innova Hycross/Crysta), and luxury Volvo/Scania coaches for large groups."],
                    ['q' => "Can we book chauffeur services for multi-day outstation business trips?", 'a' => "Yes, we regularly service multi-city corporate roadshows and outstation executive travel with clear per-kilometer or daily package pricing inclusive of driver allowances and toll taxes."],
                    ['q' => "Are your chauffeurs trained in executive etiquette?", 'a' => "Every chauffeur undergoes extensive background checks, route knowledge training, and VIP etiquette coaching to ensure polite, discreet, and secure transport."]
                ]
            ],

            'documentation' => [
                'tagline' => 'Expert visa filing, accurate embassy documentation, expedited passports, and foreign exchange assistance.',
                'overview' => [
                    "Visa refusals, confusing embassy guidelines, and missed appointments can derail the best-planned trips. With Vocation Travels’ {$name}, individuals, families, students, and corporate groups receive end-to-end guidance from seasoned visa specialists with a 98.7% application accuracy track record.",
                    "Covering high-demand destinations including the USA (B1/B2, F1, H1B), UK, Canada, Schengen Europe (29 countries), Australia, Japan, Dubai/UAE, and Singapore, our consultants review every document line-by-line. We manage application filing, VFS/VAC appointment scheduling, biometric guidance, document apostille, and mock interview preparations.",
                    "Additionally, we provide foreign exchange assistance with multi-currency forex cards and competitive door-step currency delivery, alongside comprehensive overseas travel health and trip cancellation insurance."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-passport', 'title' => 'Embassy Documentation Auditing', 'desc' => 'Rigorous pre-submission verification of invitation letters, bank statements, ITRs, and sponsorship papers to eliminate errors.'],
                    ['icon' => 'fa-solid fa-calendar-check', 'title' => 'Priority Slot & Biometric Scheduling', 'desc' => 'Fast appointment scheduling at VFS, TLScontact, BLS, and embassy consular centers across India.'],
                    ['icon' => 'fa-solid fa-comments', 'title' => 'Consular Mock Interview Preparation', 'desc' => 'One-on-one prep sessions for US B1/B2 and student visa interviews with sample questionnaire coaching.'],
                    ['icon' => 'fa-solid fa-building-columns', 'title' => 'Multi-Currency Forex Cards & Cash', 'desc' => 'Zero-markup travel forex cards, live wholesale exchange rates, and safe doorstep currency delivery.'],
                    ['icon' => 'fa-solid fa-shield-virus', 'title' => 'Comprehensive Overseas Travel Insurance', 'desc' => 'Cashless international medical emergency cover, baggage loss protection, trip cancellation, and Schengen-compliant policies.'],
                    ['icon' => 'fa-solid fa-location-dot', 'title' => 'Pan-India 40+ Cities Remote Assistance', 'desc' => 'Remote document collection, online filing, and local representation for clients in Delhi, Mumbai, Bengaluru, Hyderabad & 40+ cities.']
                ],
                'faqs' => [
                    ['q' => "What is the typical processing time for visas?", 'a' => "Processing times vary by destination. UAE/Dubai takes 24 to 48 hours; Singapore takes 3 to 4 working days; Schengen visas take 10 to 15 working days; while USA and UK depend on current embassy appointment backlogs. We provide live slot tracking."],
                    ['q' => "Do you assist with documents for freelancers, business owners, or sponsored travelers?", 'a' => "Yes, our team specializes in complex documentation profiles including self-employed professionals, corporate business sponsors, family sponsorships, and retired travelers."],
                    ['q' => "Is overseas travel insurance mandatory for international visas?", 'a' => "Yes, Schengen countries, Turkey, and several other destinations require mandatory travel medical insurance with minimum €30,000 coverage. We issue embassy-compliant instant insurance policies."],
                    ['q' => "How can I obtain foreign exchange (Forex) before my flight?", 'a' => "We provide RBI-licensed multi-currency Forex cards and foreign currency cash delivered to your home or office with live interbank exchange rates."]
                ]
            ],

            'corporate' => [
                'tagline' => 'Centralized travel procurement, policy compliance, MICE management, and 24/7 dedicated corporate desks.',
                'overview' => [
                    "Managing corporate travel for dynamic enterprises requires a blend of cost control, policy adherence, executive comfort, and robust duty-of-care. Vocation Travels’ {$name} acts as a seamless extension of your HR, procurement, and administrative teams.",
                    "We service start-ups, mid-market leaders, and multinational corporations across Delhi NCR, Mumbai, Bengaluru, Hyderabad, Chennai, and Pune. From consolidated corporate airline contracts and negotiated corporate hotel tariffs to centralized MICE event logistics and itemized GST-compliant monthly invoicing, we optimize your travel expenditure by up to 22%.",
                    "Our corporate clients benefit from a dedicated Account Manager, automated approval workflows, traveler tracking safety protocols, and emergency 24/7 rebooking assistance."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-handshake-angle', 'title' => 'Dedicated Corporate Travel Desk', 'desc' => 'Experienced corporate travel managers who know your corporate travel policy, traveler preferences, and cost thresholds.'],
                    ['icon' => 'fa-solid fa-chart-line', 'title' => 'Cost Optimization & Volume Savings', 'desc' => 'Pre-negotiated corporate airfares, negotiated corporate hotel discounts, and reduced cancellation penalty slabs.'],
                    ['icon' => 'fa-solid fa-people-group', 'title' => 'End-to-End MICE & Conference Planning', 'desc' => 'Venue sourcing, stage production, delegate registration, airline charters, and gala dinners for 50 to 2,000+ attendees.'],
                    ['icon' => 'fa-solid fa-file-invoice-dollar', 'title' => 'Consolidated Monthly GST Billing', 'desc' => 'Clean, itemized monthly billing statements with 100% compliant state-wise GSTIN details for seamless tax credits.'],
                    ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Duty of Care & Traveler Safety Tracking', 'desc' => 'Real-time traveler tracking during domestic and overseas business trips with proactive emergency evacuation protocols.'],
                    ['icon' => 'fa-solid fa-sliders', 'title' => 'Customized Travel Policy Enforcement', 'desc' => 'Automated tiered authorization workflows that ensure bookings stay within approved departmental travel limits.']
                ],
                'faqs' => [
                    ['q' => "How does your corporate travel management reduce our company's travel expenses?", 'a' => "We aggregate your organization's flight and hotel volume to unlock contracted corporate brackets, eliminate retail booking fees, recommend optimal route combinations, and enforce policy adherence before booking."],
                    ['q' => "Can you handle large-scale MICE events and corporate off-sites?", 'a' => "Yes, our MICE division manages everything: destination selection, hotel room blocks, flight charters, convention hall audiovisuals, team-building activities, and themed gala dinners across India and overseas."],
                    ['q' => "What credit terms and billing models do you offer for businesses?", 'a' => "We provide flexible credit arrangements for verified corporate clients, including revolving credit lines, bi-weekly or monthly statement settlements, and dedicated payment gateway links."],
                    ['q' => "How does your corporate desk support travelers during flight disruptions?", 'a' => "Our team actively monitors all active corporate traveler flights. In case of cancellations, strikes, or delays, our desk initiates priority re-routing immediately without making your executives stand in airport queues."]
                ]
            ],

            'wedding' => [
                'tagline' => 'Flawless guest logistics, palace and beach venue coordination, chartered flights, and luxury hospitality.',
                'overview' => [
                    "A destination wedding is a once-in-a-lifetime celebration where every detail must reflect perfection. Vocation Travels’ {$name} takes the entire burden of guest travel, hotel accommodations, and on-ground logistics off your family's shoulders.",
                    "Whether you are planning a royal heritage wedding in Udaipur or Jaipur, an exotic beach celebration in Goa or Thailand, or an intimate European ceremony in Lake Como, our wedding travel concierge coordinates group airline bookings, chartered flights, personalized airport welcome desks, and luxury coach transfers.",
                    "We liaise directly with venue general managers to oversee seamless guest check-ins, custom welcome hampers, hospitality desk staffing, and 24/7 dedicated dispatchers so your family can focus on celebrating."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-champagne-glasses', 'title' => 'Palace, Resort & Hotel Block Booking', 'desc' => 'Negotiated group room rates at premier heritage palaces, 5-star beachfront resorts, and luxury estates worldwide.'],
                    ['icon' => 'fa-solid fa-plane-circle-check', 'title' => 'Chartered Flights & Group Air Logistics', 'desc' => 'Dedicated aircraft charters and blocked group airline seats coordinating guest arrivals from multiple origin cities.'],
                    ['icon' => 'fa-solid fa-bell-concierge', 'title' => 'Personalized Airport Welcome Desks', 'desc' => 'Custom branded airport reception counters, luggage tagging, and luxury chauffeur transfers directly to the wedding venue.'],
                    ['icon' => 'fa-solid fa-clipboard-user', 'title' => 'On-Site Hospitality & Travel Helpdesk', 'desc' => 'Professional on-ground coordinators stationed at the resort 24/7 to manage guest departures, local tours, and emergencies.'],
                    ['icon' => 'fa-solid fa-car', 'title' => 'Dedicated Event Fleet & Shuttles', 'desc' => 'Continuous luxury shuttles, vintage wedding cars for bridal entries, and chauffeur-driven SUVs for family movements.'],
                    ['icon' => 'fa-solid fa-heart', 'title' => 'Honeymoon Extension Coordination', 'desc' => 'Seamless honeymoon getaway planning for the newlyweds departing directly from the wedding destination.']
                ],
                'faqs' => [
                    ['q' => "How early should we book travel logistics for a destination wedding?", 'a' => "We recommend initiating hotel room blocks and group airline bookings 6 to 9 months in advance, especially for popular destinations like Udaipur, Jaipur, Goa, Bali, or Phuket to secure optimal rates."],
                    ['q' => "Can you manage guests arriving from different cities and countries?", 'a' => "Yes, this is our specialty. We create a consolidated master arrival manifest, tracking incoming flights from 20+ cities, and dispatch tailored chauffeur transfers for each guest arrival."],
                    ['q' => "Do you provide on-site coordinators at the wedding venue?", 'a' => "Yes, we deploy seasoned hospitality coordinators to manage the guest welcome desk, hotel key distribution, luggage assistance, and departure logistics throughout the wedding days."],
                    ['q' => "Can you arrange chartered flights for VIP wedding guests?", 'a' => "Yes, we regularly charter 50 to 180-seater commercial aircraft and private luxury jets for wedding entourages with personalized in-flight branding."]
                ]
            ],

            'vip' => [
                'tagline' => 'Uncompromising discretion, private terminal tarmac transfers, personal security, and bespoke luxury concierges.',
                'overview' => [
                    "For high-profile executives, celebrities, dignitaries, and ultra-high-net-worth individuals, travel must transcend ordinary parameters. Vocation Travels’ {$name} operates with absolute confidentiality, meticulous precision, and white-glove luxury standard.",
                    "From private jet charters with tarmac FBO arrivals and police-liaison security escorts to secluded villa buyouts and superyacht charters, every touchpoint is custom engineered. Our team coordinates directly with personal assistants, family offices, and security details to guarantee zero-friction travel.",
                    "With 24/7 priority access to Michelin-starred dining reservations, private museum viewings, and bespoke lifestyle management across Monaco, London, Dubai, New York, and Indian luxury destinations, we deliver the extraordinary."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-user-secret', 'title' => 'Absolute Discretion & Confidentiality', 'desc' => 'Ironclad NDAs, anonymized hotel check-ins, private elevator access, and confidential passenger manifests.'],
                    ['icon' => 'fa-solid fa-jet-fighter', 'title' => 'Private Jet & Superyacht Charters', 'desc' => 'Unrestricted access to modern Gulfstream, Bombardier, and Falcon private jets, alongside Mediterranean and Caribbean yachts.'],
                    ['icon' => 'fa-solid fa-shield', 'title' => 'VIP Security & Protocol Coordination', 'desc' => 'Close-protection security officers, armored vehicle escorts, and airport customs protocol clearance.'],
                    ['icon' => 'fa-solid fa-door-open', 'title' => 'Direct Tarmac & Private FBO Access', 'desc' => 'Bypass crowded commercial terminals with private VIP suite immigration, customs handling, and tarmac car pickups.'],
                    ['icon' => 'fa-solid fa-gem', 'title' => 'Exclusive Luxury Suite & Estate Buyouts', 'desc' => 'Presidential suites, secluded private islands, and luxury chalet reservations with 24/7 private butlers and chefs.'],
                    ['icon' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Bespoke Lifestyle & Concierge Desk', 'desc' => 'Private shopping appointments, sold-out event VIP passes, and private after-hours monument visits.']
                ],
                'faqs' => [
                    ['q' => "How do you ensure privacy and confidentiality for VIP travelers?", 'a' => "All personnel operate under stringent Non-Disclosure Agreements. We use anonymized booking alias profiles, secure private terminal FBOs, and coordinate with hotel general managers for secluded floors and private entry points."],
                    ['q' => "Can you provide armored vehicles and licensed security escorts?", 'a' => "Yes, we can deploy certified close-protection officers and bulletproof luxury vehicles (Mercedes Maybach, Range Rover Sentinel) across major Indian and global metropolitan centers."],
                    ['q' => "What private jet aircraft do you have access to?", 'a' => "We provide access to light jets (Cessna Citation), mid-size aircraft (Hawker, Phenom), and ultra-long-range heavy jets (Gulfstream G650, Bombardier Global 7500) capable of non-stop intercontinental travel."],
                    ['q' => "How do we coordinate with our dedicated VIP relationship manager?", 'a' => "You and your executive assistant are assigned a dedicated Senior Concierge Director available 24/7/365 via dedicated direct phone, encrypted WhatsApp, and email with immediate response."]
                ]
            ],

            'concierge' => [
                'tagline' => 'Round-the-clock priority travel assistance, airport VIP meet & greet, and personalized lifestyle bookings.',
                'overview' => [
                    "Travel should be defined by effortless enjoyment, not logistical hurdles. Vocation Travels’ {$name} provides discerning travelers with a dedicated, reliable team that handles every request with speed, resourcefulness, and care.",
                    "Whether you require VIP airport meet & greet with porter service through fast-track immigration, access to exclusive airport lounges, curated private sightseeing tours with expert historians, or emergency travel assistance, we are just a message away.",
                    "Backed by over 15 years of industry excellence, our concierge network spans 40+ Indian cities and key global destinations, giving you an insider edge wherever your travels take you."
                ],
                'features' => [
                    ['icon' => 'fa-solid fa-bell-concierge', 'title' => '24/7 Instant One-Message Support', 'desc' => 'Direct WhatsApp and hotline access to seasoned travel coordinators ready to assist with changes, requests, and tips.'],
                    ['icon' => 'fa-solid fa-person-walking-luggage', 'title' => 'Airport VIP Meet & Greet', 'desc' => 'Dedicated airport host greeting you at the jet bridge, managing baggage handling, and guiding you through fast-track lines.'],
                    ['icon' => 'fa-solid fa-couch', 'title' => 'Global Airport Lounge Access', 'desc' => 'Guaranteed premium lounge entry with gourmet dining, quiet workspaces, and shower facilities during transit.'],
                    ['icon' => 'fa-solid fa-ticket', 'title' => 'Curated Sightseeing & Private Excursions', 'desc' => 'Skip-the-line monument tickets, private yacht rentals, helicopter city tours, and private cultural tastings.'],
                    ['icon' => 'fa-solid fa-kit-medical', 'title' => 'Medical & Emergency Travel Coordination', 'desc' => 'Rapid medical visa processing, medical tourism hospital appointments, patient transport, and emergency repatriation.'],
                    ['icon' => 'fa-solid fa-globe', 'title' => 'Multi-City Pan-India Network', 'desc' => 'Uniform executive service standards across Delhi NCR, Mumbai, Bengaluru, Hyderabad, Chennai, Kolkata, and beyond.']
                ],
                'faqs' => [
                    ['q' => "What does the Airport Meet & Greet service include?", 'a' => "A dedicated airport concierge welcomes you at the arrival aero-bridge or departure curb, provides porter luggage assistance, expedites immigration/customs where permitted, and escorts you to your vehicle."],
                    ['q' => "How fast can your team respond to an urgent travel request?", 'a' => "Our concierge desk operates 24/7 with guaranteed response within 15 minutes for existing travelers and under 60 minutes for new service requests."],
                    ['q' => "Can you book sold-out tours, private yachts, or exclusive experiences?", 'a' => "Yes, our extensive global network of vetted luxury suppliers allows us to secure private boat charters, after-hours museum entries, and customized private experiences worldwide."],
                    ['q' => "Is this concierge service available for corporate travelers and families?", 'a' => "Yes, we tailor our concierge support to meet the needs of solo executives, family holidaymakers, elderly travelers requiring assistance, and VIP delegations alike."]
                ]
            ]
        ];

        // Retrieve domain data or fallback to tour
        $d_data = $domain_content[$domain] ?? $domain_content['tour'];

        // Build enriched service object
        $enriched = array_merge($service, [
            'image' => $image,
            'tagline' => $d_data['tagline'],
            'overview' => $d_data['overview'],
            'features' => $d_data['features'],
            'faqs' => $d_data['faqs'],
            'domain' => $domain,
            'process' => [
                [
                    'step' => '01',
                    'title' => 'Requirement Discovery & Consultation',
                    'desc' => "We assess your travel dates, passenger count, preferred luxury tier, and specific preferences to outline the ideal scope for your {$name}."
                ],
                [
                    'step' => '02',
                    'title' => 'Custom Itinerary & Cost Architecture',
                    'desc' => 'Our specialists design a tailor-made day-by-day plan with itemized transparent pricing, negotiated partner discounts, and zero hidden costs.'
                ],
                [
                    'step' => '03',
                    'title' => 'Priority Booking & Document Delivery',
                    'desc' => 'Once approved, we lock in verified hotel rooms, flight tickets, chauffeur dispatch schedules, and deliver your comprehensive digital travel dossier.'
                ],
                [
                    'step' => '04',
                    'title' => '24/7 Real-Time On-Ground Concierge',
                    'desc' => 'Throughout your travel, our dedicated desk monitors your flights, coordinates driver arrivals, and provides instant support via WhatsApp.'
                ]
            ],
            'why_choose' => [
                [
                    'icon' => 'fa-solid fa-award',
                    'title' => 'Established Excellence Since 2011',
                    'desc' => 'Over 15 years of proven track record serving high-profile individuals, families, and corporations with exceptional satisfaction.'
                ],
                [
                    'icon' => 'fa-solid fa-map-location-dot',
                    'title' => 'Pan-India Reach Across 40+ Cities',
                    'desc' => 'Comprehensive remote and local assistance across Delhi NCR, Mumbai, Bengaluru, Hyderabad, Chennai, Kolkata, Pune & nationwide.'
                ],
                [
                    'icon' => 'fa-solid fa-hand-holding-dollar',
                    'title' => 'Contracted Rates & Zero Hidden Fees',
                    'desc' => 'Direct B2B partner agreements with international airlines, 5-star hotel chains, and local fleets delivering maximum value.'
                ],
                [
                    'icon' => 'fa-solid fa-headset',
                    'title' => '24/7 Dedicated Single Point of Contact',
                    'desc' => 'No confusing call center queues. You get a direct dedicated relationship manager available round-the-clock for all your needs.'
                ]
            ]
        ]);

        return $enriched;
    }
}
