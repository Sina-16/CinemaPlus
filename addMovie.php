<?php
session_start();
require_once 'Database.php';
require_once 'MovieController.php';

$database = new Database();
$conn = $database->getConnection();
$movieController = new MovieController($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $data = [
        'title' => htmlspecialchars(trim($_POST['title'])),
        'genre' => htmlspecialchars(trim($_POST['genre'])),
        'rating' => floatval($_POST['rating']),
        'actors' => htmlspecialchars(trim($_POST['actors'])),
        'release_date' => htmlspecialchars(trim($_POST['release_date'])),
        'description' => htmlspecialchars(trim($_POST['description'])),
        'duration' => intval($_POST['duration']),
        'image_path' => ''
    ];

    // Ensure the uploads directory exists
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
    }

    // Check for upload errors
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "File upload error: " . $_FILES['image']['error'];
        header("Location: addMovie.php");
        exit();
    }

    // Check file size (limit to 2MB)
    if ($_FILES['image']['size'] > 2000000) {
        $_SESSION['message'] = "File is too large. Maximum size is 2MB.";
        header("Location: addMovie.php");
        exit();
    }

    // Check file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $allowedTypes)) {
        $_SESSION['message'] = "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: addMovie.php");
        exit();
    }

    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mimeType, $allowedMimes)) {
        $_SESSION['message'] = "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: addMovie.php");
        exit();
    }

    // Generate a new unique file name
    $newFileName = strtolower(str_replace(' ', '_', $data['title'])) . '.' . $imageFileType; // Use movie title for the file name
    $targetFile = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // File upload successful, add movie to database
        $data['image_path'] = $newFileName; // Store the new file name in the database
        if ($movieController->addMovie($data)) {
            $_SESSION['message'] = "Movie added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add movie.";
        }
    } else {
        $_SESSION['message'] = "Failed to upload image.";
    }

    // Redirect to avoid resubmission
    header("Location: addMovie.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Movie</title>
    <?php include 'head.php'; ?>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Add New Movie</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form action="addMovie.php" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded p-8 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Movie Title</label>
                    <input type="text" name="title" placeholder="Movie Title" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="genre">Genre</label>
                    <input type="text" name="genre" placeholder="Genre" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="rating">Rating</label>
                    <input type="number" name="rating" placeholder="Rating" step="0.1" min="0" max="10" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="actors">Actors</label>
                    <input type="text" name="actors" placeholder="Actors" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="release_date">Release Date</label>
                    <input type="date" name="release_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="duration">Duration (mins)</label>
                    <input type="number" name="duration" placeholder="Duration (mins)" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4 col-span-1 md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                    <textarea name="description" placeholder="Description" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4 col-span-1 md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Upload Image</label>
                    <input type="file" name="image" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Movie</button>
        </form>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>