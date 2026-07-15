// Inject header and initialize responsive nav/dropdown

document.addEventListener('DOMContentLoaded', () => {

  const headerEl = document.getElementById('header');
  const footerEl = document.getElementById('footer');

  // Header
  if (headerEl) {
    fetch('/header.php')  // ✅ FIXED
      .then(res => res.text())
      .then(html => {
        headerEl.innerHTML = html;
        initHeaderJS();
      })
      .catch(err => console.error("Header load error:", err));
  }

  // Footer
  if (footerEl) {
    fetch('/footer.php')  // ✅ FIXED
      .then(res => res.text())
      .then(html => {
        footerEl.innerHTML = html;
      })
      .catch(err => console.error("Footer load error:", err));
  }

});

function initHeaderJS() {
  // Mobile nav toggle
  const navToggle = document.getElementById('nav-toggle');
  const navMenu = document.getElementById('nav-menu');
  if (navToggle && navMenu) {
    navToggle.addEventListener('click', () => {
      navMenu.classList.toggle('hidden');
    });
  }

  // Dropdown for Travel Packages
  const travelBtn = document.getElementById('travel-packages-btn');
  const travelMenu = document.getElementById('travel-packages-menu');
  if (travelBtn && travelMenu) {
    // Show on click (mobile)
    travelBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      travelMenu.classList.toggle('hidden');
    });
    // Hide on click outside
    document.addEventListener('click', (e) => {
      if (!travelBtn.contains(e.target) && !travelMenu.contains(e.target)) {
        travelMenu.classList.add('hidden');
      }
    });
    // Show on hover (desktop)
    travelBtn.addEventListener('mouseenter', () => {
      if (window.innerWidth >= 640) travelMenu.classList.remove('hidden');
    });
    travelBtn.addEventListener('mouseleave', () => {
      if (window.innerWidth >= 640) setTimeout(() => travelMenu.classList.add('hidden'), 200);
    });
    travelMenu.addEventListener('mouseenter', () => {
      if (window.innerWidth >= 640) travelMenu.classList.remove('hidden');
    });
    travelMenu.addEventListener('mouseleave', () => {
      if (window.innerWidth >= 640) travelMenu.classList.add('hidden');
    });
  }
}


function initSlider(slidesId, dotsId) {
  const slides = document.getElementById(slidesId);
  const dots   = document.querySelectorAll(`#${dotsId} .dot`);
  let   current = 0;
  const total   = slides.children.length;

  function goTo(idx) {
    slides.style.transform = `translateX(-${idx * 100}%)`;
    dots.forEach((dot, i) => {
      dot.classList.toggle('bg-opacity-100', i === idx);
      dot.classList.toggle('bg-opacity-50',  i !== idx);
    });
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      current = i;
      goTo(i);
    });
  });

  setInterval(() => {
    current = (current + 1) % total;
    goTo(current);
  }, 5000);

  goTo(0);
}

// Disabled auto-advance slider for work sliders to avoid conflict with scroll-driven sliders


// Wait until the DOM is fully parsed
window.addEventListener('DOMContentLoaded', () => {
  initTextCarousel();
});

function initTextCarousel() {
  const items = [
    {
      title: 'Amanda',
      subtitle: '“They helped us throughout with our family trip to EUROPE, exactly the way we wanted. No extra selling just to make more money. ”',
      linkText: 'Mumbai',
      linkHref: 'work.html'
    },
    {
      title: 'Kartik',
      subtitle: '“My business trip was so last minute but Vocation made it easy to manage. Best part is they don’t take 2-3 business days to reply like others.”',
      linkText: 'Mumbai',
      linkHref: 'case-study.html'
    },
    {
      title: 'Priya Rai',
      subtitle: '“Vocation Travels’ website is my one-stop shop for all my travel needs. Whether I’m booking flights for a business trip or searching for last-minute hotel deals, their user-friendly interface makes the process quick and efficient. Plus, their secure payment gateway gives me peace of mind. Vocation Travels is a trusted travel partner for me.”',
      linkText: 'Mumbai',
      linkHref: 'service.php'
    },
    {
      title: 'Pragya Sharma',
      subtitle: '“Vocation Travels made planning my family trip to Kerala such a breeze! Their website was easy to navigate and had a great selection of tour packages that fit perfectly within our budget. We especially loved browsing the hotel options with all the virtual tours – it really helped us decide which place would be perfect for us. I’ll definitely recommend Vocation Travels to anyone looking for a hassle-free travel experience!”',
      linkText: 'Ahmedabad',
      linkHref: 'service.php'
    }
    // …add more slides here if you like…
  ];

  
}





  gsap.registerPlugin(ScrollTrigger);

  function createHorizontalScroll(container, slides, onUpdate) {
  let sections = gsap.utils.toArray(slides + " > div");
  let total = sections.length;

  let tween = gsap.to(sections, {
    xPercent: -100 * (sections.length - 1),
    ease: "none",
    scrollTrigger: {
      trigger: container,
      pin: true,
      scrub: 1,
      snap: 1 / (sections.length - 1),
      end: () => "+=" + ((sections.length * window.innerWidth) - window.innerWidth),
      onUpdate: (self) => {
        if (typeof onUpdate === 'function') {
          const idx = Math.round(self.progress * (total - 1));
          onUpdate(idx, total, self);
        }
      }
    }
  });

  return { sections, tween, scrollTrigger: tween.scrollTrigger, total };
}

