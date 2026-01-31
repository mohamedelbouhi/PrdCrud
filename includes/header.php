<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المنتجات | FIRST PRDCRUD</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="نظام احترافي لإدارة المنتجات بتصميم فاخر وأنيميشنز متقدمة">
    <meta name="keywords" content="CRUD, إدارة منتجات, نظام احترافي">
    
    <!-- Bootstrap 5 RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>F</text></svg>">
</head>
<body>
    <!-- ═══════════════════════════════════════════════════════════════
         🎬 PREMIUM PAGE LOADER - شاشة التحميل الفاخرة
         ═══════════════════════════════════════════════════════════════ -->
    <div id="pageLoader" class="page-loader">
        <div class="loader-content">
            <div class="loader-logo">
                <div class="logo-ring"></div>
                <div class="logo-ring"></div>
                <div class="logo-ring"></div>
                <div class="logo-text">FIRST</div>
            </div>
            <div class="loader-progress">
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" id="loaderProgress"></div>
                </div>
                <p class="loader-text">جاري التحميل...</p>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════
         🎯 NAVIGATION BAR - شريط التنقل
         ═══════════════════════════════════════════════════════════════ -->
    <nav class="navbar sticky-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="w-100 text-center">
                    <h1 class="navbar-brand mb-0" style="font-size: 1.8rem; font-weight: 900; letter-spacing: -1px;">
                        FIRST PRDCRUD
                    </h1>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">

<!-- Page Loader Styles -->
<style>
.page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #0a0e1a 0%, #0f1629 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    transition: opacity 0.6s ease, visibility 0.6s ease;
}

.page-loader.loaded {
    opacity: 0;
    visibility: hidden;
}

.loader-content {
    text-align: center;
}

.loader-logo {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 40px;
}

.logo-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 3px solid transparent;
    border-top-color: #818cf8;
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

.logo-ring:nth-child(1) {
    width: 120px;
    height: 120px;
    animation-duration: 2s;
}

.logo-ring:nth-child(2) {
    width: 90px;
    height: 90px;
    animation-duration: 1.5s;
    border-top-color: #fbbf24;
}

.logo-ring:nth-child(3) {
    width: 60px;
    height: 60px;
    animation-duration: 1s;
    border-top-color: #10b981;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

.logo-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
    font-weight: 900;
    background: linear-gradient(135deg, #fff, #818cf8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.loader-progress {
    margin-top: 30px;
}

.progress-bar-container {
    width: 250px;
    height: 4px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    overflow: hidden;
    margin: 0 auto 15px;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #818cf8, #fbbf24);
    border-radius: 10px;
    width: 0%;
    transition: width 0.3s ease;
}

.loader-text {
    color: var(--text-secondary);
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
}

/* Navigation Stats */
.stat-badge {
    background: rgba(129, 140, 248, 0.1);
    border: 1px solid rgba(129, 140, 248, 0.2);
    border-radius: 15px;
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition-smooth);
}

.stat-badge:hover {
    background: rgba(129, 140, 248, 0.15);
    border-color: rgba(129, 140, 248, 0.3);
    transform: translateY(-2px);
}

.stat-icon {
    font-size: 1.2rem;
}

.stat-value {
    font-weight: 800;
    color: var(--accent-glow);
    font-size: 1.1rem;
}

/* Theme Toggle Button */
.theme-toggle-btn {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--border-light);
    border-radius: 12px;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-smooth);
}

.theme-toggle-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: var(--border-active);
    transform: scale(1.1) rotate(15deg);
}

.theme-icon {
    font-size: 1.3rem;
    transition: var(--transition-smooth);
}
</style>

<!-- Page Loader Script -->
<script>
// Page Loader Animation
window.addEventListener('load', function() {
    const loader = document.getElementById('pageLoader');
    const progressBar = document.getElementById('loaderProgress');
    
    // Simulate loading progress
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 30;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
            
            // Hide loader after completion
            setTimeout(() => {
                loader.classList.add('loaded');
            }, 300);
        }
        progressBar.style.width = progress + '%';
    }, 200);
});

// Update product count in navbar
function updateProductCount() {
    const productRows = document.querySelectorAll('.product-row');
    const countElement = document.getElementById('productCount');
    if (countElement) {
        countElement.textContent = productRows.length;
    }
}

// Call on page load
setTimeout(updateProductCount, 500);

// Theme Toggle Function
function toggleThemeMode() {
    const root = document.documentElement;
    const currentBg = getComputedStyle(root).getPropertyValue('--bg-deep');
    
    if (currentBg.includes('0a0e1a')) {
        // Switch to lighter dark mode
        root.style.setProperty('--bg-deep', '#1a1f2e');
        root.style.setProperty('--bg-card', '#242938');
    } else {
        // Switch back to deep dark mode
        root.style.setProperty('--bg-deep', '#0a0e1a');
        root.style.setProperty('--bg-card', '#0f1629');
    }
}
</script>
