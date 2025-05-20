<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to eCitizenBills</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and overall layout */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #6e7e8f, #4b5d67);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
            text-align: center;
            padding: 0 20px;
            color: #f8f8f8;
        }

        /* Main Title */
        h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            letter-spacing: 1px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* Subtitle */
        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* Description */
        p {
            font-size: 1.1rem;
            margin-bottom: 40px;
            line-height: 1.6;
            max-width: 800px;
            text-align: center; /* Aligning the text to the center */
            padding: 0 15px;
            font-style: italic; /* Italicize the content */
        }

        /* The "Get Started" button style (centered horizontally and at the bottom) */
        .get-started-btn {
            background-color: #ff9800;
            border: 2px solid #e65100;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 30px;
            transition: all 0.3s ease;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        /* "Get Started" button hover effect */
        .get-started-btn:hover {
            background-color: #e65100;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateX(-50%) scale(1.1);
        }

        /* Navigation buttons (hidden initially) */
        .nav-buttons {
            display: none;
            flex-direction: column;
            position: absolute;
            bottom: 70px;
            left: 50%;
            transform: translateX(-50%);
            gap: 20px;
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: 2;
        }

        /* Style for the nav buttons */
        .nav-btn {
            background: linear-gradient(135deg, #ff6f61, #de1a33);
            color: white;
            padding: 15px 30px;
            font-size: 1.2rem;
            border: none;
            cursor: pointer;
            border-radius: 30px;
            width: 200px;
            transition: background 0.3s, transform 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Hover effect for nav buttons */
        .nav-btn:hover {
            background: linear-gradient(135deg, #de1a33, #ff6f61);
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        /* Button swipe-out animation */
        @keyframes swipeOut {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100vw); }
        }

        /* Blur effect */
        .blurred-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            filter: blur(10px);
            z-index: 1;
        }

        /* Add glow effect */
        .glow {
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5), 0 0 20px rgba(255, 215, 0, 0.5), 0 0 30px rgba(255, 215, 0, 0.5);
        }

        /* Add stars effect */
        .stars::after {
            content: " ✨";
        }
    </style>
</head>
<body>

    <!-- The blurred background that will be shown when the "Get Started" button is clicked -->
    <div class="blurred-background" id="blurred-background" style="display: none;"></div>

    <div class="content" id="content">
        <h1>eCitizenBills</h1>
        <h2>Welcome Back</h2>
        <p><i>Welcome to Our Web App - Transforming the Way You Manage Your Payments!<br><br>
            We are a pioneering platform dedicated to simplifying and streamlining your bill payment experience. Our goal is to provide an all-encompassing solution that caters to users across various regions, including rural, urban, rural-urban, municipal, and Greater Hyderabad Municipal Corporation (GHMC) areas.</i></p>
        <!-- Get Started Button -->
        <div class="get-started-btn" id="get-started-btn">Get Started →</div>

        <!-- Navigation buttons -->
        <div class="nav-buttons" id="nav-buttons">
            <button class="nav-btn" id="sign-in-btn">Sign In</button>
            <button class="nav-btn" id="sign-up-btn">Sign Up</button>
        </div>
    </div>

    <script>
        // Get elements
        const getStartedBtn = document.getElementById('get-started-btn');
        const navButtons = document.getElementById('nav-buttons');
        const content = document.getElementById('content');
        const blurredBackground = document.getElementById('blurred-background');

        // Handle button click (Get Started)
        getStartedBtn.addEventListener('click', function() {
            // Animate the "Get Started" button swipe out
            getStartedBtn.style.animation = 'swipeOut 0.5s forwards';

            // Add glow and stars effects
            getStartedBtn.classList.add('glow');
            getStartedBtn.classList.add('stars');

            // After animation ends, hide "Get Started" and show nav buttons
            setTimeout(function() {
                getStartedBtn.style.display = 'none'; // Hide "Get Started"
                navButtons.style.display = 'flex';   // Show Sign In/Sign Up buttons
                navButtons.style.opacity = 1;        // Fade-in effect for nav buttons
                blurredBackground.style.display = 'block'; // Show the blurred background
                getStartedBtn.classList.remove('glow');
                getStartedBtn.classList.remove('stars');
            }, 500); // Timeout matches the animation duration
        });

        // Redirect to sign-in page
        document.getElementById('sign-in-btn').addEventListener('click', function() {
            window.location.href = 'signin.php';  // Modify with your actual URL
        });

        // Redirect to sign-up page
        document.getElementById('sign-up-btn').addEventListener('click', function() {
            window.location.href = 'signup.php';  // Modify with your actual URL
        });
    </script>

</body>
</html>
