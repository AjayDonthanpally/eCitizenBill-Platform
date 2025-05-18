<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Bill Payment Updates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ffefba, #ffffff); /* Gradient background */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        header h2 {
            margin: 10px 0;
            font-size: 1.2em;
            font-weight: 300;
        }
        header button {
            background-color: #ffcc00;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 10px;
        }
        header button:hover {
            background-color: #ffb300;
        }
        main {
            width: 90%;
            max-width: 800px;
            margin: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        section {
            margin-bottom: 20px;
        }
        h3 {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .important-messages ul {
            list-style-type: none;
            padding: 0;
        }
        .important-messages li {
            background: #ffecb3;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .last-payment {
            background: #e1f5fe;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        footer {
            background: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        footer p {
            margin: 5px 0;
        }
        footer a {
            color: #ffccbc;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        #currentTime {
            margin-top: 10px;
            font-size: 0.9em;
            font-style: italic;
        }
    </style>
</head>
<body>
    <header>
        <button onclick="window.location.href='index.php'">Back</button> <!-- Back Button -->
        <h1>Latest Bill Payment Updates</h1>
        <h2>Stay informed about your upcoming payment dates!</h2>
        <div id="currentTime"></div> <!-- Current Time Display -->
    </header>
    <main>
        <section class="upcoming-payments">
            <h3>Upcoming Payments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Bill Type</th>
                        <th>Due Date</th>
                        <th>Amount Due</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="payment-table-body">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
        </section>
        <section class="important-messages">
            <h3>Important Messages</h3>
            <ul id="message-list">
                <!-- Dynamic messages will be inserted here -->
            </ul>
        </section>
        <section class="last-payment-date">
            <h3>Last Payment Date</h3>
            <div class="last-payment" id="last-payment-date">
                <!-- Last payment date will be inserted here -->
            </div>
        </section>
    </main>
    <footer>
        <p>For assistance, please contact our support team at ecitizenbills@gmail.com or call .</p>
        <p><a href="#">View Payment History</a> | <a href="#">Set Up Automatic Payments</a></p>
    </footer>
    <script>
        // JavaScript to dynamically insert content and display the current time
        function updateCurrentTime() {
            const now = new Date();
            document.getElementById('currentTime').innerText = now.toLocaleString();
        }
        updateCurrentTime();
        setInterval(updateCurrentTime, 60000); // Update time every minute

        // Example data insertion for demonstration purposes
        const bills = [
            { type: 'Electricity', dueDate: '12/12/2024', amount: 1200, status: 'Pending' },
            { type: 'Water', dueDate: '15/12/2024', amount: 800, status: 'Pending' },
            { type: 'Property Tax (1BHK)', dueDate: '20/12/2024', amount: 3000, status: 'Pending' },
            { type: 'Property Tax (2BHK)', dueDate: '20/12/2024', amount: 5000, status: 'Pending' },
            { type: 'Garbage', dueDate: '25/12/2024', amount: 600, status: 'Pending' },
            { type: 'Water (per gallon)', dueDate: '30/12/2024', amount: 50, status: 'Pending' },
        ];

        const paymentTableBody = document.getElementById('payment-table-body');
        bills.forEach(bill => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${bill.type}</td>
                <td>${bill.dueDate}</td>
                <td>₹${bill.amount}</td>
                <td>${bill.status}</td>
            `;
            paymentTableBody.appendChild(row);
        });

        document.getElementById('message-list').innerHTML = `
            <li>Remember to pay your electricity bill by 12/12/2024 to avoid late fees.</li>
            <li>Water bill for 15/12/2024 is now available. Check your account for details.</li>
            <li>garbage bill for 15/12/2024 is now available. Check your account for details.</li>
        `;

        document.getElementById('last-payment-date').innerText = "Your last payment was on 10/11/2024.";
    </script>
</body>
</html>
