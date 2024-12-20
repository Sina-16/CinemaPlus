<?php
session_start();
require_once 'Database.php';
require_once 'MovieController.php';

$database = new Database();
$conn = $database->getConnection();
$movieController = new MovieController($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'title' => $_POST['title'],
        'genre' => $_POST['genre'],
        'rating' => $_POST['rating'],
        'actors' => $_POST['actors'],
        'release_date' => $_POST['release_date'],
        'description' => $_POST['description'],
        'duration' => $_POST['duration'],
        'image_path' => $_FILES['image']['name'] 
    ];


    if (!empty($_FILES['image']['name'])) {
        $uploadDir = 'uploads/';
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $_FILES['image']['name']);
    } else {
       
        unset($data['image_path']);
    }

    $movieController->editMovie($_POST['id'], $data);
    $_SESSION['message'] = "Movie updated successfully!";
    header("Location: editMovie.php?id=" . $_POST['id']);
    exit();
}

$movie = $movieController->getMovie($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Movie</title>
    <?php include 'head.php'; ?>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Edit Movie</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form action="editMovie.php?id=<?php echo $movie['id']; ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-bold mb-2">Title:</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required class="border rounded w-full p-2">
                </div>

                <div class="mb-4">
                    <label for="genre" class="block text-sm font-bold mb-2">Genre:</label>
                    <input type="text" name="genre" value="<?php echo htmlspecialchars($movie['genre']); ?>" required class="border rounded w-full p-2">
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-sm font-bold mb-2">Rating:</label>
                    <input type="number" name="rating" value="<?php echo htmlspecialchars($movie['rating']); ?>" step="0.1" required class="border rounded w-full p-2">
                </div>

                <div class="mb-4">
                    <label for="actors" class="block text-sm font-bold mb-2">Actors:</label>
                    <input type="text" name="actors" value="<?php echo htmlspecialchars($movie['actors']); ?>" required class="border rounded w-full p-2">
                </div>

                <div class="mb-4">
                    <label for="release_date" class="block text-sm font-bold mb-2">Release Date:</label>
                    <input type="date" name="release_date" value="<?php echo htmlspecialchars($movie['release_date']); ?>" required class="border rounded w-full p-2">
                </div>

                <div class="mb-4">
                    <label for="duration" class="block text-sm font-bold mb-2">Duration (mins):</label>
                    <input type="number" name="duration" value="<?php echo htmlspecialchars($movie['duration']); ?>" required class="border rounded w-full p-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Current Image:</label>
                <?php if (!empty($movie['image_path'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($movie['image_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="w-full h-auto mb-2 rounded shadow">
                <?php else: ?>
                    <p class="text-gray-600">No image available.</p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-bold mb-2">Description:</label>
                <textarea name="description" required class="border rounded w-full p-2"><?php echo htmlspecialchars($movie['description']); ?></textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-bold mb-2">Image:</label>
                <input type="file" name="image" class="border rounded w-full p-2">
                <p class="text-sm text-gray-600">Leave blank to keep the current image.</p>
            </div>

            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Update Movie</button>
        </form>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
