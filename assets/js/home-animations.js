// Intersection Observer for fade-in animations
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Add animation classes to elements
document.addEventListener('DOMContentLoaded', () => {
    // Carousel animations
    const carousel = document.querySelector('.carousel');
    if (carousel) {
        carousel.classList.add('fade-in-up');
        observer.observe(carousel);
    }

    // Category cards animations
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-up');
        observer.observe(card);
    });

    // Products animations
    const products = document.querySelectorAll('.products .row > *');
    products.forEach((product, index) => {
        product.style.animationDelay = `${index * 0.15}s`;
        product.classList.add('fade-in-up');
        observer.observe(product);
    });

    // Header text animation
    const categoryHeader = document.querySelector('.categ-header');
    if (categoryHeader) {
        categoryHeader.classList.add('fade-in');
        observer.observe(categoryHeader);
    }

    // Add parallax effect to carousel
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const carouselImages = document.querySelectorAll('.carousel-item img');
        carouselImages.forEach(img => {
            img.style.transform = `translateY(${scrolled * 0.4}px)`;
        });
    });

    // Add hover effects to cards
    cards.forEach(card => {
        card.addEventListener('mouseenter', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
            card.classList.add('card-hover');
        });

        card.addEventListener('mouseleave', () => {
            card.classList.remove('card-hover');
        });
    });

    // Smooth scroll for navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
}); 