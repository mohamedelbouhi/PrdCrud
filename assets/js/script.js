/**
 * ═══════════════════════════════════════════════════════════════
 * FIRST PRDCRUD - ULTIMATE LUXURY EDITION
 * JavaScript Core System - النظام الأساسي للتفاعلات
 * ═══════════════════════════════════════════════════════════════
 */

/* ═══════════════════════════════════════════════════════════════
   🎨 PARTICLE SYSTEM - نظام الجزيئات المتحركة
   ═══════════════════════════════════════════════════════════════ */
class ParticleSystem {
    constructor() {
        this.canvas = document.createElement('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.particles = [];
        this.particleCount = 50;
        
        this.init();
    }
    
    init() {
        // Setup Canvas
        this.canvas.style.position = 'fixed';
        this.canvas.style.top = '0';
        this.canvas.style.left = '0';
        this.canvas.style.width = '100%';
        this.canvas.style.height = '100%';
        this.canvas.style.pointerEvents = 'none';
        this.canvas.style.zIndex = '0';
        document.body.prepend(this.canvas);
        
        this.resize();
        this.createParticles();
        this.animate();
        
        window.addEventListener('resize', () => this.resize());
    }
    
    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }
    
    createParticles() {
        for (let i = 0; i < this.particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                size: Math.random() * 3 + 1,
                speedX: Math.random() * 0.5 - 0.25,
                speedY: Math.random() * 0.5 - 0.25,
                opacity: Math.random() * 0.5 + 0.2
            });
        }
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        this.particles.forEach((particle, index) => {
            // Update position
            particle.x += particle.speedX;
            particle.y += particle.speedY;
            
            // Wrap around screen
            if (particle.x < 0) particle.x = this.canvas.width;
            if (particle.x > this.canvas.width) particle.x = 0;
            if (particle.y < 0) particle.y = this.canvas.height;
            if (particle.y > this.canvas.height) particle.y = 0;
            
            // Draw particle
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            this.ctx.fillStyle = `rgba(129, 140, 248, ${particle.opacity})`;
            this.ctx.fill();
            
            // Draw connections
            this.particles.forEach((otherParticle, otherIndex) => {
                if (index !== otherIndex) {
                    const dx = particle.x - otherParticle.x;
                    const dy = particle.y - otherParticle.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < 150) {
                        this.ctx.beginPath();
                        this.ctx.strokeStyle = `rgba(129, 140, 248, ${0.1 * (1 - distance / 150)})`;
                        this.ctx.lineWidth = 1;
                        this.ctx.moveTo(particle.x, particle.y);
                        this.ctx.lineTo(otherParticle.x, otherParticle.y);
                        this.ctx.stroke();
                    }
                }
            });
        });
        
        requestAnimationFrame(() => this.animate());
    }
}

/* ═══════════════════════════════════════════════════════════════
   🚀 PAGE INITIALIZATION - تهيئة الصفحة
   ═══════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Particle System
    new ParticleSystem();
    
    // Initialize Search
    initializeSearch();
    
    // Initialize Animations
    initializeAnimations();
    
    // Add Ripple Effect to Buttons
    addRippleEffect();
});

/* ═══════════════════════════════════════════════════════════════
   🔍 SEARCH SYSTEM - نظام البحث الذكي
   ═══════════════════════════════════════════════════════════════ */
function initializeSearch() {
    const searchInput = document.getElementById('masterSearch');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function(e) {
        const filter = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.product-row');
        
        rows.forEach((row, index) => {
            const text = row.textContent.toLowerCase();
            const shouldShow = text.includes(filter);
            
            if (shouldShow) {
                row.style.display = '';
                row.style.animation = `fadeUp 0.5s ease-out ${index * 0.05}s forwards`;
            } else {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.display = 'none';
                }, 300);
            }
        });
        
        // Show "No Results" message
        const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
        const container = document.getElementById('productDataGrid');
        let noResultsMsg = document.getElementById('noResultsMessage');
        
        if (visibleRows.length === 0 && filter !== '') {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noResultsMessage';
                noResultsMsg.className = 'text-center py-5 fade-in';
                noResultsMsg.innerHTML = `
                    <div style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem;">🔍</div>
                    <h4 class="text-muted">لم يتم العثور على نتائج</h4>
                    <p class="text-secondary">جرب البحث بكلمات مختلفة</p>
                `;
                container.appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    });
}

