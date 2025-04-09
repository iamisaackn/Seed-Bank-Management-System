<?php
// Establish the database connection
$conn = new mysqli("localhost", "AdminUser", "adminPassword", "seedbankmanagementsystem", 3307);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user actions dynamically based on HTTP POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'insert') {
        $stmt = $conn->prepare("INSERT INTO Transactions (purpose, quantity, transactionType, transactionDate, seedID, institutionID, userID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissiii", $_POST['purpose'], $_POST['quantity'], $_POST['transactionType'], $_POST['transactionDate'], $_POST['seedID'], $_POST['institutionID'], $_POST['userID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Transactions WHERE transactionID = ?");
        $stmt->bind_param("i", $_POST['transactionID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'update') {
        $stmt = $conn->prepare("UPDATE Transactions SET purpose = ?, quantity = ?, transactionType = ?, transactionDate = ?, seedID = ?, institutionID = ?, userID = ? WHERE transactionID = ?");
        $stmt->bind_param("sissiiii", $_POST['purpose'], $_POST['quantity'], $_POST['transactionType'], $_POST['transactionDate'], $_POST['seedID'], $_POST['institutionID'], $_POST['userID'], $_POST['transactionID']);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all transactions for display purposes
$transactions = [];
$result = $conn->query("SELECT * FROM Transactions");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Transactions Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f5;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #5d6d7e;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #3c4d5e;
            padding: 1rem;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 1rem;
        }
        nav ul li a.active {
            color: #ffffff; 
            background-color: #5d6d7e;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 0.5rem;
        }
        table th {
            background-color: #5d6d7e;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel - Transactions Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="adminSeed.php">Seed</a></li>
            <li><a href="adminStorage.php">Storage</a></li>
            <li><a href="adminSeedTesting.php">Seed Testing</a></li>
            <li><a class="active" href="adminTransaction.php">Transactions</a></li>
            <li><a href="adminInstitutions.php">Institution</a></li>
            <li><a href="adminUser.php">Users</a></li>
            <li><a href="adminProfile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Transactions</h2>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Purpose</th>
                    <th>Quantity</th>
                    <th>Transaction Type</th>
                    <th>Transaction Date</th>
                    <th>Seed ID</th>
                    <th>Institution ID</th>
                    <th>User ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($transaction['transactionID']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['purpose']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['transactionType']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['transactionDate']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['seedID']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['institutionID']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['userID']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Insert Transaction</h2>
        <form method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="text" name="purpose" placeholder="Purpose" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="text" name="transactionType" placeholder="Transaction Type" required>
            <input type="date" name="transactionDate" placeholder="Transaction Date" required>
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <input type="number" name="institutionID" placeholder="Institution ID" required>
            <input type="number" name="userID" placeholder="User ID" required>
            <button type="submit">Insert</button>
        </form>

        <h2>Delete Transaction</h2>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="number" name="transactionID" placeholder="Transaction ID" required>
            <button type="submit">Delete</button>
        </form>

        <h2>Update Transaction</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="number" name="transactionID" placeholder="Transaction ID" required>
            <input type="text" name="purpose" placeholder="Purpose" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="text" name="transactionType" placeholder="Transaction Type" required>
            <input type="date" name="transactionDate" placeholder="Transaction Date" required>
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <input type="number" name="institutionID" placeholder="Institution ID" required>
            <input type="number" name="userID" placeholder="User ID" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
