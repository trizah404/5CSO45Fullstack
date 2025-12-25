<?php
$host = 'localhost';
$dbname = 'school_db';   // your database name
$username = 'root';      // default user for local dev
$password = '';          // leave empty if no password set

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful using PDO!";
} catch (PDOException $e) {
    echo " Connection failed: " . $e->getMessage();
}
?>