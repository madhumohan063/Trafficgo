<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php'; // Use the shared database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "@Aditri_1165";
$dbname = "routes_info";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$outputMessages = ""; // Initialize variable to store messages

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $routeName = $_POST['route'];
    $outputMessages .= "Route name: $routeName<br>"; // Append route name to messages

    // Directories for images
    $routeImageDir = "route_images/";
    $weatherImageDir = "weather_images/";

    if (!file_exists($routeImageDir)) mkdir($routeImageDir, 0777, true);
    if (!file_exists($weatherImageDir)) mkdir($weatherImageDir, 0777, true);

    // Process route image upload
    if (!empty($_FILES['routeImage']['name'])) {
        $routeImageName = basename($_FILES["routeImage"]["name"]);
        $routeImagePath = $routeImageDir . uniqid() . "_" . $routeImageName;

        if (move_uploaded_file($_FILES["routeImage"]["tmp_name"], $routeImagePath)) {
            $stmt = $conn->prepare("INSERT INTO route_images (route_name, image_path, user_id, upload_time) VALUES (?, ?, ?, NOW())");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $userId = $_SESSION['user_id'];
            $stmt->bind_param("ssi", $routeName, $routeImagePath, $userId);
            if ($stmt->execute()) {
                $outputMessages .= "Route image uploaded successfully!<br>";
            } else {
                $outputMessages .= "Error executing statement for route image: " . $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            $outputMessages .= "Error moving route image.<br>";
        }
    } else {
        $outputMessages .= "No route image uploaded.<br>";
    }

    // Process weather image upload
    if (!empty($_FILES['weatherImage']['name'])) {
        $weatherImageName = basename($_FILES["weatherImage"]["name"]);
        $weatherImagePath = $weatherImageDir . uniqid() . "_" . $weatherImageName;

        if (move_uploaded_file($_FILES["weatherImage"]["tmp_name"], $weatherImagePath)) {
            $stmt = $conn->prepare("INSERT INTO weather_images (route_name, image_path, user_id, upload_time) VALUES (?, ?, ?, NOW())");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ssi", $routeName, $weatherImagePath, $userId);
            if ($stmt->execute()) {
                $outputMessages .= "Weather image uploaded successfully!<br>";
            } else {
                $outputMessages .= "Error executing statement for weather image: " . $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            $outputMessages .= "Error moving weather image.<br>";
        }
    } else {
        $outputMessages .= "No weather image uploaded.<br>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Images</title>
    <link rel="stylesheet" href="style/upload.css">
</head>
<body>
    <div id="cont">
        <?php echo $outputMessages; // Display messages inside the container ?>
        <div id="divforpad">
        <h1>Upload Images for Route</h1>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="route">Route Name:</label>
            <input type="text" name="route" id="route" required><br><br>
            
            <label for="routeImage">Upload Route Image:</label>
            <input type="file" name="routeImage" id="routeImage"><br><br>
            
            <label for="weatherImage">Upload Weather Image:</label>
            <input type="file" name="weatherImage" id="weatherImage"><br><br>
            
            <input type="submit" value="Upload Images">
        </form>
        </div>

        <!-- Show button and search box for viewing uploaded images -->
        <br><br>
        <form action="view_images.php" method="GET">
            <label for="searchRoute">Enter Route Name to View Images:</label>
            <input type="text" name="route" id="searchRoute" required>
            <input type="submit" value="Show Uploaded Images">
        </form>
    </div>
</body>
</html>
