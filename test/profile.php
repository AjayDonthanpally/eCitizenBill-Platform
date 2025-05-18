<?php
session_start();
include "db.php";
// Redirect to login page if user is not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: signin.php");
    exit();
}
$username = $_SESSION['username'];
$password = $_SESSION['password'];
// Fetch user data from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $userData = $result->fetch_assoc();
} else {
    echo "Error: User data not found.";
    exit();
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.container {
    width: 100%;
    max-width: 900px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    color: #333;
    position: relative; /* Make it easier to position the back button */
}

header {
    text-align: center;
    margin-bottom: 20px;
}

header h1 {
    font-size: 36px;
    color: #4B0082;
}

.profile-header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.profile-header img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 25px;
    transition: transform 0.3s ease-in-out;
}

.profile-header img:hover {
    transform: scale(1.1);
}

.profile-header div {
    flex: 1;
    color: #333;
}

.profile-header h2 {
    font-size: 28px;
    margin: 0;
    font-weight: bold;
}

.profile-header p {
    font-size: 16px;
    color: #888;
    margin-top: 5px;
}

.profile-header button {
    padding: 12px 20px;
    background-color: #2575fc;
    color: white;
    border: none;
    border-radius: 30px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.profile-header button:hover {
    background-color: #1f5bbf;
    transform: scale(1.05);
}

.profile-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.profile-details div {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    color: #333;
}

.profile-details h3 {
    font-size: 20px;
    color: #4B0082;
    margin-bottom: 15px;
}

.profile-details p {
    font-size: 16px;
    color: #555;
}

.edit-form {
    display: none;
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
}

.edit-form input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    color: #333;
    transition: border 0.3s ease;
}

.edit-form input:focus {
    border-color: #2575fc;
    outline: none;
}

.edit-form button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 30px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

.edit-form button:hover {
    background-color: #45a049;
}

.message {
    margin-top: 20px;
    padding: 10px;
    background-color: #28a745;
    color: white;
    text-align: center;
    font-weight: bold;
    border-radius: 8px;
    display: none;
}

footer {
    margin-top: 50px;
    text-align: center;
    padding: 15px;
    background-color: #333;
    width: 100%;
    color: white;
    border-radius: 0 0 15px 15px;
}

footer p {
    margin: 0;
    font-size: 14px;
}

.bills-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.bills-list li {
    background-color: #f9f9f9;
    margin: 5px 0;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    color: #333;
}

.back-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: #4B0082;
    color: white;
    padding: 10px 20px;
    border-radius: 30px;
    text-decoration: none;
    font-size: 16px;
    transition: background-color 0.3s;
}

.back-btn:hover {
    background-color: #3a0068;
}

    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>Your Profile</h1>
        </header>

        <button onclick="goBack()" class="back-btn">Back</button>

        <div class="profile-header">
            <img src="https://via.placeholder.com/150" alt="User Avatar" id="profileImage">
            <div>
                <h2 id="userName"><?php echo htmlspecialchars($userData['username']); ?></h2>
                <p id="userEmail"><?php echo htmlspecialchars($userData['email']); ?></p>
                <button onclick="toggleEditForm()">Edit Profile</button>
            </div>
        </div>

        <div class="profile-details">
            <div>
                <h3>Personal Information</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($userData['username']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($userData['Phone']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($userData['Village']); ?>, <?php echo htmlspecialchars($userData['mandal']); ?>, <?php echo htmlspecialchars($userData['District']); ?></p>
            </div>

            <div>
                <h3>Account Details</h3>
                <p><strong>Meter No:</strong> <?php echo htmlspecialchars($userData['MTRNO']); ?></p>
                <p><strong>SC No:</strong> <?php echo htmlspecialchars($userData['SCNO']); ?></p>
                <p><strong>USC Code:</strong> <?php echo htmlspecialchars($userData['USC']); ?></p>
            </div>
        </div>

        <div class="profile-details">
            <h3>Bills Selected</h3>
            <ul class="bills-list">
                <?php
                $bills = [
                    'panchayat' => 'Panchayat Bill',
                    'municipal' => 'Municipal Bill',
                    'ghmc' => 'GHMC Bill',
                    'water' => 'Water Bill',
                    'electricity' => 'Electricity Bill',
                    'property_tax' => 'Property Tax',
                    'land_revenue' => 'Land Revenue',
                    'pollution_fee' => 'Pollution Control Fee'
                ];
                foreach ($bills as $key => $label) {
                    if ($userData[$key] == 1) {
                        echo "<li>$label</li>";
                    }
                }
                ?>
            </ul>
        </div>

        <div class="edit-form" id="editForm">
            <h3>Edit Profile</h3>
            <input type="text" id="editName" placeholder="Full Name" value="<?php echo htmlspecialchars($userData['username']); ?>">
            <input type="email" id="editEmail" placeholder="Email" value="<?php echo htmlspecialchars($userData['email']); ?>">
            <input type="text" id="editPhone" placeholder="Phone" value="<?php echo htmlspecialchars($userData['Phone']); ?>">
            <input type="text" id="editLocation" placeholder="Location" value="<?php echo htmlspecialchars($userData['Village']); ?>, <?php echo htmlspecialchars($userData['mandal']); ?>, <?php echo htmlspecialchars($userData['District']); ?>">
            <button onclick="saveProfile()">Save Changes</button>
        </div>

        <div class="message" id="successMessage">Profile updated successfully!</div>
    </div>

    <footer>
        <p>&copy; 2024 Your Company. All Rights Reserved.</p>
    </footer>

    <script>
        function toggleEditForm() {
    const editForm = document.getElementById('editForm');
    editForm.style.display = (editForm.style.display === 'block') ? 'none' : 'block';
}

function saveProfile() {
    const name = document.getElementById('editName').value;
    const email = document.getElementById('editEmail').value;
    const phone = document.getElementById('editPhone').value;
    const location = document.getElementById('editLocation').value;

    // Update the profile details
    document.getElementById('userName').textContent = name;
    document.getElementById('userEmail').textContent = email;

    // Update personal info
    document.querySelectorAll('.profile-details div p')[0].textContent = `Name: ${name}`;
    document.querySelectorAll('.profile-details div p')[1].textContent = `Phone: ${phone}`;
    document.querySelectorAll('.profile-details div p')[2].textContent = `Location: ${location}`;

    // Hide the edit form
    document.getElementById('editForm').style.display = 'none';

    // Display success message
    const successMessage = document.getElementById('successMessage');
    successMessage.style.display = 'block';
    setTimeout(() => {
        successMessage.style.display = 'none';
    }, 3000);
}

function goBack() {
    window.history.back();
}

    </script>

</body>
</html>
