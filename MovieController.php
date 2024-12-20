<?php
require_once 'Movie.php';

class MovieController {
    private $movieModel;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->movieModel = new Movie($db);
    }

    // Add a new movie
    public function addMovie($data) {
        if ($this->movieModel->addMovie($data)) {
            $_SESSION['message'] = "Movie added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add movie.";
        }
        header("Location: addMovie.php");
        exit();
    }

    // Edit an existing movie
    public function editMovie($id, $data) {
        if ($this->movieModel->updateMovie($id, $data)) {
            $_SESSION['message'] = "Movie updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update movie.";
        }
        header("Location: editMovie.php?id=" . $id);
        exit();
    }

    // Fetch all movies
    public function getAllMovies() {
        $query = "SELECT * FROM movies"; // Adjust the table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Fetch all rows into an array
    }

    // Get a specific movie by ID
    public function getMovie($id) {
        $query = "SELECT * FROM movies WHERE id = ?"; // Adjust the table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id); // Bind the ID parameter
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // Fetch and return the specific movie
    }

    // Delete a movie
    public function deleteMovie($id) {
        $query = "DELETE FROM movies WHERE id = ?"; // Use ? for parameter binding
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id); // Bind the ID parameter

        return $stmt->execute(); // Returns true on success, false on failure
    }
}

?>
