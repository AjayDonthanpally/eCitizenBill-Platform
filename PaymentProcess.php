<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

date_default_timezone_set('Asia/Kolkata'); // Set the correct timezone

$username = $_SESSION['username'];
$billType = $_GET['bill'] ?? null;

if (!$billType) {
    echo "No bill selected.";
    header("Location: payments.php");
    exit();
}

// Define bill names and corresponding status fields
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

$statusFields = [
    'panchayat' => 'pstat',
    'municipal' => 'mstat',
    'ghmc' => 'gstat',
    'water' => 'wstat',
    'electricity' => 'estat',
    'property_tax' => 'prstat',
    'land_revenue' => 'lstat',
    'pollution_fee' => 'postat'
];

// Validate bill type
if (!array_key_exists($billType, $billNames)) {
    echo "Invalid bill selected.";
    header("Location: payments.php");
    exit();
}

// Retrieve the status field for the selected bill type
$statusField = $statusFields[$billType];

// Check if the bill is already paid
$query = $conn->prepare("SELECT $statusField FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$billStatus = $result->fetch_assoc();

if (!$billStatus || $billStatus[$statusField] == 1) {
    echo "This bill has already been paid or an error occurred.";
    header("Location: payments.php");
    exit();
}

// QR Code placeholder
$qrCodeURL = "qrcodenew.png"; // Replace with actual QR code path

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
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
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .qr-code {
            width: 200px;
            height: 200px;
            margin: 20px auto;
        }
        .confirm-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 60%;
        }
        .confirm-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="close-btn" onclick="window.location.href='payments.php'">&times;</button>
        <h2>Scan to Pay - <?php echo $billNames[$billType]; ?></h2>
        <img src="<?php echo $qrCodeURL; ?>" alt="QR Code" class="qr-code">
        <form action="PaymentProcess.php?bill=<?php echo $billType; ?>" method="post">
            <button type="submit" name="confirm" class="confirm-btn">Confirm Payment</button>
        </form>
    </div>
</body>
</html>

<?php
// Process the payment confirmation
if (isset($_POST['confirm'])) {
    $date = date("Y-m-d H:i:s"); // Current date and time

    // Update bill status to paid
    $updateQuery = $conn->prepare("UPDATE users SET $statusField = 1 WHERE username = ?");
    $updateQuery->bind_param("s", $username);
    $updateResult = $updateQuery->execute();

    // Log the payment in the paid_bills table
    $insertQuery = $conn->prepare("INSERT INTO paidbills (username, billtype, paidat) VALUES (?, ?, ?)");
    $insertQuery->bind_param("sss", $username, $billType, $date);
    $insertResult = $insertQuery->execute();

    if ($updateResult && $insertResult) {
        echo "<script>alert('Payment successful!'); window.location.href = 'payments.php';</script>";
    } else {
        echo "<script>alert('Payment failed. Please try again.'); window.location.href = 'PaymentProcess.php?bill=$billType';</script>";
    }
}
?>