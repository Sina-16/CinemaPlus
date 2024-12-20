<?php
class Movie {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

   
    public function addMovie($data) {
        $sql = "INSERT INTO movies (title, genre, rating, actors, release_date, description, duration, image_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
       
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

      
        return $stmt->execute();
    }

  
    public function updateMovie($id, $data) {
        $sql = "UPDATE movies SET title = ?, genre = ?, rating = ?, actors = ?, release_date = ?, description = ?, duration = ?, image_path = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
       
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

        return $stmt->execute();
    }

    
}
?>
