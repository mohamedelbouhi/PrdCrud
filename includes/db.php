<?php
/**
 * Database Connection & Setup
 * 
 * Handles database connection and automatic schema initialization.
 * Designed for ease of use and portability.
 */

// Configuration
$db_config = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'crud_demo'
];

// 1. Establish initial connection
$conn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass']);

// Check connection
if ($conn->connect_error) {
    die_with_error("Connection Failed", "Could not connect to MySQL server. Ensure XAMPP/MAMP is running.", $conn->connect_error);
}

// 2. Database Checks & Initialization
$db_check = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$db_config['name']}'");

if ($db_check->num_rows == 0) {
    // Auto-create database if not exists
    if ($conn->query("CREATE DATABASE IF NOT EXISTS `{$db_config['name']}`")) {
        $conn->select_db($db_config['name']);
        initialize_schema($conn);
    } else {
        die_with_error("Database Creation Failed", "Could not create database '{$db_config['name']}'.", $conn->error);
    }
} else {
    $conn->select_db($db_config['name']);
}

// Set Charset
$conn->set_charset("utf8mb4");

/**
 * Initialize Database Schema and Seeds
 */
function initialize_schema($conn) {
    // Products Table
    $sql = "CREATE TABLE IF NOT EXISTS `products` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `description` text,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql)) {
        // Seed Initial Data
        $conn->query("INSERT INTO `products` (`name`, `price`, `description`) VALUES 
            ('ماك بوك برو 16 إنش', 2499.00, 'أحدث إصدار بمعالج M3 Max وشاشة ريتينا فائقة الدقة.'),
            ('آيفون 15 برو ماكس', 1199.00, 'تصميم تيتانيوم وكاميرا احترافية بدقة 48 ميجا بكسل.'),
            ('ساعة آبل الترا 2', 799.00, 'الساعة الأكثر صلابة ومميزات للرياضيين والمحترفين.')");
    }
}

/**
 * Display a nice error message and stop execution
 */
function die_with_error($title, $message, $debug = '') {
    $html = "<div style='direction:rtl; padding:30px; background:#1e293b; border:1px solid #ef4444; border-radius:15px; font-family:system-ui, sans-serif; color:#f8fafc; margin:50px auto; max-width:600px; text-align:center;'>
                <h2 style='color:#ef4444; margin-top:0;'>❌ $title</h2>
                <p style='font-size:1.1rem; line-height:1.6;'>$message</p>
                " . ($debug ? "<div style='background:rgba(255,0,0,0.1); padding:10px; border-radius:8px; font-family:monospace; margin-top:20px; font-size:0.9rem; text-align:left; direction:ltr;'>Error: $debug</div>" : "") . "
             </div>";
    die($html);
}
?>
