<?php

// Database configuration
$host = "localhost";
$db_name = "php_oop_crud";
$username = "root";
$password = "";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    $pdo->exec($sql);
    echo "Database created successfully.<br>";

    // Use the created database
    $pdo->exec("USE $db_name");

    // Create tables
    $sql = "
    -- Create table for classes
    CREATE TABLE IF NOT EXISTS classes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT
    );

    -- Create table for subjects
    CREATE TABLE IF NOT EXISTS subjects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        class_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        FOREIGN KEY (class_id) REFERENCES classes(id)
    );

    -- Create table for assignments
    CREATE TABLE IF NOT EXISTS assignments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        subject_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        due_date DATE,
        FOREIGN KEY (subject_id) REFERENCES subjects(id)
    );

    -- Create table for users
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    );

    -- Create table for submissions
    CREATE TABLE IF NOT EXISTS submissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        assignment_id INT NOT NULL,
        user_id INT NOT NULL,
        submission_date DATE,
        content TEXT,
        FOREIGN KEY (assignment_id) REFERENCES assignments(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    ";

    // Execute the SQL script
    $pdo->exec($sql);
    echo "Tables created successfully.<br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>