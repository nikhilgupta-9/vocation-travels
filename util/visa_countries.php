<?php
/**
 * Static content source for the Visa Services hub + country pages.
 * All fees / processing-time figures are general, approximate placeholders —
 * meant to be reviewed and replaced with confirmed figures.
 */

function get_visa_countries()
{
  return [
    'usa' => [
      'name' => 'USA',
      'flag' => '🇺🇸',
      'order' => 10,
      'meta_title' => 'USA Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'Expert USA visa consultants serving Hyderabad, Bangalore and all of India. Get help with B1/B2 tourist visa, documentation, DS-160 forms and interview preparation.',
      'keywords' => ['USA visa consultants Hyderabad', 'USA visa agent Bangalore', 'US tourist visa India', 'B1 B2 visa assistance', 'America visa services Hyderabad', 'USA visa interview preparation India'],
      'hero_tagline' => 'Trusted USA Visa Consultants for Travelers in Hyderabad, Bangalore & Across India',
      'intro' => 'Planning a trip to the United States? Our team helps applicants from Hyderabad, Bangalore and across India navigate the B1/B2 tourist and business visa process — from DS-160 form filing to interview preparation and document checklists.',
      'visa_types' => [
        ['name' => 'B1/B2 Tourist & Business Visa', 'desc' => 'For leisure travel, visiting family, or short business trips to the USA.'],
        ['name' => 'F1 Student Visa Guidance', 'desc' => 'Documentation support and appointment guidance for study-related travel.'],
        ['name' => 'Transit Visa Assistance', 'desc' => 'Support for travelers transiting through the US to a third country.'],
      ],
      'documents' => ['Valid passport (6+ months validity)', 'DS-160 confirmation page', 'Passport-size photograph (US visa specification)', 'Proof of financial standing (bank statements)', 'Employment or business proof', 'Travel itinerary and purpose of visit letter'],
      'process_steps' => [
        ['title' => 'Free Consultation', 'desc' => 'We review your travel purpose and eligibility.'],
        ['title' => 'DS-160 & Documentation', 'desc' => 'We help you complete the DS-160 form and assemble the correct document set.'],
        ['title' => 'Appointment Scheduling', 'desc' => 'We assist with visa fee payment and interview slot booking.'],
        ['title' => 'Interview Preparation', 'desc' => 'Mock Q&A sessions to help you feel confident on interview day.'],
      ],
      'processing_time' => 'Approximate — varies by season and consulate wait times',
      'faqs' => [
        ['q' => 'Can I apply for a USA visa from Hyderabad or Bangalore?', 'a' => 'Yes. While interviews are conducted at designated US consulates, our consultants in Hyderabad and Bangalore handle your complete documentation and preparation remotely and in person.'],
        ['q' => 'How far in advance should I apply for a USA tourist visa?', 'a' => 'We generally recommend starting the process at least 2–3 months before your intended travel date, as interview slot availability can vary.'],
        ['q' => 'Do you help with visa interview preparation?', 'a' => 'Yes, we conduct mock interview sessions and help you organize supporting documents to present your case clearly.'],
      ],
    ],

    'canada' => [
      'name' => 'Canada',
      'flag' => '🇨🇦',
      'order' => 20,
      'meta_title' => 'Canada Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'Reliable Canada visitor visa consultants for applicants in Hyderabad, Bangalore and across India. Get help with documentation, biometrics and application submission.',
      'keywords' => ['Canada visa consultants Hyderabad', 'Canada visa agent Bangalore', 'Canada visitor visa India', 'Canada tourist visa assistance', 'Canada PR visa consultants Hyderabad'],
      'hero_tagline' => 'Canada Visitor Visa Experts for Applicants in Hyderabad, Bangalore & India',
      'intro' => 'From temporary resident visas to visitor permits, our Canada visa specialists support travelers across Hyderabad, Bangalore and India with accurate documentation and a smooth application process.',
      'visa_types' => [
        ['name' => 'Visitor Visa (TRV)', 'desc' => 'For tourism, family visits, or short business travel to Canada.'],
        ['name' => 'Super Visa Guidance', 'desc' => 'Support for parents and grandparents visiting family in Canada.'],
        ['name' => 'Study & Work Permit Documentation', 'desc' => 'Document preparation support for study and work-related travel.'],
      ],
      'documents' => ['Valid passport', 'Digital photograph meeting IRCC specifications', 'Proof of funds and financial standing', 'Letter of invitation (if applicable)', 'Travel history and itinerary', 'Biometrics confirmation'],
      'process_steps' => [
        ['title' => 'Eligibility Review', 'desc' => 'We assess your travel purpose and profile.'],
        ['title' => 'Online Application', 'desc' => 'We assist with the IRCC portal application and document uploads.'],
        ['title' => 'Biometrics Appointment', 'desc' => 'Guidance on scheduling your biometrics at the nearest VAC.'],
        ['title' => 'Tracking & Follow-up', 'desc' => 'We monitor your application status until a decision is issued.'],
      ],
      'processing_time' => 'Approximate — varies based on application volume',
      'faqs' => [
        ['q' => 'Do I need to travel to Delhi for my Canada visa biometrics?', 'a' => 'Visa Application Centres are located in multiple Indian cities; we help you identify and book the nearest available slot to Hyderabad or Bangalore.'],
        ['q' => 'Can you help with a Canada Super Visa for my parents?', 'a' => 'Yes, we assist with Super Visa documentation including invitation letters and proof of medical insurance.'],
      ],
    ],

    'uk' => [
      'name' => 'United Kingdom',
      'flag' => '🇬🇧',
      'order' => 30,
      'meta_title' => 'UK Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'UK visitor visa assistance for applicants in Hyderabad, Bangalore and across India — documentation support, application filing and appointment guidance.',
      'keywords' => ['UK visa consultants Hyderabad', 'UK visa agent Bangalore', 'United Kingdom tourist visa India', 'UK visitor visa assistance', 'Britain visa services Hyderabad'],
      'hero_tagline' => 'UK Visitor Visa Assistance for Hyderabad, Bangalore & Pan-India Applicants',
      'intro' => 'Our consultants guide applicants from Hyderabad, Bangalore and across India through the UK Standard Visitor Visa process, helping you present a complete and well-documented application.',
      'visa_types' => [
        ['name' => 'Standard Visitor Visa', 'desc' => 'For tourism, visiting family and friends, or short business visits.'],
        ['name' => 'Business Visitor Visa', 'desc' => 'For conferences, meetings and short-term business activity.'],
        ['name' => 'Student Visitor Visa Guidance', 'desc' => 'Support for short-term study-related visits to the UK.'],
      ],
      'documents' => ['Valid passport with blank pages', 'Online application (VAF) confirmation', 'Bank statements and proof of funds', 'Employment/business proof', 'Accommodation and travel itinerary', 'Biometric residence details (if applicable)'],
      'process_steps' => [
        ['title' => 'Profile Assessment', 'desc' => 'We review your travel history and purpose of visit.'],
        ['title' => 'Online Application', 'desc' => 'We help complete the UKVI online application accurately.'],
        ['title' => 'Document Compilation', 'desc' => 'A checklist tailored to your specific travel purpose.'],
        ['title' => 'VAC Appointment', 'desc' => 'Booking assistance at the nearest Visa Application Centre.'],
      ],
      'processing_time' => 'Approximate — standard and priority options may be available',
      'faqs' => [
        ['q' => 'Is there a UK Visa Application Centre near Hyderabad or Bangalore?', 'a' => 'Yes, VACs operate in both cities; we help you book the most convenient appointment slot.'],
        ['q' => 'Can I apply for a priority UK visa service?', 'a' => 'Priority and Super Priority services are available for an additional fee — we can advise if it suits your travel timeline.'],
      ],
    ],

    'europe' => [
      'name' => 'Europe (Schengen)',
      'flag' => '🇪🇺',
      'order' => 40,
      'meta_title' => 'Europe Schengen Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'Schengen visa assistance for travelers in Hyderabad, Bangalore and across India — covering France, Germany, Italy, Spain, Switzerland and other Schengen countries.',
      'keywords' => ['Schengen visa consultants Hyderabad', 'Europe visa agent Bangalore', 'Europe tourist visa India', 'France visa assistance', 'Germany visa consultants Hyderabad', 'Italy Spain Switzerland visa India'],
      'hero_tagline' => 'Schengen Europe Visa Specialists for Hyderabad, Bangalore & India',
      'intro' => 'Traveling to France, Germany, Italy, Spain, Switzerland or other Schengen countries? We help applicants across Hyderabad, Bangalore and India determine the right country to apply through and prepare a complete Schengen visa file.',
      'visa_types' => [
        ['name' => 'Schengen Tourist Visa', 'desc' => 'Short-stay visa for tourism across Schengen member countries.'],
        ['name' => 'Business Schengen Visa', 'desc' => 'For conferences, trade fairs and short business trips in Europe.'],
        ['name' => 'Family Visit Visa', 'desc' => 'For visiting relatives residing in a Schengen country.'],
      ],
      'documents' => ['Valid passport (3+ months beyond intended stay)', 'Schengen visa application form', 'Travel insurance covering the Schengen area', 'Confirmed flight and accommodation bookings', 'Proof of financial means', 'Cover letter explaining travel purpose'],
      'process_steps' => [
        ['title' => 'Destination Mapping', 'desc' => 'We help determine which Schengen embassy to apply through based on your itinerary.'],
        ['title' => 'Document Preparation', 'desc' => 'Country-specific checklist and travel insurance guidance.'],
        ['title' => 'Application Filing', 'desc' => 'Assistance with the relevant VFS/embassy portal submission.'],
        ['title' => 'Appointment & Biometrics', 'desc' => 'Booking support for your visa centre appointment.'],
      ],
      'processing_time' => 'Approximate — standard Schengen processing window',
      'faqs' => [
        ['q' => 'Which country should I apply to for a multi-country Europe trip?', 'a' => 'Generally you apply through the country where you will spend the most nights, or your first port of entry if the stay is equal across countries — we help confirm this for your itinerary.'],
        ['q' => 'Do you assist with Schengen travel insurance?', 'a' => 'Yes, we help you arrange travel insurance that meets the minimum Schengen coverage requirement.'],
      ],
    ],

    'australia' => [
      'name' => 'Australia',
      'flag' => '🇦🇺',
      'order' => 50,
      'meta_title' => 'Australia Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'Australia visitor visa consultants for applicants in Hyderabad, Bangalore and across India. Documentation support for subclass 600 tourist and business visas.',
      'keywords' => ['Australia visa consultants Hyderabad', 'Australia visa agent Bangalore', 'Australia tourist visa India', 'Australia subclass 600 visa', 'Australia visitor visa assistance'],
      'hero_tagline' => 'Australia Visitor Visa Guidance for Hyderabad, Bangalore & India',
      'intro' => 'Our team assists applicants from Hyderabad, Bangalore and across India with the Australia Visitor visa (subclass 600), covering document preparation and online application support.',
      'visa_types' => [
        ['name' => 'Visitor Visa (Subclass 600)', 'desc' => 'For tourism, family visits and business visitor streams.'],
        ['name' => 'Sponsored Family Stream', 'desc' => 'Guidance for applicants with a sponsor in Australia.'],
        ['name' => 'Working Holiday Visa Guidance', 'desc' => 'Support for eligible applicants exploring working holiday options.'],
      ],
      'documents' => ['Valid passport', 'Completed online application (ImmiAccount)', 'Proof of financial capacity', 'Evidence of ties to India (employment/property/family)', 'Travel itinerary and purpose of visit', 'Health and character documentation as required'],
      'process_steps' => [
        ['title' => 'Eligibility Check', 'desc' => 'We assess the right visa subclass for your travel purpose.'],
        ['title' => 'ImmiAccount Application', 'desc' => 'We help you file the application through the Australian government portal.'],
        ['title' => 'Supporting Documents', 'desc' => 'A tailored checklist to strengthen your application.'],
        ['title' => 'Status Tracking', 'desc' => 'We monitor and update you through to a decision.'],
      ],
      'processing_time' => 'Approximate — varies by visa subclass and applicant profile',
      'faqs' => [
        ['q' => 'Can I apply for an Australia visa without traveling to a visa centre?', 'a' => 'Most visitor visa applications are lodged online; we guide you through the digital process from Hyderabad or Bangalore.'],
        ['q' => 'What increases the chance of Australia visitor visa approval?', 'a' => 'Strong evidence of ties to India, sufficient funds and a clear travel purpose are key factors we help you document well.'],
      ],
    ],

    'japan' => [
      'name' => 'Japan',
      'flag' => '🇯🇵',
      'order' => 60,
      'meta_title' => 'Japan Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'Japan tourist visa assistance for applicants in Hyderabad, Bangalore and across India — documentation, itinerary planning and application support.',
      'keywords' => ['Japan visa consultants Hyderabad', 'Japan visa agent Bangalore', 'Japan tourist visa India', 'Japan visa documentation help', 'Japan visa services Hyderabad'],
      'hero_tagline' => 'Japan Tourist Visa Assistance for Hyderabad, Bangalore & India',
      'intro' => 'Planning a trip to Japan? We help applicants across Hyderabad, Bangalore and India prepare a complete, well-organized visa file, including day-wise itinerary and sponsorship documentation.',
      'visa_types' => [
        ['name' => 'Temporary Visitor Visa (Tourism)', 'desc' => 'For sightseeing, short visits and leisure travel to Japan.'],
        ['name' => 'Business Visa', 'desc' => 'For short-term business meetings and conferences.'],
        ['name' => 'Transit Visa Assistance', 'desc' => 'Support for travelers transiting through Japan.'],
      ],
      'documents' => ['Valid passport', 'Visa application form and photograph', 'Day-wise travel itinerary', 'Proof of accommodation bookings', 'Bank statements / sponsorship letter', 'Employment or business proof'],
      'process_steps' => [
        ['title' => 'Itinerary Planning', 'desc' => 'We help you build a day-wise plan required for the application.'],
        ['title' => 'Documentation', 'desc' => 'Guidance on sponsorship letters, bank proofs and photographs.'],
        ['title' => 'Application Submission', 'desc' => 'Filing through the designated visa application centre.'],
        ['title' => 'Passport Collection', 'desc' => 'We keep you updated until your passport is ready for collection.'],
      ],
      'processing_time' => 'Approximate — standard Japan visa processing window',
      'faqs' => [
        ['q' => 'Do I need a day-wise itinerary for a Japan visa?', 'a' => 'Yes, a detailed day-wise itinerary is typically required — we help you prepare one that matches your accommodation bookings.'],
        ['q' => 'Can Hyderabad or Bangalore applicants apply directly?', 'a' => 'Yes, applications are routed through designated visa application centres serving your region, and we manage the submission process for you.'],
      ],
    ],

    'singapore' => [
      'name' => 'Singapore',
      'flag' => '🇸🇬',
      'order' => 70,
      'meta_title' => 'Singapore Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'Singapore tourist and business visa assistance for applicants in Hyderabad, Bangalore and across India — fast documentation support and application filing.',
      'keywords' => ['Singapore visa consultants Hyderabad', 'Singapore visa agent Bangalore', 'Singapore tourist visa India', 'Singapore visa services Hyderabad', 'Singapore business visa assistance'],
      'hero_tagline' => 'Singapore Visa Assistance for Hyderabad, Bangalore & India',
      'intro' => 'We help travelers from Hyderabad, Bangalore and across India put together a complete Singapore visa application, whether for tourism, business or family visits.',
      'visa_types' => [
        ['name' => 'Tourist Visa', 'desc' => 'For leisure travel and short visits to Singapore.'],
        ['name' => 'Business Visa', 'desc' => 'For meetings, conferences and short-term business trips.'],
        ['name' => 'Family Visit Visa', 'desc' => 'For visiting relatives or friends residing in Singapore.'],
      ],
      'documents' => ['Valid passport', 'Recent passport-size photograph', 'Completed visa application form', 'Proof of accommodation and return travel', 'Bank statements / proof of funds', 'Employment or business proof'],
      'process_steps' => [
        ['title' => 'Document Checklist', 'desc' => 'We share a tailored checklist based on your travel purpose.'],
        ['title' => 'Application Filing', 'desc' => 'Submission through an authorized Singapore visa agent.'],
        ['title' => 'Status Updates', 'desc' => 'Regular updates on your application progress.'],
        ['title' => 'Passport Return', 'desc' => 'Coordination for passport collection or courier delivery.'],
      ],
      'processing_time' => 'Approximate — among the faster processing turnarounds for Indian applicants',
      'faqs' => [
        ['q' => 'Is Singapore visa processing quick for Indian applicants?', 'a' => 'Singapore visas are generally processed faster than many other destinations, though timelines can vary by season.'],
        ['q' => 'Can I apply for a Singapore visa online from Hyderabad or Bangalore?', 'a' => 'Yes, applications are filed through authorized visa agents — we handle the end-to-end submission for you.'],
      ],
    ],

    'uae' => [
      'name' => 'UAE / Dubai',
      'flag' => '🇦🇪',
      'order' => 80,
      'meta_title' => 'UAE & Dubai Visa Services in Hyderabad & Bangalore | Vocation Travels And Tours',
      'meta_description' => 'Dubai and UAE visa assistance for applicants in Hyderabad, Bangalore and across India — tourist, transit and business visa support with our Dubai office backing.',
      'keywords' => ['Dubai visa consultants Hyderabad', 'UAE visa agent Bangalore', 'Dubai tourist visa India', 'UAE visa services Hyderabad', 'Dubai visa online India'],
      'hero_tagline' => 'Dubai & UAE Visa Services for Hyderabad, Bangalore & India — Backed by Our Dubai Office',
      'intro' => 'With an office presence in Dubai, we offer applicants from Hyderabad, Bangalore and across India reliable support for UAE tourist, transit and business visas.',
      'visa_types' => [
        ['name' => '30-Day / 60-Day Tourist Visa', 'desc' => 'Short and extended stay tourist visas for the UAE.'],
        ['name' => 'Transit Visa', 'desc' => 'For travelers with layovers in the UAE.'],
        ['name' => 'Business Visa', 'desc' => 'For short-term business visits and meetings.'],
      ],
      'documents' => ['Valid passport (6+ months validity)', 'Passport-size photograph', 'Confirmed return flight ticket', 'Hotel booking or sponsor details', 'Bank statement / proof of funds'],
      'process_steps' => [
        ['title' => 'Visa Type Selection', 'desc' => 'We help you choose between 30-day and 60-day tourist visas based on your trip length.'],
        ['title' => 'Document Submission', 'desc' => 'Quick digital document collection and verification.'],
        ['title' => 'Application Filing', 'desc' => 'Fast-tracked filing leveraging our Dubai office network.'],
        ['title' => 'E-Visa Delivery', 'desc' => 'Your UAE e-visa is shared digitally once approved.'],
      ],
      'processing_time' => 'Approximate — UAE tourist e-visas are typically processed relatively quickly',
      'faqs' => [
        ['q' => 'Does having a Dubai office help my UAE visa application?', 'a' => 'Our Dubai office allows us to coordinate closely on documentation and sponsor requirements, which can help streamline the process.'],
        ['q' => 'Can I get a UAE e-visa without a sponsor?', 'a' => 'Tourist e-visas can generally be arranged through a licensed travel agent as sponsor — we handle this on your behalf.'],
      ],
    ],
  ];
}

function get_visa_country($slug)
{
  $countries = get_visa_countries();
  return $countries[$slug] ?? null;
}
