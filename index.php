<?php

// Import database configuration
include_once 'config/Database.php';

// Instantiate database and connect
$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "Database connection successful.<br>";
} else {
    echo "Database connection failed.<br>";
}

echo "Welcome to the E-Learning REST API -arya";
?>