function createDotsController(dotsId) {
  const dots = document.querySelectorAll(`#${dotsId} .dot`);
  const setActive = (idx) => {
    dots.forEach((dot, i) => {
      dot.classList.toggle('bg-opacity-100', i === idx);
      dot.classList.toggle('bg-opacity-50', i !== idx);
    });
  };
  return { dots, setActive };
}

function attachDotClicks(dots, scrollTrigger, total) {
  if (!dots || !dots.length || !scrollTrigger) return;
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      const targetProgress = (total === 1) ? 0 : (i / (total - 1));
      const targetScroll = scrollTrigger.start + targetProgress * (scrollTrigger.end - scrollTrigger.start);
      window.scrollTo({ top: targetScroll, behavior: 'smooth' });
    });
  });
}



  const dotsCtl1 = createDotsController('slider-dots');
  const dotsCtl2 = createDotsController('slider-dots2');
  dotsCtl1.setActive(0);
  dotsCtl2.setActive(0);

  const slider1 = createHorizontalScroll("#work-slider", "#slides", (idx, total, self) => {
    dotsCtl1.setActive(idx);
  });
  const slider2 = createHorizontalScroll("#work-slider2", "#slides2", (idx, total, self) => {
    dotsCtl2.setActive(idx);
  });

  attachDotClicks(dotsCtl1.dots, slider1.scrollTrigger, slider1.total);
  attachDotClicks(dotsCtl2.dots, slider2.scrollTrigger, slider2.total);

