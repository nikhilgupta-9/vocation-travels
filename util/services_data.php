<?php
/**
 * Static content source for the Services hub + individual service pages.
 * Each entry drives one crawlable URL at /services/{slug}/.
 */

function get_services()
{
  $services = [

    // ================= CORE SERVICES =================

    'domestic-tour-packages' => [
      'name' => 'Domestic Tour Packages',
      'category' => 'core',
      'order' => 10,
      'icon' => 'fa-solid fa-map-location-dot',
      'description' => 'Hand-picked holiday packages across India\'s most loved destinations — hill stations, beaches, backwaters and heritage cities — planned around your dates, budget and pace.',
      'highlights' => ['Curated itineraries for popular Indian destinations', 'Handpicked stays and local transport included', 'Flexible for couples, families and solo travelers'],
      'meta_title' => 'Domestic Tour Packages India | Vocation Travels And Tours',
      'meta_description' => 'Explore India with curated domestic tour packages covering hill stations, beaches and heritage cities — stays, transport and sightseeing planned end to end.',
      'keywords' => ['domestic tour packages India', 'India holiday packages', 'domestic travel packages'],
    ],
    'international-tour-packages' => [
      'name' => 'International Tour Packages',
      'category' => 'core',
      'order' => 20,
      'icon' => 'fa-solid fa-earth-asia',
      'description' => 'Ready-made and custom international holiday packages to Europe, Southeast Asia, the Middle East and beyond, with flights, stays and local experiences bundled together.',
      'highlights' => ['Popular international circuits pre-planned', 'Visa, flights and hotels coordinated together', 'Local guides and experiences at every stop'],
      'meta_title' => 'International Tour Packages | Vocation Travels And Tours',
      'meta_description' => 'International holiday packages with flights, stays and sightseeing planned together — Europe, Southeast Asia, the Middle East and more, tailored to your travel dates.',
      'keywords' => ['international tour packages India', 'overseas holiday packages', 'international vacation packages'],
    ],
    'customized-holiday-packages' => [
      'name' => 'Customized Holiday Packages',
      'category' => 'core',
      'order' => 30,
      'icon' => 'fa-solid fa-sliders',
      'description' => 'A holiday built entirely around you — choose the destination, pace and inclusions, and we design a day-by-day plan instead of fitting you into a fixed package.',
      'highlights' => ['Fully tailor-made itinerary, not a fixed template', 'Choice of stays, activities and travel class', 'One point of contact from planning to return'],
      'meta_title' => 'Customized Holiday Packages | Vocation Travels And Tours',
      'meta_description' => 'Design your own holiday — pick the destination, pace and inclusions and we build a tailor-made itinerary around your preferences and budget.',
      'keywords' => ['customized holiday packages', 'tailor made travel packages India', 'personalized vacation planning'],
    ],
    'luxury-travel-packages' => [
      'name' => 'Luxury Travel Packages',
      'category' => 'core',
      'order' => 40,
      'icon' => 'fa-solid fa-gem',
      'description' => 'Premium stays, private transfers and curated experiences for travelers who want a refined, hassle-free journey from the moment they leave home.',
      'highlights' => ['Five-star and boutique luxury properties', 'Private transfers and priority arrangements', 'Dedicated concierge-style support throughout'],
      'meta_title' => 'Luxury Travel Packages | Vocation Travels And Tours',
      'meta_description' => 'Curated luxury travel packages with premium stays, private transfers and bespoke experiences for a refined, seamless holiday from start to finish.',
      'keywords' => ['luxury travel packages India', 'luxury holiday planner', 'premium travel packages'],
    ],
    'honeymoon-packages' => [
      'name' => 'Honeymoon Packages',
      'category' => 'core',
      'order' => 50,
      'icon' => 'fa-solid fa-heart',
      'description' => 'Romantic getaways designed for newlyweds — private stays, candlelight dinners and quiet experiences at destinations known for celebrating new beginnings.',
      'highlights' => ['Romantic stays with couple-friendly experiences', 'Beach, hill and international honeymoon options', 'Special touches like dinners and add-on surprises'],
      'meta_title' => 'Honeymoon Packages | Vocation Travels And Tours',
      'meta_description' => 'Romantic honeymoon packages with handpicked stays and private experiences — domestic and international destinations planned for a perfect start.',
      'keywords' => ['honeymoon packages India', 'honeymoon trip planner', 'romantic vacation packages'],
    ],
    'family-vacations' => [
      'name' => 'Family Vacations',
      'category' => 'core',
      'order' => 60,
      'icon' => 'fa-solid fa-people-roof',
      'description' => 'Vacations planned with every family member in mind — kid-friendly stays, comfortable pacing and activities that work across generations.',
      'highlights' => ['Kid-friendly and multi-generation itineraries', 'Comfortable pacing with built-in downtime', 'Family rooms and connecting stays arranged'],
      'meta_title' => 'Family Vacation Packages | Vocation Travels And Tours',
      'meta_description' => 'Family holiday packages built for every generation — comfortable pacing, kid-friendly stays and activities the whole family can enjoy together.',
      'keywords' => ['family vacation packages India', 'family holiday planner', 'family trip packages'],
    ],
    'group-tours' => [
      'name' => 'Group Tours',
      'category' => 'core',
      'order' => 70,
      'icon' => 'fa-solid fa-users',
      'description' => 'Coordinated travel for friend circles, communities and clubs, with group rates, shared logistics and a single itinerary everyone can follow.',
      'highlights' => ['Group rates on stays and transport', 'One consolidated itinerary for the whole group', 'On-ground coordination during the trip'],
      'meta_title' => 'Group Tour Packages | Vocation Travels And Tours',
      'meta_description' => 'Group tour packages with group rates and coordinated logistics for friend circles, communities and clubs traveling together.',
      'keywords' => ['group tour packages India', 'group travel planner', 'group holiday packages'],
    ],
    'corporate-tours' => [
      'name' => 'Corporate Tours',
      'category' => 'core',
      'order' => 80,
      'icon' => 'fa-solid fa-briefcase',
      'description' => 'Off-sites, annual trips and reward outings for companies, planned with the same care as a client-facing event — on budget and on time.',
      'highlights' => ['Off-sites and annual company trips', 'Budget-aligned planning with clear billing', 'Single coordinator for HR and admin teams'],
      'meta_title' => 'Corporate Tour Packages | Vocation Travels And Tours',
      'meta_description' => 'Corporate tour and off-site planning for companies — venues, stays and logistics coordinated with one point of contact for your HR or admin team.',
      'keywords' => ['corporate tour packages India', 'company offsite planning', 'corporate group travel'],
    ],
    'adventure-tours' => [
      'name' => 'Adventure Tours',
      'category' => 'core',
      'order' => 90,
      'icon' => 'fa-solid fa-mountain-sun',
      'description' => 'Treks, safaris and outdoor expeditions for travelers who want more than sightseeing, arranged with vetted operators and safety-first planning.',
      'highlights' => ['Treks, safaris and outdoor expeditions', 'Vetted local operators and equipment', 'Safety briefings and experienced guides'],
      'meta_title' => 'Adventure Tour Packages | Vocation Travels And Tours',
      'meta_description' => 'Adventure travel packages covering treks, safaris and outdoor expeditions, arranged with vetted operators and safety-first planning.',
      'keywords' => ['adventure tour packages India', 'trekking tour packages', 'adventure travel planner'],
    ],
    'pilgrimage-tours' => [
      'name' => 'Pilgrimage Tours',
      'category' => 'core',
      'order' => 100,
      'icon' => 'fa-solid fa-place-of-worship',
      'description' => 'Comfortable, well-paced pilgrimage journeys to major religious sites across India, with stays close to the temple or shrine and support for elderly travelers.',
      'highlights' => ['Popular pilgrimage circuits across India', 'Stays close to temples and shrines', 'Paced comfortably for elderly travelers'],
      'meta_title' => 'Pilgrimage Tour Packages | Vocation Travels And Tours',
      'meta_description' => 'Pilgrimage tour packages to major religious sites across India, with nearby stays and comfortable pacing suited to elderly travelers.',
      'keywords' => ['pilgrimage tour packages India', 'temple tour packages', 'yatra travel packages'],
    ],
    'educational-tours' => [
      'name' => 'Educational Tours',
      'category' => 'core',
      'order' => 110,
      'icon' => 'fa-solid fa-graduation-cap',
      'description' => 'Structured trips for schools and colleges — heritage visits, science centres and industrial tours planned with safety and learning outcomes in mind.',
      'highlights' => ['Curriculum-aligned educational itineraries', 'Safety protocols for student groups', 'Coordination with teachers and institutions'],
      'meta_title' => 'Educational Tour Packages | Vocation Travels And Tours',
      'meta_description' => 'Educational tour packages for schools and colleges — heritage visits, science centres and industrial tours planned with safety in mind.',
      'keywords' => ['educational tour packages India', 'school trip planner', 'student educational tours'],
    ],
    'cruise-holidays' => [
      'name' => 'Cruise Holidays',
      'category' => 'core',
      'order' => 120,
      'icon' => 'fa-solid fa-ship',
      'description' => 'Ocean and river cruise bookings across leading cruise lines, with cabin selection, shore excursions and pre/post-cruise stays handled together.',
      'highlights' => ['Leading cruise lines and routes', 'Cabin selection and shore excursions', 'Pre and post-cruise stays arranged'],
      'meta_title' => 'Cruise Holiday Packages | Vocation Travels And Tours',
      'meta_description' => 'Cruise holiday bookings across leading cruise lines, with cabin selection, shore excursions and pre or post-cruise stays arranged together.',
      'keywords' => ['cruise holiday packages India', 'cruise booking agent', 'ocean cruise packages'],
    ],
    'flight-booking' => [
      'name' => 'Flight Ticket Bookings',
      'category' => 'core',
      'order' => 130,
      'icon' => 'fa-solid fa-plane',
      'description' => 'Domestic and international flight bookings across airlines, with fare comparison, schedule changes and rebooking support handled on your behalf.',
      'highlights' => ['Domestic and international airlines covered', 'Fare comparison across travel dates', 'Support for changes and cancellations'],
      'meta_title' => 'Flight Ticket Booking Services | Vocation Travels And Tours',
      'meta_description' => 'Flight ticket booking across domestic and international airlines, with fare comparison and support for changes, cancellations and rebooking.',
      'keywords' => ['flight ticket booking agent', 'air ticket booking India', 'cheap flight booking service'],
    ],
    'business-class-flights' => [
      'name' => 'Business Class & First Class Reservations',
      'category' => 'core',
      'order' => 140,
      'icon' => 'fa-solid fa-plane-departure',
      'description' => 'Premium cabin bookings for business and first class travel, including fare rules, upgrade options and seat selection across major carriers.',
      'highlights' => ['Business and first class fare sourcing', 'Upgrade and mileage-redemption guidance', 'Seat selection and lounge coordination'],
      'meta_title' => 'Business Class Flight Booking | Vocation Travels And Tours',
      'meta_description' => 'Business and first class flight reservations across major airlines, with fare sourcing, upgrade options and seat selection handled for you.',
      'keywords' => ['business class flight booking', 'first class flight tickets India', 'premium cabin reservations'],
    ],
    'private-jet-charter' => [
      'name' => 'Private Jet Charters',
      'category' => 'core',
      'order' => 150,
      'icon' => 'fa-solid fa-plane-up',
      'description' => 'On-demand private jet charters for business trips, family travel or time-sensitive itineraries, with aircraft selection and ground handling arranged.',
      'highlights' => ['Aircraft selection by route and party size', 'Ground handling and airport slots managed', 'Flexible, on-demand scheduling'],
      'meta_title' => 'Private Jet Charter Services | Vocation Travels And Tours',
      'meta_description' => 'Private jet charter services for business and family travel, with aircraft selection, ground handling and flexible scheduling managed end to end.',
      'keywords' => ['private jet charter India', 'private jet booking', 'charter aircraft services'],
    ],
    'helicopter-charter' => [
      'name' => 'Helicopter Charters',
      'category' => 'core',
      'order' => 160,
      'icon' => 'fa-solid fa-helicopter',
      'description' => 'Helicopter charters for pilgrimage shortcuts, events and time-critical travel between cities, arranged with licensed operators and clear scheduling.',
      'highlights' => ['Point-to-point and pilgrimage charters', 'Licensed, verified operator network', 'Weather-aware scheduling support'],
      'meta_title' => 'Helicopter Charter Services | Vocation Travels And Tours',
      'meta_description' => 'Helicopter charter arrangements for pilgrimage travel, events and time-critical trips, coordinated with licensed operators.',
      'keywords' => ['helicopter charter service India', 'helicopter booking agent', 'chopper charter services'],
    ],
    'hotel-booking' => [
      'name' => 'Hotel Reservations',
      'category' => 'core',
      'order' => 170,
      'icon' => 'fa-solid fa-hotel',
      'description' => 'Hotel bookings across categories and destinations, with negotiated rates, room-type matching and reliable support if plans change.',
      'highlights' => ['Wide network of hotel partners', 'Negotiated rates on select properties', 'Support for date and room changes'],
      'meta_title' => 'Hotel Reservation Services | Vocation Travels And Tours',
      'meta_description' => 'Hotel booking services across destinations and categories, with negotiated rates, room matching and support for date changes.',
      'keywords' => ['hotel booking agent India', 'hotel reservation service', 'corporate hotel booking'],
    ],
    'resort-booking' => [
      'name' => 'Resort Bookings',
      'category' => 'core',
      'order' => 180,
      'icon' => 'fa-solid fa-umbrella-beach',
      'description' => 'Beach, hill and wellness resort bookings with room categories, meal plans and on-property experiences arranged before you arrive.',
      'highlights' => ['Beach, hill and wellness resorts', 'Meal plans and room categories sorted', 'On-property experiences pre-arranged'],
      'meta_title' => 'Resort Booking Services | Vocation Travels And Tours',
      'meta_description' => 'Resort booking assistance across beach, hill and wellness properties, with meal plans, room categories and experiences arranged in advance.',
      'keywords' => ['resort booking agent India', 'beach resort packages', 'wellness resort booking'],
    ],
    'villa-stays' => [
      'name' => 'Villa & Luxury Stay Bookings',
      'category' => 'core',
      'order' => 190,
      'icon' => 'fa-solid fa-house-chimney-window',
      'description' => 'Private villas and luxury independent stays for families and groups who want space, privacy and a home-like base for their holiday.',
      'highlights' => ['Verified private villas and luxury homes', 'Suited for families and larger groups', 'Optional in-villa staff and chef arrangements'],
      'meta_title' => 'Villa & Luxury Stay Bookings | Vocation Travels And Tours',
      'meta_description' => 'Private villa and luxury stay bookings for families and groups seeking privacy, space and a home-like holiday base.',
      'keywords' => ['villa booking India', 'luxury villa stays', 'private pool villa rental'],
    ],
    'airport-transfers' => [
      'name' => 'Airport Transfers',
      'category' => 'core',
      'order' => 200,
      'icon' => 'fa-solid fa-van-shuttle',
      'description' => 'Reliable pickup and drop between the airport and your destination, tracked to your flight timing so you\'re never left waiting.',
      'highlights' => ['Flight-tracked pickup timing', 'Clean, verified vehicles and drivers', 'Available in Hyderabad, Bangalore and beyond'],
      'meta_title' => 'Airport Transfer Services | Vocation Travels And Tours',
      'meta_description' => 'Airport transfer services with flight-tracked pickup timing and verified drivers, available in Hyderabad, Bangalore and other cities.',
      'keywords' => ['airport transfer service Hyderabad', 'airport pickup and drop Bangalore', 'airport cab booking'],
    ],
    'chauffeur-services' => [
      'name' => 'Chauffeur Services',
      'category' => 'core',
      'order' => 210,
      'icon' => 'fa-solid fa-user-tie',
      'description' => 'Trained, professionally dressed chauffeurs for business travel, events and city touring, available on an hourly or full-day basis.',
      'highlights' => ['Trained, professionally presented chauffeurs', 'Hourly and full-day booking options', 'Suited for business travel and events'],
      'meta_title' => 'Chauffeur Driven Car Services | Vocation Travels And Tours',
      'meta_description' => 'Professional chauffeur services for business travel, events and city touring, available on hourly or full-day bookings.',
      'keywords' => ['chauffeur service India', 'chauffeur driven car rental', 'personal driver service'],
    ],
    'car-rentals' => [
      'name' => 'Car Rentals',
      'category' => 'core',
      'order' => 220,
      'icon' => 'fa-solid fa-car',
      'description' => 'Self-drive and driver-assisted car rentals for city use or outstation trips, with a range of vehicles to match group size and budget.',
      'highlights' => ['Self-drive and driver-assisted options', 'Outstation and local rental plans', 'Range of vehicles for every group size'],
      'meta_title' => 'Car Rental Services | Vocation Travels And Tours',
      'meta_description' => 'Car rental services for city and outstation travel, with self-drive and driver-assisted options across a range of vehicle types.',
      'keywords' => ['car rental service India', 'outstation cab booking', 'self drive car rental'],
    ],
    'ground-transportation' => [
      'name' => 'Ground Transportation Management',
      'category' => 'core',
      'order' => 230,
      'icon' => 'fa-solid fa-route',
      'description' => 'End-to-end coordination of vehicles, drivers and schedules for multi-city itineraries, events and groups moving through several locations.',
      'highlights' => ['Coordinated vehicles across multiple cities', 'Single schedule for drivers and routes', 'Built for events and multi-stop itineraries'],
      'meta_title' => 'Ground Transportation Management | Vocation Travels And Tours',
      'meta_description' => 'Ground transportation management coordinating vehicles, drivers and schedules across multi-city itineraries and events.',
      'keywords' => ['ground transportation management India', 'transport logistics for events', 'multi city travel coordination'],
    ],
    'visa-assistance' => [
      'name' => 'Visa Assistance & Documentation',
      'category' => 'core',
      'order' => 240,
      'icon' => 'fa-solid fa-passport',
      'description' => 'End-to-end visa support — document checklists, form filling and appointment scheduling — for tourist, business and family-visit visas worldwide.',
      'highlights' => ['Document checklist tailored to your visa type', 'Form filing and appointment scheduling', 'Covers tourist, business and family visas'],
      'meta_title' => 'Visa Assistance Services | Vocation Travels And Tours',
      'meta_description' => 'Visa assistance and documentation support covering tourist, business and family-visit visas, from checklists to appointment scheduling.',
      'keywords' => ['visa assistance services India', 'visa documentation help', 'visa application support'],
    ],
    'passport-assistance' => [
      'name' => 'Passport Assistance',
      'category' => 'core',
      'order' => 250,
      'icon' => 'fa-solid fa-id-card',
      'description' => 'Guidance for fresh passport applications, renewals and corrections, including Passport Seva appointment booking and document verification.',
      'highlights' => ['Fresh application, renewal and correction support', 'Passport Seva appointment guidance', 'Document verification before submission'],
      'meta_title' => 'Passport Assistance Services | Vocation Travels And Tours',
      'meta_description' => 'Passport assistance for fresh applications, renewals and corrections, including appointment guidance and document verification.',
      'keywords' => ['passport assistance service India', 'passport renewal help', 'passport application agent'],
    ],
    'travel-insurance' => [
      'name' => 'Travel Insurance',
      'category' => 'core',
      'order' => 260,
      'icon' => 'fa-solid fa-shield-halved',
      'description' => 'Travel insurance plans matched to your destination and trip type, covering medical emergencies, trip cancellation and baggage loss.',
      'highlights' => ['Plans matched to destination and trip length', 'Medical, cancellation and baggage cover', 'Guidance on claims if needed'],
      'meta_title' => 'Travel Insurance Services | Vocation Travels And Tours',
      'meta_description' => 'Travel insurance plans covering medical emergencies, trip cancellation and baggage loss, matched to your destination and trip type.',
      'keywords' => ['travel insurance India', 'international travel insurance plans', 'trip insurance booking'],
    ],
    'corporate-travel-management' => [
      'name' => 'Corporate Travel Management',
      'category' => 'core',
      'order' => 270,
      'icon' => 'fa-solid fa-building',
      'description' => 'A single travel desk handling flights, hotels and approvals for your company\'s business travel, with reporting your finance team can use.',
      'highlights' => ['Dedicated corporate travel desk', 'Policy-compliant booking and approvals', 'Consolidated billing and travel reports'],
      'meta_title' => 'Corporate Travel Management Company | Vocation Travels And Tours',
      'meta_description' => 'Corporate travel management with a dedicated desk for flights, hotels and approvals, plus consolidated billing and reporting.',
      'keywords' => ['corporate travel management company India', 'business travel management services', 'corporate travel agency'],
    ],
    'executive-travel' => [
      'name' => 'Executive Travel Management',
      'category' => 'core',
      'order' => 280,
      'icon' => 'fa-solid fa-crown',
      'description' => 'Priority handling for leadership travel — preferred routings, faster approvals and discreet support for senior executives on the move.',
      'highlights' => ['Priority routing and preferred fare classes', 'Faster approvals for last-minute travel', 'Discreet, dedicated point of contact'],
      'meta_title' => 'Executive Travel Management | Vocation Travels And Tours',
      'meta_description' => 'Executive travel management with priority routing, faster approvals and dedicated, discreet support for senior leadership travel.',
      'keywords' => ['executive travel management India', 'CXO travel planning', 'leadership travel services'],
    ],
    'mice-services' => [
      'name' => 'MICE Services (Meetings, Incentives, Conferences & Exhibitions)',
      'category' => 'core',
      'order' => 290,
      'icon' => 'fa-solid fa-handshake',
      'description' => 'Full MICE planning — venues, delegate travel, accommodation and on-ground logistics — for meetings, incentive trips, conferences and exhibitions.',
      'highlights' => ['Venue sourcing and delegate travel together', 'Incentive trip design for teams', 'On-ground logistics during the event'],
      'meta_title' => 'MICE Services India | Vocation Travels And Tours',
      'meta_description' => 'MICE services covering venues, delegate travel and on-ground logistics for meetings, incentive trips, conferences and exhibitions.',
      'keywords' => ['MICE services India', 'MICE event management company', 'incentive conference travel planner'],
    ],
    'business-meeting-travel' => [
      'name' => 'Business Meeting Travel Coordination',
      'category' => 'core',
      'order' => 300,
      'icon' => 'fa-solid fa-calendar-check',
      'description' => 'Travel and stay arrangements built around a single meeting or a short business trip, timed tightly so schedules aren\'t wasted.',
      'highlights' => ['Itinerary built around meeting timings', 'Same-day and short-turnaround trips handled', 'Local transport between venues arranged'],
      'meta_title' => 'Business Meeting Travel Coordination | Vocation Travels And Tours',
      'meta_description' => 'Business meeting travel coordination with itineraries timed to your schedule, including local transport between venues.',
      'keywords' => ['business meeting travel planner', 'corporate meeting travel coordination', 'short business trip planning'],
    ],
    'conference-travel' => [
      'name' => 'Conference & Seminar Travel Arrangements',
      'category' => 'core',
      'order' => 310,
      'icon' => 'fa-solid fa-microphone',
      'description' => 'Coordinated travel for speakers, delegates and attendees heading to the same conference, with group rates and shared scheduling.',
      'highlights' => ['Group travel for speakers and delegates', 'Coordinated arrival and departure schedules', 'Group rates on flights and stays'],
      'meta_title' => 'Conference & Seminar Travel Services | Vocation Travels And Tours',
      'meta_description' => 'Conference and seminar travel arrangements for speakers, delegates and attendees, with group rates and coordinated scheduling.',
      'keywords' => ['conference travel management', 'seminar travel arrangements India', 'delegate travel coordination'],
    ],
    'trade-show-travel' => [
      'name' => 'Trade Show & Exhibition Travel Management',
      'category' => 'core',
      'order' => 320,
      'icon' => 'fa-solid fa-store',
      'description' => 'Travel planning for exhibitors and teams attending trade shows, including stays near the venue and logistics for booth staff rotations.',
      'highlights' => ['Stays close to the exhibition venue', 'Logistics for booth staff rotations', 'Support across multi-day exhibition schedules'],
      'meta_title' => 'Trade Show Travel Management | Vocation Travels And Tours',
      'meta_description' => 'Trade show and exhibition travel management for exhibitor teams, with venue-adjacent stays and staff rotation logistics handled.',
      'keywords' => ['trade show travel management', 'exhibition travel planning India', 'exhibitor travel services'],
    ],
    'destination-wedding-travel' => [
      'name' => 'Destination Wedding Travel Management',
      'category' => 'core',
      'order' => 330,
      'icon' => 'fa-solid fa-ring',
      'description' => 'Travel and stay planning for destination weddings — venue-linked accommodation, guest transport and timing coordinated around the event schedule.',
      'highlights' => ['Venue-linked accommodation blocks', 'Guest transport and arrival coordination', 'Timeline built around wedding events'],
      'meta_title' => 'Destination Wedding Travel Management | Vocation Travels',
      'meta_description' => 'Destination wedding travel management covering accommodation, guest transport and scheduling built around your wedding events.',
      'keywords' => ['destination wedding planner India', 'destination wedding travel management', 'wedding guest travel coordination'],
    ],
    'wedding-guest-travel' => [
      'name' => 'Wedding Guest Travel Coordination',
      'category' => 'core',
      'order' => 340,
      'icon' => 'fa-solid fa-champagne-glasses',
      'description' => 'A single point of coordination for flights, stays and transfers of wedding guests arriving from different cities, so no one is left figuring it out alone.',
      'highlights' => ['Consolidated bookings for guests from multiple cities', 'Shared transfer schedules for events', 'One helpline for guest travel queries'],
      'meta_title' => 'Wedding Guest Travel Coordination | Vocation Travels And Tours',
      'meta_description' => 'Wedding guest travel coordination handling flights, stays and transfers for guests arriving from multiple cities.',
      'keywords' => ['wedding guest travel coordination', 'wedding travel management India', 'guest logistics for weddings'],
    ],
    'event-logistics' => [
      'name' => 'Event Travel & Logistics Management',
      'category' => 'core',
      'order' => 350,
      'icon' => 'fa-solid fa-truck-fast',
      'description' => 'Travel, stay and on-ground movement planning for corporate and social events, keeping attendees, equipment and schedules in sync.',
      'highlights' => ['Attendee travel and stay coordination', 'On-ground movement planning', 'Equipment and vendor logistics support'],
      'meta_title' => 'Event Travel & Logistics Management | Vocation Travels And Tours',
      'meta_description' => 'Event travel and logistics management covering attendee travel, on-ground movement and vendor coordination for corporate and social events.',
      'keywords' => ['event travel management India', 'event logistics company', 'event travel planner'],
    ],
    'vip-celebrity-travel' => [
      'name' => 'VIP & Celebrity Travel Management',
      'category' => 'core',
      'order' => 360,
      'icon' => 'fa-solid fa-star',
      'description' => 'Discreet, high-touch travel arrangements for VIPs and public figures, including private transfers, secure scheduling and on-call support.',
      'highlights' => ['Discreet, high-touch travel handling', 'Private transfers and secure scheduling', 'On-call support throughout the trip'],
      'meta_title' => 'VIP & Celebrity Travel Management | Vocation Travels And Tours',
      'meta_description' => 'VIP and celebrity travel management with discreet, high-touch arrangements, private transfers and on-call support.',
      'keywords' => ['VIP travel management India', 'celebrity travel services', 'high profile travel arrangements'],
    ],
    'sports-team-travel' => [
      'name' => 'Sports Team Travel Management',
      'category' => 'core',
      'order' => 370,
      'icon' => 'fa-solid fa-futbol',
      'description' => 'Group travel planning for sports teams and support staff, including equipment transport, match-day logistics and accommodation near venues.',
      'highlights' => ['Team and support staff travel together', 'Equipment transport arranged', 'Stays close to match venues'],
      'meta_title' => 'Sports Team Travel Management | Vocation Travels And Tours',
      'meta_description' => 'Sports team travel management covering group travel, equipment transport and venue-adjacent stays for teams and support staff.',
      'keywords' => ['sports team travel management', 'team travel logistics India', 'sports tour operator'],
    ],
    'government-delegation-travel' => [
      'name' => 'Government & Delegation Travel Management',
      'category' => 'core',
      'order' => 380,
      'icon' => 'fa-solid fa-landmark',
      'description' => 'Protocol-aware travel planning for government and official delegations, coordinating security clearances, schedules and local liaison.',
      'highlights' => ['Protocol-aware itinerary planning', 'Coordination with security and liaison teams', 'Handled with strict confidentiality'],
      'meta_title' => 'Government Delegation Travel Management | Vocation Travels',
      'meta_description' => 'Government and delegation travel management with protocol-aware planning, security coordination and confidential handling.',
      'keywords' => ['government delegation travel management', 'official delegation travel India', 'protocol travel coordination'],
    ],
    'medical-tourism' => [
      'name' => 'Medical Tourism Arrangements',
      'category' => 'core',
      'order' => 390,
      'icon' => 'fa-solid fa-briefcase-medical',
      'description' => 'Travel, stay and local support for patients and attendants visiting India or abroad for treatment, coordinated around hospital schedules.',
      'highlights' => ['Travel coordinated around hospital appointments', 'Stays near hospitals for patients and attendants', 'Local transport for follow-up visits'],
      'meta_title' => 'Medical Tourism Travel Arrangements | Vocation Travels And Tours',
      'meta_description' => 'Medical tourism travel arrangements for patients and attendants, with stays and local transport coordinated around hospital schedules.',
      'keywords' => ['medical tourism India', 'medical travel arrangements', 'patient travel assistance'],
    ],
    'concierge-services' => [
      'name' => 'Concierge Services',
      'category' => 'core',
      'order' => 400,
      'icon' => 'fa-solid fa-concierge-bell',
      'description' => 'On-demand assistance for reservations, tickets and local arrangements while you travel, so small requests never become a distraction.',
      'highlights' => ['Restaurant, show and event reservations', 'Local arrangements handled on request', 'Available throughout your trip'],
      'meta_title' => 'Travel Concierge Services | Vocation Travels And Tours',
      'meta_description' => 'On-demand travel concierge services covering reservations, tickets and local arrangements throughout your trip.',
      'keywords' => ['travel concierge services India', 'concierge service for travelers', 'personal travel assistant'],
    ],
    'airport-meet-greet' => [
      'name' => 'Airport Meet & Greet Services',
      'category' => 'core',
      'order' => 410,
      'icon' => 'fa-solid fa-handshake-angle',
      'description' => 'A representative waiting at arrivals to assist with baggage, immigration queues and onward transfer, especially useful for first-time or elderly travelers.',
      'highlights' => ['Representative present at arrivals', 'Help with baggage and immigration queues', 'Smooth handover to onward transfer'],
      'meta_title' => 'Airport Meet & Greet Services | Vocation Travels And Tours',
      'meta_description' => 'Airport meet and greet services with a representative assisting at arrivals, baggage and immigration, especially for first-time travelers.',
      'keywords' => ['airport meet and greet service India', 'airport assistance service', 'VIP airport handling'],
    ],
    'lounge-access' => [
      'name' => 'Lounge Access Arrangements',
      'category' => 'core',
      'order' => 420,
      'icon' => 'fa-solid fa-couch',
      'description' => 'Airport lounge access arranged for long layovers or early check-ins, so waiting time is spent comfortably instead of at the gate.',
      'highlights' => ['Lounge access for layovers and early arrivals', 'Available at major domestic and international airports', 'Booked in advance of travel'],
      'meta_title' => 'Airport Lounge Access Arrangements | Vocation Travels And Tours',
      'meta_description' => 'Airport lounge access arrangements for long layovers and early check-ins at major domestic and international airports.',
      'keywords' => ['airport lounge access India', 'airport lounge booking', 'lounge pass for travelers'],
    ],
    'sightseeing-activities' => [
      'name' => 'Sightseeing & Activity Bookings',
      'category' => 'core',
      'order' => 430,
      'icon' => 'fa-solid fa-camera',
      'description' => 'City tours, day trips and activity tickets booked in advance so you skip the queues and spend more time actually seeing the place.',
      'highlights' => ['City tours and day trips pre-booked', 'Skip-the-queue tickets where available', 'Local guides for major attractions'],
      'meta_title' => 'Sightseeing & Activity Booking Services | Vocation Travels',
      'meta_description' => 'Sightseeing and activity bookings covering city tours, day trips and attraction tickets, arranged ahead of your travel dates.',
      'keywords' => ['sightseeing tour booking India', 'activity booking for travelers', 'city tour packages'],
    ],
    'forex-assistance' => [
      'name' => 'Foreign Exchange Assistance',
      'category' => 'core',
      'order' => 440,
      'icon' => 'fa-solid fa-money-bill-transfer',
      'description' => 'Currency exchange and forex card assistance at competitive rates, so you leave with the right currency and no last-minute airport markups.',
      'highlights' => ['Competitive currency exchange rates', 'Forex card and cash options', 'Doorstep delivery where available'],
      'meta_title' => 'Foreign Exchange Services | Vocation Travels And Tours',
      'meta_description' => 'Foreign exchange assistance with competitive currency rates and forex card options, arranged ahead of your international trip.',
      'keywords' => ['forex services for travelers India', 'currency exchange agent', 'forex card booking'],
    ],
    '247-travel-support' => [
      'name' => '24/7 Travel Support',
      'category' => 'core',
      'order' => 450,
      'icon' => 'fa-solid fa-headset',
      'description' => 'A helpline that stays reachable around the clock, so a missed connection or a change of plan is sorted while you\'re still at the airport.',
      'highlights' => ['Round-the-clock helpline access', 'Support for missed connections and rebooking', 'Same team, reachable across time zones'],
      'meta_title' => '24/7 Travel Support Services | Vocation Travels And Tours',
      'meta_description' => 'Round-the-clock travel support for missed connections, last-minute changes and on-trip assistance, reachable across time zones.',
      'keywords' => ['24 7 travel support India', 'travel helpline service', 'emergency travel helpline'],
    ],
    'emergency-travel-assistance' => [
      'name' => 'Emergency Travel Assistance',
      'category' => 'core',
      'order' => 460,
      'icon' => 'fa-solid fa-truck-medical',
      'description' => 'Fast rebooking and local support when a trip is disrupted by a medical emergency, lost documents or a sudden itinerary change.',
      'highlights' => ['Fast rebooking during disruptions', 'Support for lost documents while traveling', 'Local assistance coordinated on short notice'],
      'meta_title' => 'Emergency Travel Assistance | Vocation Travels And Tours',
      'meta_description' => 'Emergency travel assistance for disrupted trips, lost documents and sudden itinerary changes, with fast rebooking support.',
      'keywords' => ['emergency travel assistance India', 'travel emergency helpline', 'last minute travel help'],
    ],
    'travel-planning-management' => [
      'name' => 'End-to-End Travel Planning & Management',
      'category' => 'core',
      'order' => 470,
      'icon' => 'fa-solid fa-map',
      'description' => 'Every moving part of a trip — flights, stays, transfers, visas and activities — planned and managed under one roof from first enquiry to return.',
      'highlights' => ['Every element planned under one roof', 'Single point of contact throughout', 'Managed from enquiry through to return'],
      'meta_title' => 'End-to-End Travel Planning | Vocation Travels And Tours',
      'meta_description' => 'End-to-end travel planning and management covering flights, stays, transfers, visas and activities under one point of contact.',
      'keywords' => ['end to end travel planning India', 'complete travel management', 'full service travel agency'],
    ],

    // ================= SPECIALIZED SERVICES =================

    'corporate-mobility' => [
      'name' => 'Corporate Mobility Solutions',
      'category' => 'specialized',
      'order' => 10,
      'icon' => 'fa-solid fa-diagram-project',
      'description' => 'A structured travel program for companies with recurring travel needs, combining policy, preferred vendors and reporting into one system.',
      'highlights' => ['Travel policy design and enforcement', 'Preferred vendor and rate agreements', 'Usage reporting for finance teams'],
      'meta_title' => 'Corporate Mobility Solutions | Vocation Travels And Tours',
      'meta_description' => 'Corporate mobility solutions combining travel policy, preferred vendor rates and reporting into one managed program for companies.',
      'keywords' => ['corporate mobility solutions India', 'business travel program management', 'corporate travel policy design'],
    ],
    'employee-travel-programs' => [
      'name' => 'Employee Travel Programs',
      'category' => 'specialized',
      'order' => 20,
      'icon' => 'fa-solid fa-user-group',
      'description' => 'Standardized travel booking and approval workflows for employees, keeping trips within policy without slowing teams down.',
      'highlights' => ['Standardized booking workflow for staff', 'Policy limits applied automatically', 'Quick approvals for routine trips'],
      'meta_title' => 'Employee Travel Program Management | Vocation Travels And Tours',
      'meta_description' => 'Employee travel program management with standardized booking workflows and policy-compliant approvals for growing teams.',
      'keywords' => ['employee travel program', 'staff travel management India', 'corporate travel booking system'],
    ],
    'incentive-travel' => [
      'name' => 'Incentive Travel Programs',
      'category' => 'specialized',
      'order' => 30,
      'icon' => 'fa-solid fa-trophy',
      'description' => 'Reward trips designed to recognize top performers, blending a memorable destination with a program teams actually look forward to.',
      'highlights' => ['Destination and experience design for reward trips', 'Group logistics for top-performer batches', 'Memorable, brand-aligned experiences'],
      'meta_title' => 'Incentive Travel Program Planning | Vocation Travels And Tours',
      'meta_description' => 'Incentive travel program planning designed to reward top performers with memorable, well-organized group trips.',
      'keywords' => ['incentive travel programs India', 'employee reward trip planning', 'incentive travel company'],
    ],
    'luxury-lifestyle-travel' => [
      'name' => 'Luxury Lifestyle Travel',
      'category' => 'specialized',
      'order' => 40,
      'icon' => 'fa-solid fa-crown',
      'description' => 'Travel curated around personal taste — private dining, exclusive access and rare experiences for clients who expect the extraordinary.',
      'highlights' => ['Private dining and exclusive access arranged', 'Rare, hard-to-book experiences sourced', 'Fully personalized, taste-led planning'],
      'meta_title' => 'Luxury Lifestyle Travel Services | Vocation Travels And Tours',
      'meta_description' => 'Luxury lifestyle travel curated around personal taste, with private dining, exclusive access and rare experiences arranged.',
      'keywords' => ['luxury lifestyle travel India', 'exclusive travel experiences', 'bespoke luxury travel planner'],
    ],
    'film-crew-travel' => [
      'name' => 'Film & Production Crew Travel',
      'category' => 'specialized',
      'order' => 50,
      'icon' => 'fa-solid fa-clapperboard',
      'description' => 'Bulk travel and stay bookings for film and production crews, coordinated around shooting schedules, equipment moves and location shifts.',
      'highlights' => ['Bulk bookings aligned to shoot schedules', 'Equipment and unit transport coordinated', 'Support across changing location shifts'],
      'meta_title' => 'Film & Production Crew Travel Management | Vocation Travels',
      'meta_description' => 'Film and production crew travel management coordinating bulk bookings, equipment transport and stays around shoot schedules.',
      'keywords' => ['film crew travel management', 'production travel logistics India', 'unit travel coordination'],
    ],
    'charter-flight-management' => [
      'name' => 'Charter Flight Management',
      'category' => 'specialized',
      'order' => 60,
      'icon' => 'fa-solid fa-plane-circle-check',
      'description' => 'End-to-end charter flight sourcing for groups and cargo, handling aircraft selection, permissions and scheduling in one place.',
      'highlights' => ['Aircraft sourcing for group and cargo charters', 'Permissions and slot coordination handled', 'Single point of contact for scheduling'],
      'meta_title' => 'Charter Flight Management Services | Vocation Travels And Tours',
      'meta_description' => 'Charter flight management for groups and cargo, covering aircraft sourcing, permissions and scheduling end to end.',
      'keywords' => ['charter flight management India', 'group charter flight booking', 'aircraft charter services'],
    ],
    'yacht-charter' => [
      'name' => 'Yacht Charter Arrangements',
      'category' => 'specialized',
      'order' => 70,
      'icon' => 'fa-solid fa-sailboat',
      'description' => 'Yacht charters for private events, celebrations and leisure sailing, with crew, catering and route planning arranged through vetted partners.',
      'highlights' => ['Vetted yacht partners across destinations', 'Crew and catering arranged together', 'Route planning for private events'],
      'meta_title' => 'Yacht Charter Arrangements | Vocation Travels And Tours',
      'meta_description' => 'Yacht charter arrangements for private events and leisure sailing, with crew, catering and route planning handled together.',
      'keywords' => ['yacht charter India', 'private yacht booking', 'luxury yacht rental'],
    ],
    'hnwi-travel' => [
      'name' => 'High-Net-Worth Individual (HNWI) Travel Services',
      'category' => 'specialized',
      'order' => 80,
      'icon' => 'fa-solid fa-coins',
      'description' => 'Discreet, fully managed travel for high-net-worth clients — private aviation, security-aware planning and a single trusted point of contact.',
      'highlights' => ['Private aviation and priority arrangements', 'Security-aware, discreet planning', 'One trusted contact for every request'],
      'meta_title' => 'HNWI Travel Services | Vocation Travels And Tours',
      'meta_description' => 'Discreet, fully managed travel services for high-net-worth clients, covering private aviation and security-aware planning.',
      'keywords' => ['HNWI travel services India', 'high net worth travel management', 'private client travel concierge'],
    ],
    'international-delegation' => [
      'name' => 'International Delegation Management',
      'category' => 'specialized',
      'order' => 90,
      'icon' => 'fa-solid fa-globe',
      'description' => 'Multi-country delegation logistics — visas, transfers and schedules across several stops — kept consistent for every member of the delegation.',
      'highlights' => ['Visas and transfers across multiple countries', 'Consistent scheduling for every delegate', 'Single coordinator across the full trip'],
      'meta_title' => 'International Delegation Travel Management | Vocation Travels',
      'meta_description' => 'International delegation management covering visas, transfers and scheduling across multiple countries for every delegate.',
      'keywords' => ['international delegation management', 'delegation travel logistics India', 'multi country delegation travel'],
    ],
    'multi-country-travel' => [
      'name' => 'Multi-Country Travel Planning',
      'category' => 'specialized',
      'order' => 100,
      'icon' => 'fa-solid fa-route',
      'description' => 'Itineraries spanning several countries, sequenced to minimize backtracking and matched with the right visas and connecting flights.',
      'highlights' => ['Routes sequenced to reduce backtracking', 'Visas matched to each leg of the trip', 'Connecting flights and transfers aligned'],
      'meta_title' => 'Multi-Country Travel Planning | Vocation Travels And Tours',
      'meta_description' => 'Multi-country travel planning with itineraries sequenced efficiently and visas, flights and transfers matched to every leg.',
      'keywords' => ['multi country tour planning India', 'multi destination trip planner', 'multi country visa travel'],
    ],
    'travel-procurement' => [
      'name' => 'Travel Procurement & Vendor Management',
      'category' => 'specialized',
      'order' => 110,
      'icon' => 'fa-solid fa-file-invoice-dollar',
      'description' => 'Vendor sourcing, rate negotiation and contract management for organizations that need a structured, auditable travel supply chain.',
      'highlights' => ['Vendor sourcing and rate negotiation', 'Contract management and renewals', 'Auditable, structured procurement process'],
      'meta_title' => 'Travel Procurement & Vendor Management | Vocation Travels',
      'meta_description' => 'Travel procurement and vendor management covering sourcing, rate negotiation and contract management for organizations.',
      'keywords' => ['travel procurement services India', 'travel vendor management', 'corporate travel sourcing'],
    ],
    'travel-consultancy' => [
      'name' => 'Travel Consultancy & Advisory Services',
      'category' => 'specialized',
      'order' => 120,
      'icon' => 'fa-solid fa-comments',
      'description' => 'Independent advice on travel policy, vendor selection and program design for organizations building or restructuring a travel function.',
      'highlights' => ['Travel policy review and design', 'Vendor and program recommendations', 'Advisory support during restructuring'],
      'meta_title' => 'Travel Consultancy & Advisory Services | Vocation Travels',
      'meta_description' => 'Travel consultancy and advisory services covering policy design, vendor selection and program recommendations for organizations.',
      'keywords' => ['travel consultancy services India', 'corporate travel advisory', 'travel program consulting'],
    ],
    'event-accommodation' => [
      'name' => 'Event Accommodation Management',
      'category' => 'specialized',
      'order' => 130,
      'icon' => 'fa-solid fa-bed',
      'description' => 'Room blocks and accommodation allotments managed for conferences, weddings and large events, with rooming lists handled centrally.',
      'highlights' => ['Room blocks negotiated for large events', 'Centralized rooming list management', 'Coordination with venues and hotels'],
      'meta_title' => 'Event Accommodation Management | Vocation Travels And Tours',
      'meta_description' => 'Event accommodation management covering room blocks and rooming lists for conferences, weddings and large events.',
      'keywords' => ['event accommodation management India', 'room block booking for events', 'conference hotel booking'],
    ],
    'group-movement-logistics' => [
      'name' => 'Large Group Movement & Logistics',
      'category' => 'specialized',
      'order' => 140,
      'icon' => 'fa-solid fa-bus',
      'description' => 'Movement planning for large groups — buses, flights and check-ins sequenced so hundreds of travelers move without bottlenecks.',
      'highlights' => ['Transport sequencing for large batches', 'Check-in and boarding coordination', 'On-ground staff for smooth movement'],
      'meta_title' => 'Large Group Movement & Logistics | Vocation Travels And Tours',
      'meta_description' => 'Large group movement and logistics planning, sequencing transport and check-ins so large batches of travelers move smoothly.',
      'keywords' => ['large group travel logistics India', 'bulk group movement planning', 'mass travel coordination'],
    ],
    'vip-security' => [
      'name' => 'VIP Security & Protocol Coordination',
      'category' => 'specialized',
      'order' => 150,
      'icon' => 'fa-solid fa-user-shield',
      'description' => 'Travel arrangements coordinated alongside security and protocol teams for VIPs, keeping routes, timing and access tightly managed.',
      'highlights' => ['Coordination with security and protocol teams', 'Route and timing kept tightly managed', 'Access arrangements at venues and airports'],
      'meta_title' => 'VIP Security & Protocol Coordination | Vocation Travels And Tours',
      'meta_description' => 'VIP security and protocol coordination for travel, managing routes, timing and venue access alongside security teams.',
      'keywords' => ['VIP protocol coordination India', 'VIP security travel arrangements', 'dignitary travel management'],
    ],
    'bespoke-travel' => [
      'name' => 'Bespoke Travel Experiences',
      'category' => 'specialized',
      'order' => 160,
      'icon' => 'fa-solid fa-wand-magic-sparkles',
      'description' => 'One-off experiences built from scratch around a client\'s specific request, when nothing off the shelf quite fits the occasion.',
      'highlights' => ['Built entirely around a specific request', 'Sourced through a network of specialist partners', 'Suited for milestone occasions'],
      'meta_title' => 'Bespoke Travel Experiences | Vocation Travels And Tours',
      'meta_description' => 'Bespoke travel experiences built from scratch around specific requests, for milestone occasions that need something unique.',
      'keywords' => ['bespoke travel experiences India', 'custom luxury travel design', 'unique travel experience planner'],
    ],
    'white-label-travel' => [
      'name' => 'White-Label Travel Management Solutions',
      'category' => 'specialized',
      'order' => 170,
      'icon' => 'fa-solid fa-tags',
      'description' => 'Travel operations run under a partner\'s own brand — booking, support and reporting delivered behind the scenes for agencies and platforms.',
      'highlights' => ['Operations run under your brand', 'Booking, support and reporting handled', 'Built for agencies and travel platforms'],
      'meta_title' => 'White-Label Travel Management Solutions | Vocation Travels',
      'meta_description' => 'White-label travel management solutions delivering booking, support and reporting behind the scenes, under your own brand.',
      'keywords' => ['white label travel management', 'white label travel agency India', 'outsourced travel operations'],
    ],
    'travel-desk-outsourcing' => [
      'name' => 'Travel Desk Outsourcing Services',
      'category' => 'specialized',
      'order' => 180,
      'icon' => 'fa-solid fa-desktop',
      'description' => 'A fully outsourced travel desk for your organization, handling day-to-day bookings and queries so an in-house team isn\'t needed.',
      'highlights' => ['Day-to-day bookings handled externally', 'Dedicated team for employee queries', 'No in-house travel desk required'],
      'meta_title' => 'Travel Desk Outsourcing Services | Vocation Travels And Tours',
      'meta_description' => 'Travel desk outsourcing services handling day-to-day corporate bookings and employee queries without an in-house team.',
      'keywords' => ['travel desk outsourcing India', 'outsourced corporate travel desk', 'travel management outsourcing'],
    ],

  ];

  global $conn;
  if (!empty($conn) && $conn instanceof mysqli && !$conn->connect_errno) {
    $res = @$conn->query("SELECT slug, name, category, tagline, icon, image, meta_title, meta_description, focus_keyword, seo_score, status, views_count, inquiries_count FROM services_cms");
    if ($res && $res->num_rows > 0) {
      while ($row = $res->fetch_assoc()) {
        $slug = $row['slug'];
        if (isset($services[$slug])) {
          if (!empty($row['name'])) $services[$slug]['name'] = $row['name'];
          if (!empty($row['tagline'])) $services[$slug]['description'] = $row['tagline'];
          if (!empty($row['icon'])) $services[$slug]['icon'] = $row['icon'];
          if (!empty($row['meta_title'])) $services[$slug]['meta_title'] = $row['meta_title'];
          if (!empty($row['meta_description'])) $services[$slug]['meta_description'] = $row['meta_description'];
          if (!empty($row['focus_keyword'])) $services[$slug]['keywords'] = [$row['focus_keyword']];
          $services[$slug]['status'] = $row['status'];
          $services[$slug]['seo_score'] = (int)$row['seo_score'];
          $services[$slug]['views_count'] = (int)$row['views_count'];
          $services[$slug]['inquiries_count'] = (int)$row['inquiries_count'];
        }
      }
    }
  }

  return $services;
}

