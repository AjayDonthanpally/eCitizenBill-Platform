<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

$username = $_SESSION['username'];

// Retrieve paid bills for the user
$query = $conn->prepare("SELECT billtype, paidat FROM paidbills WHERE username = ? ORDER BY paidat DESC");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$paidBills = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Paid Bills</title>
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
            width: 80%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }
        h2 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .no-bills-message {
            font-size: 1.2em;
            color: #666;
            margin-top: 20px;
        }
        .home-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .home-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="home-btn">Back</a>
        <h2>Your Last Paid Bills</h2>

        <table>
            <thead>
                <tr>
                    <th>Bill Type</th>
                    <th>Paid On</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($paidBills)): ?>
                    <tr>
                        <td colspan="2" class="no-bills-message">You have no paid bills recorded.</td>
                    </tr>
                <?php else: ?>
                    <?php
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

                    foreach ($paidBills as $bill) {
                        echo "<tr class='paid-bill-item'>";
                        echo "<td>{$billNames[$bill['billtype']]}</td>";
                        echo "<td>" . date("F j, Y, g:i a", strtotime($bill['paidat'])) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
