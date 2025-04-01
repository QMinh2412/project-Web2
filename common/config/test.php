<?php
require_once __DIR__ . '/Database.php';


// Get database connection instance
$db = Database::getInstance();

if ($db) {
    echo "✅ Database connected successfully!";
} else {
    echo "❌ Database connection failed!";
}
?>