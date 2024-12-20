<?php
class Movie {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add a new movie
    public function addMovie($data) {
        $sql = "INSERT INTO movies (title, genre, rating, actors, release_date, description, duration, image_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters correctly
        $stmt->bind_param("ssissssi", 
            $data['title'], 
            $data['genre'], 
            $data['rating'], 
            $data['actors'], 
            $data['release_date'], 
            $data['description'], 
            $data['duration'], 
            $data['image_path']
        );

        // Execute the statement
        return $stmt->execute();
    }

    // Update an existing movie
    public function updateMovie($id, $data) {
        $sql = "UPDATE movies SET title = ?, genre = ?, rating = ?, actors = ?, release_date = ?, description = ?, duration = ?, image_path = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters correctly
        $stmt->bind_param("ssissssii", 
            $data['title'], 
            $data['genre'], 
            $data['rating'], 
            $data['actors'], 
            $data['release_date'], 
            $data['description'], 
            $data['duration'], 
            $data['image_path'],
            $id
        );

        // Execute the statement
        return $stmt->execute();
    }

    // Other methods like getMovie, getAllMovies, etc. can be added here
}
?>
