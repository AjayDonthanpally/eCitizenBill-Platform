<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - eCitizenBills</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="welcome-container">
        <h1 id="title"></h1>
        <h3 class="suffix">Developed by SPY</h3>
    </div>
    <script>
        // Welcome Page Animation Script
document.addEventListener('DOMContentLoaded', function() {
    const titleElement = document.getElementById('title');
    const titleText = "eCitizenBills-Platform";
    let index = 0;

    function typeCharacter() {
        if (index < titleText.length) {
            titleElement.textContent += titleText.charAt(index);
            index++;
            setTimeout(typeCharacter, 70); // Adjust the speed by changing the timeout value
        } else {
            // Redirect to index.html after the message is fully loaded
            setTimeout(() => {
                window.location.href = 'home.php';
            }, 1000); // Adjust the delay before redirection if needed
        }
    }

    typeCharacter();
});
    </script> <!-- Include the JS file -->
</body>
</html>
