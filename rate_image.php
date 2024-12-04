<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to rate an image.";
    exit;
}

// Check if image ID, image type, and rating are provided through POST
if (!isset($_POST['image_id']) || !isset($_POST['image_type']) || !isset($_POST['rating'])) {
    echo "Required data missing.";
    exit;
}

$imageId = $_POST['image_id'];
$imageType = $_POST['image_type'];
$rating = $_POST['rating'];
$userId = $_SESSION['user_id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "@Aditri_1165";
$dbname = "routes_info";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
    exit;
}

try {
    // Insert the rating into the ratings table
    $stmt = $conn->prepare("INSERT INTO ratings (image_id, image_type, user_id, rating) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Statement preparation failed: " . $conn->error);
    }
    $stmt->bind_param("isis", $imageId, $imageType, $userId, $rating);
    if (!$stmt->execute()) {
        throw new Exception("Error submitting rating: " . $stmt->error);
    }
    $stmt->close();

    // Fetch the uploader's user_id from the appropriate images table
    if ($imageType == 'route') {
        $uploaderStmt = $conn->prepare("SELECT user_id FROM route_images WHERE id = ?");
    } elseif ($imageType == 'weather') {
        $uploaderStmt = $conn->prepare("SELECT user_id FROM weather_images WHERE id = ?");
    } else {
        throw new Exception("Invalid image type.");
    }
    $uploaderStmt->bind_param("i", $imageId);
    $uploaderStmt->execute();
    $uploaderResult = $uploaderStmt->get_result();
    
    if ($uploaderRow = $uploaderResult->fetch_assoc()) {
        $uploaderId = $uploaderRow['user_id'];
        
        // Update the score of the uploader in the users table
        $scoreStmt = $conn->prepare("UPDATE users SET score = score + 1 WHERE id = ?");
        $scoreStmt->bind_param("i", $uploaderId);
        $scoreStmt->execute();
        $scoreStmt->close();
    }
    
    $uploaderStmt->close();

    echo "Rating submitted successfully";
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

$conn->close();
?>
