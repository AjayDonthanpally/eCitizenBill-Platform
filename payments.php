<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch bills and bill statuses
$query = $conn->prepare("SELECT panchayat, municipal, ghmc, water, electricity, property_tax, land_revenue, pollution_fee FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$bills = $result->fetch_assoc();

$query2 = $conn->prepare("SELECT pstat, mstat, gstat, wstat, estat, prstat, lstat, postat FROM users WHERE username = ?");
$query2->bind_param("s", $username);
$query2->execute();
$result2 = $query2->get_result();
$billstatus = $result2->fetch_assoc();

if (!$bills || !$billstatus) {
    echo "Error retrieving bills.";
    header("Location: index.php");
    exit();
}

$billNames = [
    'panchayat' => 'Panchayat Bill',
    'municipal' => 'Municipal Bill',
    'ghmc' => 'GHMC Bill',
    'water' => 'Water Bill',
    'electricity' => 'Electricity Bill',
    'property_tax' => 'Property Tax',
    'land_revenue' => 'Land Revenue',
    'pollution_fee' => 'Pollution Control Fee'
];

$statusKeys = [
    'panchayat' => 'pstat',
    'municipal' => 'mstat',
    'ghmc' => 'gstat',
    'water' => 'wstat',
    'electricity' => 'estat',
    'property_tax' => 'prstat',
    'land_revenue' => 'lstat',
    'pollution_fee' => 'postat'
];

$allPaid = true;

foreach ($bills as $key => $value) {
    // Check if the bill should be shown (value == 1) and its status is unpaid (billstatus == 0)
    if ($value == 1 && isset($billstatus[$statusKeys[$key]]) && $billstatus[$statusKeys[$key]] == 0) {
        $allPaid = false;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Your Bills</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0f0226;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 50%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
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
        .bill-list {
            margin-top: 20px;
        }
        .bill-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .bill-item span {
            flex: 1;
            text-align: left;
            font-weight: bold;
        }
        .pay-btn {
            width: 55%;
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .pay-btn:hover {
            background: linear-gradient(135deg, #ff5722, #ff9800);
        }
        .all-paid-message {
            color: #28a745;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }
        .home-btn {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            display: inline-block;
            transition: background 0.3s;
        }
        .home-btn:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="close-btn" onclick="window.location.href='index.php'">&times;</button>
        <h2>Your Bills</h2>
        <?php if ($allPaid): ?>
            <p class="all-paid-message">All the bills have been paid!</p>
        <?php else: ?>
        <div class="bill-list">
            <?php
            foreach ($bills as $key => $value) {
                if ($value == 1 && isset($billstatus[$statusKeys[$key]]) && $billstatus[$statusKeys[$key]] == 0) {
                    echo "<div class='bill-item'>";
                    echo "<span>{$billNames[$key]}</span>";
                    echo "<a href='PaymentProcess.php?bill={$key}' class='pay-btn'>Pay</a>";
                    echo "</div>";
                }
            }
            ?>
        </div>
        <?php endif; ?>
        <button class="home-btn" onclick="window.location.href='index.php'">Back</button>
    </div>
</body>
</html>