include_once __DIR__ . '/services_detail.php';

function get_service($slug)
{
  $services = get_services();
  if (!isset($services[$slug])) {
    return null;
  }
  $svc = enrich_service($slug, $services[$slug]);

  global $conn;
  if (!empty($conn) && $conn instanceof mysqli && !$conn->connect_errno) {
    $stmt = @$conn->prepare("SELECT * FROM services_cms WHERE slug = ? LIMIT 1");
    if ($stmt) {
      $stmt->bind_param("s", $slug);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($res && $row = $res->fetch_assoc()) {
        if ($row['status'] === 'inactive') {
          $stmt->close();
          return null;
        }
        if (!empty($row['name'])) $svc['name'] = $row['name'];
        if (!empty($row['tagline'])) $svc['tagline'] = $row['tagline'];
        if (!empty($row['icon'])) $svc['icon'] = $row['icon'];
        if (!empty($row['image'])) $svc['image'] = $row['image'];
        if (!empty($row['overview_text'])) {
          $svc['overview'] = explode("\n\n", $row['overview_text']);
        }
        if (!empty($row['highlights_json'])) {
          $hl = json_decode($row['highlights_json'], true);
          if (is_array($hl)) $svc['highlights'] = $hl;
        }
        if (!empty($row['features_json'])) {
          $ft = json_decode($row['features_json'], true);
          if (is_array($ft)) $svc['features'] = $ft;
        }
        if (!empty($row['faqs_json'])) {
          $fq = json_decode($row['faqs_json'], true);
          if (is_array($fq)) $svc['faqs'] = $fq;
        }
        if (!empty($row['meta_title'])) $svc['meta_title'] = $row['meta_title'];
        if (!empty($row['meta_description'])) $svc['meta_description'] = $row['meta_description'];
        if (!empty($row['focus_keyword'])) $svc['keywords'] = [$row['focus_keyword']];
        $svc['seo_score'] = (int)$row['seo_score'];
        $svc['views_count'] = (int)$row['views_count'];
        $svc['inquiries_count'] = (int)$row['inquiries_count'];
      }
      $stmt->close();

      // Track page views
      if (session_status() === PHP_SESSION_ACTIVE && empty($_SESSION['admin_logged_in'])) {
        @$conn->query("UPDATE services_cms SET views_count = views_count + 1 WHERE slug = '" . $conn->real_escape_string($slug) . "'");
      }
    }
  }

  return $svc;
}

function get_services_by_category($category)
{
  $services = get_services();
  $filtered = array_filter($services, fn($s) => ($s['category'] ?? '') === $category && ($s['status'] ?? 'active') !== 'inactive');
  uasort($filtered, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
  return $filtered;
}

