<?php
header('Content-Type: application/json');
include "db.php"; // include your database connection file

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $newPassword = trim($_POST['new-password']);
    $confirmPassword = trim($_POST['confirm-password']);

    if ($newPassword !== $confirmPassword) {
        $response['success'] = false;
        $response['error'] = 'Passwords do not match.';
        echo json_encode($response);
        exit();
    }

    // Update the password in the database without hashing
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $email);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = 'Database update failed.';
    }

    $stmt->close();
    $conn->close();
} else {
    $response['success'] = false;
    $response['error'] = 'Invalid request method.';
}

echo json_encode($response);
?>
