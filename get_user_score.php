<?php
session_start();
require 'database_connection.php';

header('Content-Type: application/json'); // JSON header

$response = [
    'loggedIn' => isset($_SESSION['username']),
    'username' => null,
    'score' => null,
    'error' => null
];

if ($response['loggedIn']) {
    $username = $_SESSION['username'];
    $response['username'] = $username;

    $stmt = $conn->prepare("SELECT score FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($score);

    if ($stmt->fetch()) {
        $response['score'] = $score;
    } else {
        $response['error'] = 'Score not found';
    }

    $stmt->close();
} else {
    $response['error'] = 'User not logged in';
}

$conn->close();

echo json_encode($response);
?>