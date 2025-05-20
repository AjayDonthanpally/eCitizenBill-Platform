<?php
session_start();
include "db.php";

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: signin.php");
    exit();
}

// Variables for user information
$username = $_SESSION['username'];
$password = $_SESSION['password'];
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($message)) {
        // Prepare and execute SQL statement to insert the complaint
        $stmt = $conn->prepare("INSERT INTO complaint (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Your message has been submitted successfully!</p>";
            header("Location: index.php");
            exit();
        } else {
            echo "<p style='color: red;'>Error: Could not submit your message. Please try again later.</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Please enter a message.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #011124;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            padding: 30px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff5f5f;
            border: none;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"], input[type="email"], textarea {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            resize: vertical;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="close" onclick="window.location.href='index.php'">X</button>
        <h2>Contact Us</h2>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email address" required>
            <textarea placeholder="Enter your message here..." rows="5" name="message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>

