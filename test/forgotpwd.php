<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .button, .back-button {
            width: 100%;
            padding: 12px;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px 0;
        }
        .button {
            background-color: #4CAF50;
        }
        .button:hover {
            background-color: #45a049;
        }
        .back-button {
            background-color: #007bff;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            color: #28a745;
            display: none;
            margin-top: 20px;
        }
        .error-message {
            color: #dc3545;
            display: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Reset Your Password</h2>
        <form id="reset-form">
            <label for="email">Enter your email address</label>
            <input type="email" id="email" class="input-field" placeholder="Email" required>
            <label for="new-password">Enter New Password</label>
            <input type="password" id="new-password" class="input-field" placeholder="New Password" required>
            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" class="input-field" placeholder="Confirm Password" required>
            <button type="submit" class="button" id="submit-button">Update Password</button>
            <button type="button" class="back-button" onclick="window.location.href='signin.php'">Back</button>
            <div id="message" class="message"></div>
            <div id="error-message" class="error-message"></div>
        </form>
    </div>

    <script>
        const form = document.getElementById('reset-form');
        const emailField = document.getElementById('email');
        const newPassword = document.getElementById('new-password');
        const confirmPassword = document.getElementById('confirm-password');
        const messageDiv = document.getElementById('message');
        const errorMessageDiv = document.getElementById('error-message');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (newPassword.value !== confirmPassword.value) {
                errorMessageDiv.innerText = 'Passwords do not match.';
                errorMessageDiv.style.display = 'block';
                messageDiv.style.display = 'none';
            } else {
                fetch('reset-password.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `email=${encodeURIComponent(emailField.value)}&new-password=${encodeURIComponent(newPassword.value)}&confirm-password=${encodeURIComponent(confirmPassword.value)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.innerText = 'Password updated successfully.';
                        messageDiv.style.display = 'block';
                        errorMessageDiv.style.display = 'none';
                        setTimeout(() => {
                            window.location.href = 'signin.php';  // Redirect to the sign-in form after a delay
                        }, 2000);  // 2 seconds delay for user to read the message
                    } else {
                        errorMessageDiv.innerText = data.error;
                        errorMessageDiv.style.display = 'block';
                        messageDiv.style.display = 'none';
                    }
                })
                .catch(error => {
                    errorMessageDiv.innerText = 'An error occurred. Please try again.';
                    errorMessageDiv.style.display = 'block';
                    messageDiv.style.display = 'none';
                });
            }
        });
    </script>

</body>
</html>
