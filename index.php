<?php
session_start();
require_once 'Database.php';
require_once 'MovieController.php';

$database = new Database();
$conn = $database->getConnection();
$movieController = new MovieController($conn);

// Routing logic can be added here based on the URL
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    // Handle actions like add, edit, delete, etc.
} else {
    // Default to showing movies
    header("Location: ListMovies.php");
    exit();
}
?>
