<?php
session_start();
require_once 'Database.php';
require_once 'MovieController.php';

$database = new Database();
$conn = $database->getConnection();
$movieController = new MovieController($conn);


if (isset($_GET['id'])) {
    $movieId = intval($_GET['id']);
    
  
    if ($movieController->deleteMovie($movieId)) {
        $_SESSION['message'] = "Movie deleted successfully!";
    } else {
        $_SESSION['message'] = "Failed to delete movie.";
    }
} else {
    $_SESSION['message'] = "Invalid movie ID.";
}


header("Location: ListMovies.php");
exit();
?>