document.addEventListener('DOMContentLoaded', () => {
  // === Data (fixed with Indian faces where relevant) ===
const testimonials = [
  { 
    name: "Amanda", 
    role: "Traveler", 
    company: "Family Trip to Europe", 
    image: "https://randomuser.me/api/portraits/women/65.jpg", // foreign female
    rating: 5, 
    testimonial: "They helped us throughout with our family trip to Europe, exactly the way we wanted. No hidden charges, no unnecessary selling — just honest advice and smooth planning." 
  },
  { 
    name: "Kartik", 
    role: "Business Consultant", 
    company: "Delhi", 
    image: "https://images.unsplash.com/photo-1595152772835-219674b2a8a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80", // Indian male
    rating: 5, 
    testimonial: "My business trip was so last minute, but Vocation handled everything. The best part is how quickly they respond — unlike others who take 2-3 days, they got back within hours." 
  },
  { 
    name: "James", 
    role: "Software Engineer", 
    company: "USA", 
    image: "https://randomuser.me/api/portraits/men/32.jpg", // foreign male
    rating: 5, 
    testimonial: "Booked a honeymoon package to Bali with them, and it couldn’t have been more perfect. From flight timings to hotel arrangements, everything was thoughtfully taken care of." 
  },
  { 
    name: "Priya", 
    role: "Homemaker", 
    company: "Mumbai", 
    image: "https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80", // Indian female
    rating: 5, 
    testimonial: "They managed my parents’ Char Dham Yatra with so much care. The hotels were neat, transport was on time, and they gave us proper updates throughout. My family felt safe and comfortable." 
  },
  { 
    name: "Charlotte", 
    role: "Marketing Manager", 
    company: "Australia", 
    image: "https://randomuser.me/api/portraits/women/12.jpg", // foreign female
    rating: 5, 
    testimonial: "I loved how transparent the whole process was. They actually listened to what I wanted instead of pushing expensive options. Definitely the most genuine travel service I’ve used." 
  },
  { 
    name: "Rohan", 
    role: "Tech Entrepreneur", 
    company: "Bangalore", 
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQBDox39ubeWBKcvnjRzPyPY2-z9AUIlNv_w&s", // Indian male
    rating: 5, 
    testimonial: "I had to attend a tech conference in Singapore and extend for leisure. Vocation handled both corporate bookings and my holiday itinerary. Really convenient and stress-free." 
  },
  { 
    name: "Daniel", 
    role: "Teacher", 
    company: "Canada", 
    image: "https://randomuser.me/api/portraits/men/18.jpg", // foreign male
    rating: 5, 
    testimonial: "We had kids traveling with us for our Europe trip, and the team suggested kid-friendly hotels and activities. Honestly, the small details made all the difference." 
  },
  { 
    name: "Neha", 
    role: "HR Manager", 
    company: "Pune", 
    image: "https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80", // Indian female
    rating: 5, 
    testimonial: "Booked a girls’ trip to Manali with them, and it was amazing! The driver was polite, the hotel was cozy, and the whole plan was budget-friendly but still premium." 
  },
  { 
    name: "Olivia", 
    role: "Banker", 
    company: "Ireland", 
    image: "https://randomuser.me/api/portraits/women/28.jpg", // foreign female
    rating: 5, 
    testimonial: "Our anniversary trip to Maldives was just stunning. They recommended the right resort, and even arranged a surprise candlelight dinner for us. Couldn’t have asked for more." 
  },
  { 
    name: "Arjun", 
    role: "Startup Founder", 
    company: "Hyderabad", 
    image: "https://www.theindustryoutlook.com/uploaded_images/newstransfer/ps9ukUntitled-1.jpg", // Indian male
    rating: 5, 
    testimonial: "I needed to travel to Dubai for business but also wanted to take my family. They balanced both perfectly — handled visas, flight bookings, and even suggested family activities." 
  },
  { 
    name: "Ethan", 
    role: "Consultant", 
    company: "New Zealand", 
    image: "https://randomuser.me/api/portraits/men/10.jpg", // foreign male
    rating: 5, 
    testimonial: "I usually hate trip planning, but with Vocation, everything felt effortless. From day one, they were responsive, flexible, and genuinely cared about our experience." 
  },
  { 
    name: "Meera", 
    role: "Doctor", 
    company: "Chennai", 
    image: "https://img.freepik.com/fotos-premium/portraet-einer-jungen-inderin-die-mit-der-moeglichkeit-und-mission-eines-praktikums-in-der-personalabteilung-zufrieden-ist_590464-134290.jpg", // Indian female
    rating: 5, 
    testimonial: "We booked a Kerala backwaters package, and it was absolutely peaceful. The houseboat was beautiful, food was authentic, and the coordination was seamless. Truly memorable." 
  }
];
  const starSVG = `
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
  viewBox="0 0 24 24" fill="none" stroke="currentColor"
  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polygon points="12 2 15.09 8.26 22 9.27 
    17 14.14 18.18 21.02 12 17.77 
    5.82 21.02 7 14.14 2 9.27 
    8.91 8.26 12 2"></polygon>
  </svg>`;

  // === Grab your existing DOM ===
  const root = document.querySelector('.reviews');
  const container = root.querySelector('.container');
  const slider = container.querySelector('.testimonial-slider');
  const track  = slider.querySelector('.testimonial-track');

  // === Styles (adds z-index + spacing so arrows aren’t clipped) ===
  const style = document.createElement('style');
  style.textContent = `
    .testimonial-slider{ overflow:hidden; position:relative; padding:0 3.25rem; } /* space for arrows */
    .testimonial-track{ display:flex; gap:2rem; transition:transform 0.6s ease-in-out; will-change:transform; }
    .testimonial-card{ background:#fff; padding:2rem; border-radius:1.5rem; box-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1); width:22rem; flex:0 0 auto; display:flex; flex-direction:column; align-items:center; text-align:center; }
    .testimonial-image{ width:5rem; height:5rem; border-radius:50%; object-fit:cover; margin-bottom:1rem; }
    .testimonial-name{ font-size:1.125rem; font-weight:700; color:#1f2937; }
    .testimonial-role{ font-size:0.875rem; color:#4b5563; margin-bottom:1rem; }
    .testimonial-text{ color:#374151; margin-bottom:1rem; line-height:1.6; }
    .rating{ display:flex; gap:0.25rem; justify-content:center; }
    .star{ width:1.25rem; height:1.25rem; }
    .star.filled{ color:#facc15; fill:#facc15; }
    .star.empty{ color:#d1d5db; }

    .nav-arrow{ position:absolute; top:50%; transform:translateY(-50%); width:2.5rem; height:2.5rem; border-radius:999px; background:#fff; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 6px rgba(0,0,0,.2); cursor:pointer; z-index:5; user-select:none; }
    .nav-arrow.prev{ left:0.5rem; }
    .nav-arrow.next{ right:0.5rem; }

    .dots{ display:flex; justify-content:center; gap:0.5rem; margin-top:1rem; }
    .dot{ width:.75rem; height:.75rem; border-radius:999px; background:#d1d5db; cursor:pointer; }
    .dot.active{ background:#1f2937; }
  `;
  document.head.appendChild(style);

  // === Helpers ===
  const visible = 3;            // show 3 cards
  const autoplayMs = 3000;
  const pages = Math.ceil(testimonials.length / visible); // dots count (page = group of 3)
  let pos = visible;            // left-most visible card index within track
  let cardWidth = 0;            // measured later
  let autoTimer = null;

  function createCard(t) {
    const el = document.createElement('div');
    el.className = 'testimonial-card';
    el.innerHTML = `
      <img src="${t.image}" alt="${t.name}" class="testimonial-image">
      <h3 class="testimonial-name">${t.name}</h3>
      <p class="testimonial-role">${t.role} @${t.company}</p>
      <p class="testimonial-text">"${t.testimonial}"</p>
      <div class="rating">
        ${Array.from({length:5}).map((_,i)=>`<div class="star ${i<t.rating?'filled':'empty'}">${starSVG}</div>`).join('')}
      </div>
    `;
    return el;
  }

  // === Build original cards ===
  testimonials.forEach(t => track.appendChild(createCard(t)));

  // === Clone first & last N for seamless loop ===
  const originals = Array.from(track.children);        // after adding originals
  for (let i = 0; i < visible; i++){
    // clone end
    track.appendChild(originals[i].cloneNode(true));
    // clone start
    track.insertBefore(originals[originals.length - 1 - i].cloneNode(true), track.firstChild);
  }

  const totalCount = testimonials.length + visible*2;  // originals + clones

  // === Nav arrows ===
  const prevBtn = document.createElement('div');
  prevBtn.className = 'nav-arrow prev';
  prevBtn.innerHTML = '&#10094;';
  const nextBtn = document.createElement('div');
  nextBtn.className = 'nav-arrow next';
  nextBtn.innerHTML = '&#10095;';
  slider.appendChild(prevBtn);
  slider.appendChild(nextBtn);

  // === Dots ===
  const dots = document.createElement('div');
  dots.className = 'dots';
  for (let i = 0; i < pages; i++){
    const d = document.createElement('div');
    d.className = 'dot' + (i===0?' active':'');
    d.addEventListener('click', () => {
      pos = visible + (i * visible);
      goTo(pos, true);
    });
    dots.appendChild(d);
  }
  container.appendChild(dots);

  // === Measurements ===
  function measure(){
    const firstCard = track.querySelector('.testimonial-card');
    if(!firstCard) return;
    const gap = parseFloat(getComputedStyle(track).gap || '32'); // fallback 32px
    cardWidth = firstCard.getBoundingClientRect().width + gap;
    track.style.transform = `translateX(-${pos * cardWidth}px)`;
  }
  window.addEventListener('load', measure);
  window.addEventListener('resize', () => {
    measure();
  });

  // === Core move functions ===
  function updateDots(){
    const activePage = Math.floor(((pos - visible) % testimonials.length) / visible);
    Array.from(dots.children).forEach((d, i) => d.classList.toggle('active', i === (activePage + pages) % pages));
  }

  function goTo(newPos, animate){
    track.style.transition = animate ? 'transform 0.6s ease-in-out' : 'none';
    pos = newPos;
    track.style.transform = `translateX(-${pos * cardWidth}px)`;
    updateDots();
  }

  function next(){
    goTo(pos + 1, true);
    track.addEventListener('transitionend', () => {
      // if we’ve slid past the last original card’s end, snap back into the original range
      if (pos >= testimonials.length + visible){
        goTo(visible, false);
      }
    }, { once: true });
  }

  function prev(){
    goTo(pos - 1, true);
    track.addEventListener('transitionend', () => {
      if (pos < visible){
        goTo(testimonials.length + visible - 1, false);
      }
    }, { once: true });
  }

  // === Wire controls ===
  nextBtn.addEventListener('click', next);
  prevBtn.addEventListener('click', prev);

  // === Autoplay ===
  function startAuto(){ stopAuto(); autoTimer = setInterval(next, autoplayMs); }
  function stopAuto(){ if (autoTimer) clearInterval(autoTimer); }
  slider.addEventListener('mouseenter', stopAuto);
  slider.addEventListener('mouseleave', startAuto);

  // === Init ===
  measure();
  startAuto();
});