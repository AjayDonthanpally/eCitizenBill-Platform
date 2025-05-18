<?php
session_start();
include "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $conpassword = trim($_POST['confirm-password']);
    $phone = trim($_POST['Phone']);
    $pin = trim($_POST['Pincode']);
    $vill = trim($_POST['Village']);
    $mandal = trim($_POST['mandal']);
    $dist = trim($_POST['District']);
    $mtrno = trim($_POST['MTRNO']);
    $scno = trim($_POST['SCNO']);
    $usc = trim($_POST['USC']);
    $panbill = isset($_POST['panchayat']) ? 1 : 0;
    $mbill = isset($_POST['municipal']) ? 1 : 0;
    $ghmc = isset($_POST['ghmc']) ? 1 : 0;
    $wbill = isset($_POST['water']) ? 1 : 0;
    $ebill = isset($_POST['electricity']) ? 1 : 0;
    $pbill = isset($_POST['property_tax']) ? 1 : 0;
    $landbill = isset($_POST['land_revenue']) ? 1 : 0;
    $pollutionbill = isset($_POST['pollution_fee']) ? 1 : 0;
    if($password !== $conpassword) {
        echo "Password not matched";
        header("Location: signup.php");
        exit();
    }
    $stmt = $conn -> prepare("INSERT INTO users (username, email, password, Phone, Pincode, Village, mandal, District, MTRNO, SCNO, USC, panchayat, municipal, ghmc, water, electricity, property_tax, land_revenue, pollution_fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssiiiiiiii", $username, $email, $password, $phone, $pin, $vill, $mandal, $dist, $mtrno, $scno, $usc, $panbill, $mbill, $ghmc,$wbill, $ebill, $pbill, $landbill, $pollutionbill);
    if ($stmt->execute()) {
        echo "Registration successful!";
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['email'] = $email;
        $_SESSION['Phone'] = $phone;
        $_SESSION['Pincode'] = $pin;
        $_SESSION['Village'] = $vill;
        $_SESSION['mandal'] = $mandal;
        $_SESSION['District'] = $dist;
        $_SESSION['MTRNO'] = $mtrno;
        $_SESSION['SCNO'] = $scno;
        $_SESSION['USC'] = $usc;
        $_SESSION['panchayat'] = $panbill;
        $_SESSION['municipal'] = $mbill;
        $_SESSION['ghmc'] = $ghmc;
        $_SESSION['water'] = $wbill;
        $_SESSION['electricity'] = $ebill;
        $_SESSION['property_tax'] = $pbill;
        $_SESSION['land_revenue'] = $landbill;
        $_SESSION['pollution_fee'] = $pollutionbill;
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt -> error;
        header("Location:home.php");
        exit();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .scontainer {
            position: relative;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 50%;
        }
        .close-btn {
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
        .form-row {
            display: flex;
            justify-content: space-between;
        }
        .form-column {
            width: 48%;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .submit-btn {
            display: block;
            width: 55%;

            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
        }
        .checkbox-group label {
            width: 50%;
            margin-bottom: 5px;
        }
        .full-width {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="scontainer">
        <button class="close-btn" onclick="window.location.href='home.php'">&times;</button>
        <h1 style="text-align: center;">Signup</h1>
        <form action="" method="post">
            <div class="form-row">
                <!-- First Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="Username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="Phone">Phone No:</label>
                        <input type="text" id="Phone" name="Phone" required>
                    </div>
                    <div class="form-group">
                        <label for="Pincode">Pincode:</label>
                        <input type="text" id="Pincode" name="Pincode" required>
                    </div>
                    <div class="form-group">
                        <label for="Village">Village:</label>
                        <input type="text" id="Village" name="Village" required>
                    </div>
                    <div class="form-group">
                        <label for="mandal">Mandal:</label>
                        <input type="text" id="mandal" name="mandal" required>
                    </div>
                </div>
                <!-- Second Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="District">District:</label>
                        <input type="text" id="District" name="District" required>
                    </div>    
                    <div class="form-group">
                        <label for="MTR.NO">Meter.No:</label>
                        <input type="text" id="MTR.NO" name="MTRNO" required>
                    </div>
                    <div class="form-group">
                        <label for="SC.NO">SC.NO:</label>
                        <input type="text" id="SC.NO" name="SCNO" required>
                    </div>
                    <div class="form-group">
                        <label for="USC">USC CODE:</label>
                        <input type="text" id="USC" name="USC" required>
                    </div>
                    <!-- Password Fields -->
                    <div class='form-group full-width'>
                        <label for='password'>Password:</label>
                        <input type='password' id='password' name='password' required />
                    </div>
                    <!-- Confirm Password Field -->
                    <div class='form-group full-width'>
                        <label for='confirm-password'>Confirm Password:</label>
                        <input type='password' id='confirm-password' name='confirm-password' required /><br />
                    </div>
                </div>
            </div>
            <!-- Government Bills Section -->
            <h2>Select Your Government Bills</h2>
            <div class="checkbox-group">
                <label><input type="checkbox" value="1" name="panchayat"> Panchayat Bill</label>
                <label><input type="checkbox" value="1" name="municipal"> Municipal Bill</label>
                <label><input type="checkbox" value="1" name="ghmc"> GHMC Bill</label>
                <label><input type="checkbox" value="1" name="water"> Water Bill</label>
                <label><input type="checkbox" value="1" name="electricity"> Electricity Bill</label>
                <label><input type="checkbox" value="1" name="property_tax"> Property Tax</label>
                <label><input type="checkbox" value="1" name="land_revenue"> Land Revenue</label>
                <label><input type="checkbox" value="1" name="pollution_fee"> Pollution Control Fee</label>
            </div>
            <!-- Submit Button -->
            <button type='submit' class='submit-btn'>Submit</button>
        </form>
        <!-- Sign In Link -->
        <p>Already have an account? <a href="signin.php">signin here</a></p>
    </div>
</body>
</html>
