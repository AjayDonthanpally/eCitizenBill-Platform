<?php
session_start();
include 'db.php';

if (isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCitizenBills</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="home-page">
        <div class="top-bar flex-container" style="background-attachment: fixed;">
            <h1>eCitizenBills</h1>
            <p id="currentDateTime"></p>
        </div>
        
        <div class="top-bar flex-container">
            <!-- Menu Button -->
            <button class="open-btn" onclick="toggleMenu()">☰ Menu</button>
            
            <div class="right-buttons flex-container">
                <button id="theme-toggle" class="button">🔆</button>
                <div class="notification">
                    <button class="button" onclick="toggleNotifications()">🔔</button>
                    <span id="notification-badge" class="badge" style="display: none;">!</span> <!-- Notification Badge -->
                </div>
                <button id="logout-button" class="button" onclick="location.href='logout.php'">Logout</button>
                <button class="button" onclick="location.href='profile.php'"><?php echo $_SESSION['username']; ?></button> <!-- Profile button -->
            </div>
        </div>
        
        <!-- Collapsible Menu -->
        <div id="side-menu" class="side-menu">
            <a href="Latest Updates.php"><i class="fas fa-newspaper"></i> Latest Updates</a>
            <a href="PaymentHistory.php"><i class="fas fa-calendar-alt"></i>PaymentHistory</a>
            <a href="payments.php"><i class="fas fa-credit-card"></i> Bills Payments</a>
            <a href="calculator.php"><i class="fas fa-calculator"></i> Calculator</a>
            <a href="ContactUs.php"><i class="fas fa-phone-alt"></i> Contact Us</a>
        </div>
    
        <!-- Notifications Dropdown -->
        <div id="notifications-dropdown" class="notifications-dropdown" style="display: none;">
            <p>No new notifications.</p> <!-- Placeholder for notifications -->
        </div>
    </div>
    
    <div class="footer">
        <div class="flash-news">Welcome to eCitizenBills!! Welcome user approaching the eCitizenBills Platform for Payments. All bills can be paid here!! For any query please contact +91 9100454230!! Thank you for visiting.</div>
    </div>
    
    <script src='script.js'></script> <!-- Include the JS file -->
</body>
</html>
<?php
} else {
    header("Location: home.php");
    exit();
}
?>
