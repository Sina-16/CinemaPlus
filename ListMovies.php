<?php
session_start();
require_once 'Database.php';
require_once 'MovieController.php';

$database = new Database();
$conn = $database->getConnection();
$movieController = new MovieController($conn);

// Fetch all movies
$movies = $movieController->getAllMovies();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .blink {
            animation: blink-animation 1s steps(5, start) infinite;
        }

        .text-red-500 {
            --tw-text-opacity: 1;
            color: rgba(239, 68, 68, var(--tw-text-opacity));
            margin-top: 20%;
            padding: inherit;
        }
        
        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <?php include 'head.php'; ?>

    <main class="container mx-auto p-4">
        <?php
        // Display success or error message
        if (isset($_SESSION['message'])) {
            echo "<div class='bg-green-500 text-white p-2 rounded text-center font-bold blink'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }

        // Check if there are no movies
        if (empty($movies)) {
            echo "<div class='text-red-500 text-center font-bold p-4 text-2xl blink'>No movies available.</div>";
            echo "<div class='text-center mt-4'>";
            echo "<a href='addMovie.php' class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition'>Add Movie Manually</a>";
            echo "</div>";
        } else {
        ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($movies as $movie): ?>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="/cinema_plus/uploads/<?php echo htmlspecialchars($movie['image_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="font-bold text-lg"><?php echo htmlspecialchars($movie['title']); ?></h2>
                            <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                            <p><strong>Rating:</strong> <?php echo htmlspecialchars($movie['rating']); ?></p>
                            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                            <p><strong>Duration:</strong> <?php echo htmlspecialchars($movie['duration']); ?> mins</p>
                            <p class="text-gray-600"><?php echo htmlspecialchars($movie['description']); ?></p>
                        </div>
                        <div class="flex justify-between p-4">
                            <a href="editMovie.php?id=<?php echo htmlspecialchars($movie['id']); ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Edit</a>
                            <a href="deleteMovie.php?id=<?php echo htmlspecialchars($movie['id']); ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition" onclick="return confirm('Are you sure you want to delete this movie?');">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </main>
    
    <?php include 'footer.php'; ?>
   
</body>
</html>
