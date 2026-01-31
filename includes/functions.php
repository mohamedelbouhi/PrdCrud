<?php
/**
 * الدوال المساعدة والعمليات الأساسية - نظام إدارة المنتجات
 * تم التصميم بأعلى معايير الكود النظيف والأمان
 */

// بدء الجلسة في بداية الملف لتجنب مشاكل الـ Headers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * تنظيف البيانات المدخلة لمنع هجمات XSS
 */
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * تعيين رسالة تنبيه ذكية في الجلسة
 */
function set_flash_message($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type, // نجاح (success)، خطر (danger)، تنبيه (warning)
        'message' => $message,
        'id' => uniqid() // معرف فريد لكل رسالة
    ];
}

/**
 * عرض رسالة التنبيه بتصميم شيك وعصري
 */
function display_flash_message() {
    if (isset($_SESSION['flash'])) {
        $type = $_SESSION['flash']['type'];
        $message = $_SESSION['flash']['message'];
        unset($_SESSION['flash']);

        $icons = [
            'success' => '',
            'danger' => '',
            'warning' => '',
            'info' => ''
        ];
        $icon = $icons[$type] ?? '';

        echo "<div class='luxury-toast fade-in mb-4' id='system-toast'>
                <div class='toast-icon' style='font-size: 1.5rem;'>{$icon}</div>
                <div class='toast-content'>
                    <div class='fw-bold' style='color: var(--text-main); font-size: 0.9rem;'>إشعار النظام</div>
                    <div class='small text-muted'>{$message}</div>
                </div>
                <button type='button' class='btn-close btn-close-white ms-auto' onclick='document.getElementById(\"system-toast\").remove()'></button>
              </div>";
              
        // إخفاء تلقائي بعد 5 ثوانٍ
        echo "<script>setTimeout(() => { 
            const t = document.getElementById('system-toast');
            if(t) { t.style.opacity = '0'; t.style.transform = 'translateX(50px)'; setTimeout(() => t.remove(), 500); }
        }, 5000);</script>";
    }
}

/**
 * التحويل لصفحة أخرى بشكل آمن
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * جلب جميع المنتجات بترتيب الأحدث
 */
function get_all_products($conn) {
    try {
        $sql = "SELECT * FROM products ORDER BY id DESC";
        return $conn->query($sql);
    } catch (Exception $e) {
        return false;
    }
}

/**
 * جلب بيانات منتج محدد بواسطة المعرف ID
 */
function get_product_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    if (!$stmt) return false;
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * إضافة منتج جديد - أمان كامل باستخدام Prepared Statements
 */
function create_product($conn, $name, $price, $description) {
    $stmt = $conn->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
    if (!$stmt) return false;
    
    $stmt->bind_param("sds", $name, $price, $description);
    return $stmt->execute();
}

/**
 * تحديث بيانات منتج موجود
 */
function update_product($conn, $id, $name, $price, $description) {
    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
    if (!$stmt) return false;
    
    $stmt->bind_param("sdsi", $name, $price, $description, $id);
    return $stmt->execute();
}

/**
 * حذف منتج نهائياً
 */
function delete_product($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    if (!$stmt) return false;
    
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
