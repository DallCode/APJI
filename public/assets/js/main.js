/**
* Template Name: FlexStart
* Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
* Updated: Nov 01 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

// script.js

// // Mengubah teks hero-description setelah 3 detik
setTimeout(function () {
  const heroDescription = document.getElementById("hero-description");
  if (heroDescription) {
      heroDescription.innerHTML = "Meningkatkan Kualitas dan Ketersediaan Kuliner di Jawa Barat";
  }
}, 3000);

// Form validation dan alert saat submit
$('form').on('submit', function (event) {
  event.preventDefault();
  const name = $('[placeholder="Nama Lengkap"]').val().trim();
  const email = $('[placeholder="Email"]').val().trim();
  const message = $('[placeholder="Pesan"]').val().trim();
  if (!name || !email || !message) {
      alert('Harap isi semua field!');
  } else {
      alert('Pesan berhasil dikirim!');
  }
});

// Animasi scroll pada navbar
document.addEventListener('scroll', () => {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
  } else {
      navbar.classList.remove('scrolled');
  }
});

// Reveal on Scroll
function reveal() {
  const reveals = document.querySelectorAll('.reveal');
  reveals.forEach(element => {
      const windowHeight = window.innerHeight;
      const elementTop = element.getBoundingClientRect().top;
      const elementVisible = 150;

      if (elementTop < windowHeight - elementVisible) {
          element.classList.add('active');
      }
  });
}
window.addEventListener('scroll', reveal);

// Hero Text Animation
function animateHeroText() {
  const heroDescription = document.querySelector('.hero p.lead');
  const texts = [
      "Memajukan Industri Kuliner Jawa Barat",
      "Meningkatkan Kualitas dan Inovasi",
      "Melestarikan Warisan Kuliner"
  ];
  let currentIndex = 0;

  setInterval(() => {
      heroDescription.style.opacity = '0';
      setTimeout(() => {
          heroDescription.textContent = texts[currentIndex];
          heroDescription.style.opacity = '1';
          currentIndex = (currentIndex + 1) % texts.length;
      }, 500);
  }, 4000);
}

// Smooth scroll untuk navigasi
function smoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
          });
      });
  });
}

// Form input animation
function inputAnimation() {
  const form = document.querySelector('form');
  if (!form) return;

  const inputs = form.querySelectorAll('input, textarea, select');
  inputs.forEach(input => {
      input.addEventListener('focus', () => {
          input.parentElement.classList.add('focused');
      });

      input.addEventListener('blur', () => {
          if (!input.value) {
              input.parentElement.classList.remove('focused');
          }
      });
  });
}

// Stats counter animation
function animateCounter(element, target) {
  let current = 0;
  const increment = target / 100;
  const timer = setInterval(() => {
      current += increment;
      element.textContent = Math.floor(current) + '+';
      if (current >= target) {
          element.textContent = target + '+';
          clearInterval(timer);
      }
  }, 20);
}

// Initialize counter animation
function initializeStatsCounter() {
  const statsSection = document.querySelector('.stats-section');
  if (!statsSection) return;

  const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
          if (entry.isIntersecting) {
              entry.target.querySelectorAll('h2').forEach(counter => {
                  const target = parseInt(counter.textContent);
                  animateCounter(counter, target);
              });
              statsObserver.unobserve(entry.target);
          }
      });
  }, { threshold: 0.5 });

  statsObserver.observe(statsSection);
}

// Initialize all animations and functionality on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
  animateHeroText();
  reveal();
  smoothScroll();
  inputAnimation();
  initializeStatsCounter();

  // Add reveal class to sections
  document.querySelectorAll('section').forEach(section => {
      section.classList.add('reveal');
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.querySelector("#newsCarousel");
  const interval = 3000; // Durasi setiap slide (ms)

  let bsCarousel = new bootstrap.Carousel(carousel, {
      interval: interval, // Durasi otomatis
      wrap: true,
  });

  // Memastikan hanya satu slide bergeser setiap kali
  carousel.addEventListener("slid.bs.carousel", function () {
      bsCarousel.cycle();
  });
});

// document.addEventListener('DOMContentLoaded', () => {
//     const observerOptions = {
//         root: null,
//         rootMargin: '0px',
//         threshold: 0.1
//     };

//     const animateElements = (entries, observer) => {
//         entries.forEach(entry => {
//             if (entry.isIntersecting) {
//                 const element = entry.target;
//                 const animationClass = element.dataset.animation || 'animate__fadeInUp';
              
//                 element.classList.add('animate__animated', animationClass);
//                 element.style.visibility = 'visible';
              
//                 // Optional: Remove animation class after it completes to prevent re-triggering
//                 const animationEndHandler = () => {
//                     element.classList.remove('animate__animated', animationClass);
//                     element.removeEventListener('animationend', animationEndHandler);
//                 };
              
//                 element.addEventListener('animationend', animationEndHandler);
              
//                 observer.unobserve(element);
//             }
//         });
//     };

//     const scrollObserver = new IntersectionObserver(animateElements, observerOptions);

//     // Select elements to animate
//     const animationTargets = document.querySelectorAll(
//         '.hero, , #tentang, #layanan, #berita, #kontak, .stats-section, .feature-card, .news-card'
//     );

//     animationTargets.forEach(element => {
//         element.style.visibility = 'hidden';
//         scrollObserver.observe(element);
//     });
// });