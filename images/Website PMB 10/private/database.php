<?php
// Database configuration
$host = 'localhost'; // Database host
$dbname = 'your_database_name'; // Database name
$username = 'your_username'; // Database username
$password = 'your_password'; // Database password

try {
    // Create a new PDO instance
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}

// Function to execute a query
function executeQuery($query, $params = []) {
    global $db;
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

// Function to fetch all records
function fetchAll($query, $params = []) {
    return executeQuery($query, $params)->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch a single record
function fetchOne($query, $params = []) {
    return executeQuery($query, $params)->fetch(PDO::FETCH_ASSOC);
}
?>