<?php
session_start();

// Check if the route name is provided through GET
$routeName = isset($_GET['route']) ? $_GET['route'] : '';
if (empty($routeName)) {
    die("Route not specified.");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "@Aditri_1165";
$dbname = "routes_info";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch route images with average rating, upload time, and uploader info
$routeStmt = $conn->prepare("
    SELECT id, image_path, upload_time, user_id, 
           (SELECT AVG(rating) FROM ratings WHERE image_id = route_images.id) AS avg_rating 
    FROM route_images 
    WHERE route_name = ? AND upload_time >= NOW() - INTERVAL 12 HOUR
");
$routeStmt->bind_param("s", $routeName);
$routeStmt->execute();
$routeResult = $routeStmt->get_result();

// Fetch weather images with average rating, upload time, and uploader info
$weatherStmt = $conn->prepare("
    SELECT id, image_path, upload_time, user_id, 
           (SELECT AVG(rating) FROM ratings WHERE image_id = weather_images.id) AS avg_rating 
    FROM weather_images 
    WHERE route_name = ? AND upload_time >= NOW() - INTERVAL 12 HOUR
");
$weatherStmt->bind_param("s", $routeName);
$weatherStmt->execute();
$weatherResult = $weatherStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Images for Route</title>
    <style>
        .image-container img {
            width: 300px;
            cursor: pointer;
            margin: 10px;
        }
        .image-container p {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Images for Route: <?php echo htmlspecialchars($routeName); ?></h2>

    <!-- Display Route Images with Ratings and Upload Time -->
    <h3>Route Images</h3>
    <div class="image-container">
        <?php while ($routeRow = $routeResult->fetch_assoc()): ?>
            <div>
                <img src="<?php echo $routeRow['image_path']; ?>" alt="Route Image" onclick="openFullscreen(this)">
                <p>Average Rating: <?php echo round($routeRow['avg_rating'], 1); ?>/5</p>
                <p>Uploaded on: <?php echo date("F j, Y, g:i a", strtotime($routeRow['upload_time'])); ?></p>

                <!-- Rating Form for Route Image, excluding the uploader -->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $routeRow['user_id']): ?>
                    <form onsubmit="submitRating(event, <?php echo $routeRow['id']; ?>, 'route')" method="post">
                        <label for="rating">Rate:</label>
                        <select name="rating" id="rating-<?php echo $routeRow['id']; ?>">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <button type="submit">Submit Rating</button>
                    </form>
                <?php else: ?>
                    <p>You cannot rate your own image.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Display Weather Images with Ratings and Upload Time -->
    <h3>Weather Images</h3>
    <div class="image-container">
        <?php while ($weatherRow = $weatherResult->fetch_assoc()): ?>
            <div>
                <img src="<?php echo $weatherRow['image_path']; ?>" alt="Weather Image" onclick="openFullscreen(this)">
                <p>Average Rating: <?php echo round($weatherRow['avg_rating'], 1); ?>/5</p>
                <p>Uploaded on: <?php echo date("F j, Y, g:i a", strtotime($weatherRow['upload_time'])); ?></p>

                <!-- Rating Form for Weather Image, excluding the uploader -->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $weatherRow['user_id']): ?>
                    <form onsubmit="submitRating(event, <?php echo $weatherRow['id']; ?>, 'weather')" method="post">
                        <label for="rating">Rate:</label>
                        <select name="rating" id="rating-<?php echo $weatherRow['id']; ?>">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <button type="submit">Submit Rating</button>
                    </form>
                <?php else: ?>
                    <p>You cannot rate your own image.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <?php
    // Close statements and connection
    $routeStmt->close();
    $weatherStmt->close();
    $conn->close();
    ?>

    <!-- JavaScript for fullscreen display and AJAX rating submission -->
    <script>
        function openFullscreen(img) {
            const fullscreenImg = document.createElement("img");
            fullscreenImg.src = img.src;
            fullscreenImg.style.width = "100vw";
            fullscreenImg.style.height = "100vh";
            fullscreenImg.style.objectFit = "contain";
            fullscreenImg.style.position = "fixed";
            fullscreenImg.style.top = "0";
            fullscreenImg.style.left = "0";
            fullscreenImg.style.backgroundColor = "rgba(0, 0, 0, 0.9)";
            fullscreenImg.style.zIndex = "1000";
            fullscreenImg.style.cursor = "pointer";

            fullscreenImg.onclick = function() {
                document.body.removeChild(fullscreenImg);
            };

            document.body.appendChild(fullscreenImg);
        }

        function submitRating(event, imageId, imageType) {
            event.preventDefault();

            const rating = document.getElementById(`rating-${imageId}`).value;

            fetch('rate_image.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `image_id=${imageId}&image_type=${imageType}&rating=${rating}`
            })
            .then(response => response.text())
            .then(data => {
                alert('Rating posted');
                console.log(data);
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
