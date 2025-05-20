<?php
session_start();
include "db.php";
$alert_message = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if(isset($_POST['remember'])) {
        // Set cookies to remember the username and password for 30 days
        setcookie("username", $uname, time() + (86400 * 30), "/");
        setcookie("password", $pass, time() + (86400 * 30), "/");
    } else {
        // Clear cookies if "Remember Me" is not checked
        setcookie("username", "", time() - 3600, "/");
        setcookie("password", "", time() - 3600, "/");
    }

    $sql = "SELECT * FROM users WHERE (username = '$uname' OR email = '$uname') AND password = '$pass'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if(($row['username'] === $uname || $row['email'] === $uname) && $row['password'] === $pass) {
            echo "Logged In!";
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            $alert_message = "Incorrect Username or Password";
        }
    } else {
        $alert_message = "Incorrect Username or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            font-family: 'Roboto', sans-serif;
        }
        .container {
            width: 350px;
            padding: 30px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            position: relative;
            max-width: 100%;
            box-sizing: border-box;
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
            font-weight: 500;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .password-container {
            position: relative;
            width: 100%;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #f85032, #e73827);
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
            transition: background 0.3s, transform 0.3s;
            box-sizing: border-box;
        }
        button[type="submit"]:hover {
            background: linear-gradient(135deg, #e73827, #f85032);
            transform: translateY(-3px);
        }
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }
        .remember-forgot input {
            margin-right: 5px;
        }
        .signup-link, .forgot-password {
            margin-top: 20px;
        }
        .signup-link a, .forgot-password a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .signup-link a:hover, .forgot-password a:hover {
            color: #0056b3;
        }
        .alert {
            color: #d8000c;
            background-color: #ffdddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="close" onclick="window.location.href='home.php'">X</button>
        <h2>Hey User👋 Sign In</h2>
        <form action="" method="post">
            <?php if (!empty($alert_message)) : ?>
                <div class="alert"><?php echo $alert_message; ?></div>
            <?php endif; ?>
            <input type="text" name="username" placeholder="Username or Email" value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>" required>
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox" name="remember" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>> Remember Me</label>
                <div class="forgot-password"><a href="forgotpwd.php">Forgot Password?</a></div>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="signup-link">
            Don't have an account? <a href="signup.php">Sign Up here</a>
        </div>
    </div>
    <script>
        function togglePassword() {
            var password = document.getElementById("password");
            var type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
        }
    </script>
</body>
</html>
