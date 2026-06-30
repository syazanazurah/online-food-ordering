<?php
// =============================================================================
// NomNom — Database Connection
// Centralised PDO + mysqli connection to the MariaDB `restaurant` database.
// Include this file at the top of any PHP page that needs database access.
//
// Usage:
//   require_once __DIR__ . '/../config/connection.php';
//   // $pdo  — PDO instance (prepared statements)
//   // $conn — mysqli instance (legacy / quick queries)
// =============================================================================

// ---------------------------------------------------------------------------
// Connection credentials
// ---------------------------------------------------------------------------
define('DB_HOST', 'localhost');    // Use 'db' if running inside Docker, or 'localhost' if running locally using XAMPP/php built-in server
define('DB_NAME', 'restaurant');
define('DB_USER', 'nomnom');
define('DB_PASS', '123456');
define('DB_CHARSET', 'utf8mb4');

// ---------------------------------------------------------------------------
// PDO connection (preferred — use prepared statements)
// ---------------------------------------------------------------------------
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection failed: ' . $e->getMessage());
}

// ---------------------------------------------------------------------------
// mysqli connection (alternative — for legacy code or quick queries)
// ---------------------------------------------------------------------------
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    http_response_code(500);
    die('mysqli connection failed: ' . $conn->connect_error);
}
$conn->set_charset(DB_CHARSET);