/* ═══════════════════════════════════════════════════════════════
   ✨ ANIMATIONS - الأنيميشنز والتأثيرات
   ═══════════════════════════════════════════════════════════════ */
function initializeAnimations() {
    // Intersection Observer for Scroll Animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-up');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observe all animatable elements
    document.querySelectorAll('.product-row, .glass-card, .product-list-card').forEach(el => {
        observer.observe(el);
    });
}

/* ═══════════════════════════════════════════════════════════════
   💧 RIPPLE EFFECT - تأثير الموجة على الأزرار
   ═══════════════════════════════════════════════════════════════ */
function addRippleEffect() {
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple-effect');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
}

/* ═══════════════════════════════════════════════════════════════
   🎭 MODAL SYSTEM - نظام المودال الاحترافي
   ═══════════════════════════════════════════════════════════════ */

/**
 * Show Cinema Success Modal
 */
function revealCinemaSuccess(message) {
    const backdrop = document.getElementById('cinemaBackdrop');
    const title = document.getElementById('cinemaTitle');
    const body = document.getElementById('cinemaBody');
    const icon = document.getElementById('cinemaIcon');
    const confirmActions = document.getElementById('confirmActions');
    const successActions = document.getElementById('successActions');
    
    // Setup Success Mode
    title.textContent = 'تمت العملية بنجاح';
    body.textContent = message;
    icon.innerHTML = `
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
             stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="checkmark-svg">
            <polyline points="20 6 9 17 4 12" style="stroke: #10b981;"></polyline>
        </svg>
    `;
    
    confirmActions.classList.add('hidden');
    successActions.classList.remove('hidden');
    
    backdrop.classList.add('active');
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        dismissCinema();
    }, 3000);
}

/**
 * Show Cinema Delete Confirmation
 */
function requestCinemaDelete(productName, deleteUrl) {
    const backdrop = document.getElementById('cinemaBackdrop');
    const title = document.getElementById('cinemaTitle');
    const body = document.getElementById('cinemaBody');
    const icon = document.getElementById('cinemaIcon');
    const confirmActions = document.getElementById('confirmActions');
    const successActions = document.getElementById('successActions');
    const execBtn = document.getElementById('execCinemaBtn');
    
    // Setup Confirmation Mode
    title.textContent = 'تأكيد عملية الحذف';
    body.textContent = `هل أنت متأكد من حذف المنتج "${productName}"؟ لا يمكن التراجع عن هذه العملية.`;
    icon.innerHTML = `
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
             stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10" style="stroke: #f87171;"></circle>
            <line x1="12" y1="8" x2="12" y2="12" style="stroke: #f87171;"></line>
            <line x1="12" y1="16" x2="12.01" y2="16" style="stroke: #f87171;"></line>
        </svg>
    `;
    
    confirmActions.classList.remove('hidden');
    successActions.classList.add('hidden');
    
    backdrop.classList.add('active');
    
    // Set delete action
    execBtn.onclick = function() {
        window.location.href = deleteUrl;
    };
}

/**
 * Dismiss Modal
 */
function dismissCinema() {
    const backdrop = document.getElementById('cinemaBackdrop');
    backdrop.classList.remove('active');
}

/* ═══════════════════════════════════════════════════════════════
   📝 FORM MANAGEMENT - إدارة النماذج
   ═══════════════════════════════════════════════════════════════ */

/**
 * Toggle Add Form (Hero Form)
 */
