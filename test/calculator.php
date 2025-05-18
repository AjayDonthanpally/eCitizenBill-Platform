<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #00ffff,#ff02ff);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white */
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        label, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            text-align: left;
        }

        input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .result1, .result2 {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            color: #333;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Current Bill Calculator</h1>
        <form id="converter-form">
            <label for="units">Enter Number of Units:</label>
            <input type="number" id="units" name="units" required><br>
            <button type="button" class="button" onclick="calculateCurrentBill()">Calculate Bill</button>
        </form>
        <div id="result1" class="result1"></div>
    </div>

    <div class="container">
        <h1>Water Bill Calculator</h1>
        <form id="calculator-form">
            <label for="gallons">Enter Number of Gallons:</label>
            <input type="number" id="gallons" name="gallons" required><br>
            <button type="button" class="button" onclick="calculateWaterBill()">Calculate Bill</button>
        </form>
        <div id="result2" class="result2"></div>
    </div>
    <a href="index.php" class="back-link">⬅️ Back to Home-page</a>

    <script>
        let currentBillAmount = 0; // For current bill
let waterBillAmount = 0; // For water bill

// Function to calculate the current bill based on units consumed
function calculateCurrentBill() {
    const units = parseFloat(document.getElementById('units').value);

    // Calculate bill based on Telangana tariff rates
    if (units <= 50) {
        currentBillAmount = units * 3; // Rate for first 50 units
    } else if (units <= 100) {
        currentBillAmount = (50 * 3) + ((units - 50) * 5); // Rate for next 50 units
    } else if (units <= 200) {
        currentBillAmount = (50 * 3) + (50 * 5) + ((units - 100) * 7); // Rate for next 100 units
    } else {
        currentBillAmount = (50 * 3) + (50 * 5) + (100 * 7) + ((units - 200) * 10); // Rate for above 200 units
    }

    // Display the result in the designated div
    document.getElementById('result1').innerText = `Your current bill amount is: ₹${currentBillAmount.toFixed(2)}`;

    // Update total bill display
    updateTotalBill();
}

// Function to calculate the water bill based on gallons consumed
function calculateWaterBill() {
    const gallons = parseFloat(document.getElementById('gallons').value);

    // Calculate water bill based on Telangana tariff rates
    if (gallons <= 1000) {
        waterBillAmount = gallons * 1; // Rate for first 1000 gallons
    } else if (gallons <= 3000) {
        waterBillAmount = (1000 * 1) + ((gallons - 1000) * 1.5); // Rate for next 2000 gallons
    } else {
        waterBillAmount = (1000 * 1) + (2000 * 1.5) + ((gallons - 3000) * 2); // Rate for above 3000 gallons
    }

    // Display the result in the designated div
    document.getElementById('result2').innerText = `Your water bill amount is: ₹${waterBillAmount.toFixed(2)}`;

    // Update total bill display
    updateTotalBill();
}

// Function to update total bill amount displayed on the page
function updateTotalBill() {
    const totalBill = currentBillAmount + waterBillAmount;
    document.getElementById('totalBill').innerText = `Total Bill: ₹${totalBill.toFixed(2)}`;
}

    </script>
</body>
</html>
