<?php
session_start();
require_once 'Database.php';
require_once 'MovieController.php';

$database = new Database();
$conn = $database->getConnection();
$movieController = new MovieController($conn);


if (isset($_GET['action'])) {
    $action = $_GET['action'];

} else {
 
    header("Location: ListMovies.php");
    exit();
}
?>
