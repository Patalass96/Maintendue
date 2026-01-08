// Home.js - Carrousel et animations

class HeroCarousel {
    constructor() {
        this.slides = document.querySelectorAll('.carousel-slide');
        this.indicators = document.querySelectorAll('.carousel-indicators .indicator');
        this.prevBtn = document.getElementById('prevSlide');
        this.nextBtn = document.getElementById('nextSlide');
        this.currentSlide = 0;
        this.interval = null;
        this.intervalTime = 5000; 
        
        if (this.slides.length > 0) {
            this.init();
        }
    }
    
    init() {
        this.showSlide(this.currentSlide);
        
        if (this.prevBtn) this.prevBtn.addEventListener('click', () => this.prevSlide());
        if (this.nextBtn) this.nextBtn.addEventListener('click', () => this.nextSlide());
        
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => this.goToSlide(index));
        });
        
        this.startAutoPlay();
        
        const carousel = document.querySelector('.hero-carousel');
        if (carousel) {
            carousel.addEventListener('mouseenter', () => this.stopAutoPlay());
            carousel.addEventListener('mouseleave', () => this.startAutoPlay());
        }
    }
    
    showSlide(index) {
        this.slides.forEach(slide => slide.classList.remove('active'));
        this.indicators.forEach(indicator => indicator.classList.remove('active'));
        
        this.slides[index].classList.add('active');
        this.indicators[index].classList.add('active');
        this.currentSlide = index;
    }
    
    nextSlide() {
        let nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.showSlide(nextIndex);
    }
    
    prevSlide() {
        let prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        this.showSlide(prevIndex);
    }
    
    goToSlide(index) {
        this.showSlide(index);
    }
    
    startAutoPlay() {
        if (!this.interval) {
            this.interval = setInterval(() => this.nextSlide(), this.intervalTime);
        }
    }
    
    stopAutoPlay() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.hero-carousel')) {
        new HeroCarousel();
    }
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.step-card, .category-card, .donation-card, .stat-card, .testimonial-card').forEach(el => {
        observer.observe(el);
    });
});

// Injection du CSS d'animation
const style = document.createElement('style');
style.textContent = `
    .step-card, .category-card, .donation-card, .stat-card, .testimonial-card {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .animate-in {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
    .step-card:nth-child(1) { transition-delay: 0.1s; }
    .step-card:nth-child(2) { transition-delay: 0.2s; }
    .step-card:nth-child(3) { transition-delay: 0.3s; }
`;
document.head.appendChild(style);

 document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicators .indicator');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));
            
            slides[index].classList.add('active');
            indicators[index].classList.add('active');
            currentSlide = index;
        }

        function nextSlide() {
            let newIndex = (currentSlide + 1) % slides.length;
            showSlide(newIndex);
        }

        function prevSlide() {
            let newIndex = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(newIndex);
        }

        // Événements
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetTimer();
        });

        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetTimer();
        });

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                showSlide(index);
                resetTimer();
            });
        });

        // Timer automatique (4 secondes)
        function startTimer() {
            slideInterval = setInterval(nextSlide, 4000);
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        startTimer();
    });

    document.addEventListener('DOMContentLoaded', function() {
    const searchSection = document.querySelector('.quick-search-section');

    // 1. Animation au défilement (Scroll Animation)
    const observerOptions = {
        threshold: 0.2 // Se déclenche quand 20% de la section est visible
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('appear');
                observer.unobserve(entry.target); // On arrête d'observer une fois l'animation jouée
            }
        });
    }, observerOptions);

    if (searchSection) {
        observer.observe(searchSection);
    }

    // 2. Logique de soumission du formulaire
    const searchForm = document.querySelector('.search-filter-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Optionnel : Tu peux ajouter un petit loader sur le bouton ici
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>...';
        });
    }
});

