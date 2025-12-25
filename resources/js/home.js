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