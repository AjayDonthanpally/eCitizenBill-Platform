<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0f0226;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .message {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        .cartoon {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }
        .home-btn {
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .home-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <img src="carton1.png" alt="Cartoon" class="cartoon">
    <div class="message">Thank you <?php echo htmlspecialchars($username); ?> for visiting</div>
    <script>
        // Redirect after 2 seconds
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 2000);
    </script>
    <a href="index.php" class="home-btn">Home</a>
</body>
</html>
