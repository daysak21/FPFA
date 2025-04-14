document.addEventListener('DOMContentLoaded', function() {
    // Add glass effect to elements
    addGlassEffect();
    
    // Initialize animations
    initAnimations();
    
    // Add hover effects
    addHoverEffects();
    
    // Initialize tooltips
    initTooltips();
    
    // Add loading states
    addLoadingStates();
});

function addGlassEffect() {
    // Add glass effect to cards
    document.querySelectorAll('.dashboard-card').forEach(card => {
        card.classList.add('glass');
    });
    
    // Add glass effect to sidebar
    document.querySelector('.sidebar').classList.add('glass');
    
    // Add glass effect to tables
    document.querySelectorAll('.table-container').forEach(table => {
        table.classList.add('glass');
    });
    
    // Add glass effect to welcome section
    document.querySelector('.welcome-section').classList.add('glass');
    
    // Add glass effect to chart containers
    document.querySelectorAll('.chart-container').forEach(chart => {
        chart.classList.add('glass');
    });
}

function initAnimations() {
    // Animate elements when they come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    // Observe all elements that should animate
    document.querySelectorAll('.dashboard-card, .table-container, .chart-container').forEach(el => {
        observer.observe(el);
    });
}

function addHoverEffects() {
    // Add hover effect to cards
    document.querySelectorAll('.dashboard-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Add hover effect to buttons
    document.querySelectorAll('.btn-action').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.transform = 'translateY(-2px) scale(1.05)';
        });
        
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'translateY(0) scale(1)';
        });
    });
}

function initTooltips() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            animation: true,
            delay: { show: 100, hide: 50 }
        });
    });
}

function addLoadingStates() {
    // Add loading state to buttons
    document.querySelectorAll('button[type="submit"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="loading-spinner"></span> Loading...';
            this.disabled = true;
            
            // Reset button after 2 seconds (simulate loading)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 2000);
        });
    });
}

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <i class="fas ${getToastIcon(type)}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function getToastIcon(type) {
    switch(type) {
        case 'success': return 'fa-check-circle';
        case 'error': return 'fa-exclamation-circle';
        case 'warning': return 'fa-exclamation-triangle';
        default: return 'fa-info-circle';
    }
}

// Add slideOutRight animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Example usage of toast
// showToast('Operation successful!', 'success');
// showToast('An error occurred', 'error');
// showToast('Please be careful', 'warning');
// showToast('Information message', 'info'); 