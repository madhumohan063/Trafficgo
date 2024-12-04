<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Database connection
    $conn = new mysqli("localhost", "root", "@Aditri_1165", "routes_info");

    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $success = "Registration successful! You can now <a href='login.php'>login</a>.";
    } else {
        $error = "Error: register already exists.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { width: 300px; margin: auto; }
        .success { color: green; }
        .error { color: red; }
    </style>
        <link rel = "stylesheet" href = "style/register.css">

</head>
<body>
<div class="container">
    <h2>Register</h2>
    
    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php elseif (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Register</button>
    </form>
    
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
