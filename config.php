<?php
$host = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$databaseName = "php_test";
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS $databaseName";

if ($conn->query($createDatabaseQuery) === TRUE) {
    echo "Database created successfully<br>";

    $conn->select_db($databaseName);

    $checkTableQuery = "SHOW TABLES LIKE 'contact_form'";
    $result = $conn->query($checkTableQuery);

    if ($result->num_rows == 0) {

        $createTableQuery = "CREATE TABLE contact_form (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255),
            phone_number VARCHAR(20),
            email VARCHAR(255),
            subject VARCHAR(255),
            message TEXT,
            ip_address VARCHAR(45),
            timestamp TIMESTAMP
        )";

        if ($conn->query($createTableQuery) === TRUE) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    } 
} else {
    echo "Error creating database: " . $conn->error;
}


?>
