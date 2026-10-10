<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Safe vendor autoload
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

// Load .env safely if present
if (class_exists('Dotenv\Dotenv') && file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->safeLoad();
}

// Read env variables with sensible fallbacks
$host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost';
$username = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: 'root';
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';
$dbName = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'vocation_travels_db';

// Dynamic Site URL detection (seamless on Hostinger domain vs localhost)
$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
$protocol = $isHttps ? 'https://' : 'http://';

if (!empty($httpHost) && strpos($httpHost, 'localhost') === false && strpos($httpHost, '127.0.0.1') === false) {
    // Production (Hostinger / live domain: e.g. vocationtravels.in)
    $site = $protocol . $httpHost . '/';
} elseif (!empty($_ENV['SITE'])) {
    $site = rtrim($_ENV['SITE'], '/') . '/';
} else {
    // Local development fallback
    $site = $protocol . ($httpHost ?: 'localhost') . '/vocation-travels/';
}

// Make `$site` global
global $site;

// Create Database Connection
$conn = @new mysqli($host, $username, $password, $dbName);

// Check Connection
if ($conn->connect_error) {
    // Graceful error message without leaking sensitive internal paths
    error_log("Database Connection Failed: " . $conn->connect_error);
    if (!empty($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
        die("Database Connection Failed: " . $conn->connect_error . " (Check your .env database configuration)");
    } else {
        die("<div style='text-align:center;padding:50px;font-family:sans-serif;'><h2>Website Maintenance</h2><p>Database connection error. Please ensure database credentials are configured in your Hostinger .env file.</p></div>");
    }
}

$conn->set_charset("utf8mb4");