function toggleHeroForm() {
    const formWrapper = document.getElementById('addFormWrapper');
    const isHidden = formWrapper.classList.contains('hidden');
    
    if (isHidden) {
        formWrapper.classList.remove('hidden');
        formWrapper.style.animation = 'fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards';
        
        // Smooth scroll to form
        setTimeout(() => {
            formWrapper.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
        
        // Focus first input
        setTimeout(() => {
            const firstInput = formWrapper.querySelector('input[type="text"]');
            if (firstInput) firstInput.focus();
        }, 700);
    } else {
        formWrapper.style.animation = 'fadeOut 0.4s ease-out forwards';
        setTimeout(() => {
            formWrapper.classList.add('hidden');
        }, 400);
    }
}

/* ═══════════════════════════════════════════════════════════════
   🎪 TOAST NOTIFICATION SYSTEM - نظام الإشعارات
   ═══════════════════════════════════════════════════════════════ */
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
    const icon = type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ';
    
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-message">${message}</div>
    `;
    
    // Add styles if not already present
    if (!document.getElementById('toastStyles')) {
        const style = document.createElement('style');
        style.id = 'toastStyles';
        style.textContent = `
            .toast-notification {
                position: fixed;
                top: 30px;
                right: 30px;
                background: rgba(15, 22, 41, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 20px;
                padding: 20px 30px;
                display: flex;
                align-items: center;
                gap: 15px;
                z-index: 10001;
                animation: slideInRight 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            }
            .toast-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                font-weight: bold;
            }
            .toast-success .toast-icon {
                background: rgba(16, 185, 129, 0.2);
                color: #10b981;
            }
            .toast-error .toast-icon {
                background: rgba(239, 68, 68, 0.2);
                color: #ef4444;
            }
            .toast-message {
                color: white;
                font-weight: 600;
                font-size: 1.05rem;
            }
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(toast);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) reverse forwards';
        setTimeout(() => toast.remove(), 400);
    }, 4000);
}

/* ═══════════════════════════════════════════════════════════════
   🎯 SMOOTH SCROLL - التمرير السلس
   ═══════════════════════════════════════════════════════════════ */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

/* ═══════════════════════════════════════════════════════════════
   ⌨️ KEYBOARD SHORTCUTS - اختصارات لوحة المفاتيح
   ═══════════════════════════════════════════════════════════════ */
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K: Focus Search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('masterSearch');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
    
    // Escape: Close Modal or Form
    if (e.key === 'Escape') {
        const backdrop = document.getElementById('cinemaBackdrop');
        if (backdrop && backdrop.classList.contains('active')) {
            dismissCinema();
        }
        
        const formWrapper = document.getElementById('addFormWrapper');
        if (formWrapper && !formWrapper.classList.contains('hidden')) {
            toggleHeroForm();
        }
    }
    
    // Ctrl/Cmd + N: New Product
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        const formWrapper = document.getElementById('addFormWrapper');
        if (formWrapper && formWrapper.classList.contains('hidden')) {
            toggleHeroForm();
        }
    }
});

/* ═══════════════════════════════════════════════════════════════
   📊 PERFORMANCE MONITORING - مراقبة الأداء
   ═══════════════════════════════════════════════════════════════ */
window.addEventListener('load', function() {
    // Log page load time
    if (window.performance) {
        const perfData = window.performance.timing;
        const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        console.log(`⚡ Page loaded in ${pageLoadTime}ms`);
    }
});

/* ═══════════════════════════════════════════════════════════════
   🎨 DYNAMIC THEME ADJUSTMENTS - تعديلات الثيم الديناميكية
   ═══════════════════════════════════════════════════════════════ */
function adjustThemeBasedOnTime() {
    const hour = new Date().getHours();
    const root = document.documentElement;
    
    // Adjust colors based on time of day
    if (hour >= 6 && hour < 12) {
        // Morning: Lighter tones
        root.style.setProperty('--bg-deep', '#0c1020');
    } else if (hour >= 12 && hour < 18) {
        // Afternoon: Standard
        root.style.setProperty('--bg-deep', '#0a0e1a');
    } else {
        // Evening/Night: Deeper tones
        root.style.setProperty('--bg-deep', '#050811');
    }
}

// Call on load
adjustThemeBasedOnTime();

/* ═══════════════════════════════════════════════════════════════
   END OF SCRIPT
   ═══════════════════════════════════════════════════════════════ */
