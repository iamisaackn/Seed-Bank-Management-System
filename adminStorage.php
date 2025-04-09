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
        $stmt = $conn->prepare("INSERT INTO Storage (location1, location2, temperature, humidity, packagingType, quantity, seedID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssii", $_POST['location1'], $_POST['location2'], $_POST['temperature'], $_POST['humidity'], $_POST['packagingType'], $_POST['quantity'], $_POST['seedID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Storage WHERE storageID = ?");
        $stmt->bind_param("i", $_POST['storageID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'update') {
        $stmt = $conn->prepare("UPDATE Storage SET location1 = ?, location2 = ?, temperature = ?, humidity = ?, packagingType = ?, quantity = ?, seedID = ? WHERE storageID = ?");
        $stmt->bind_param("ssdssiii", $_POST['location1'], $_POST['location2'], $_POST['temperature'], $_POST['humidity'], $_POST['packagingType'], $_POST['quantity'], $_POST['seedID'], $_POST['storageID']);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all storage records for display
$storageRecords = [];
$result = $conn->query("SELECT * FROM Storage");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $storageRecords[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Storage Management</title>
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
        <h1>Admin Panel - Storage Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="adminSeed.php">Seed</a></li>
            <li><a class="active" href="adminStorage.php">Storage</a></li>
            <li><a href="adminSeedTesting.php">Seed Testing</a></li>
            <li><a href="adminTransaction.php">Transactions</a></li>
            <li><a href="adminInstitutions.php">Institution</a></li>
            <li><a href="adminUser.php">Users</a></li>
            <li><a href="adminProfile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Storage Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Storage ID</th>
                    <th>Location 1</th>
                    <th>Location 2</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th>Packaging Type</th>
                    <th>Quantity</th>
                    <th>Seed ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($storageRecords as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['storageID']); ?></td>
                        <td><?php echo htmlspecialchars($record['location1']); ?></td>
                        <td><?php echo htmlspecialchars($record['location2']); ?></td>
                        <td><?php echo htmlspecialchars($record['temperature']); ?></td>
                        <td><?php echo htmlspecialchars($record['humidity']); ?></td>
                        <td><?php echo htmlspecialchars($record['packagingType']); ?></td>
                        <td><?php echo htmlspecialchars($record['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($record['seedID']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Insert Storage Record</h2>
        <form method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="text" name="location1" placeholder="Primary Location" required>
            <input type="text" name="location2" placeholder="Secondary Location">
            <input type="number" step="0.01" name="temperature" placeholder="Temperature" required>
            <input type="number" step="0.01" name="humidity" placeholder="Humidity" required>
            <input type="text" name="packagingType" placeholder="Packaging Type" value="Standard">
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <button type="submit">Insert</button>
        </form>

        <h2>Delete Storage Record</h2>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="number" name="storageID" placeholder="Storage ID" required>
            <button type="submit">Delete</button>
        </form>

        <h2>Update Storage Record</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="number" name="storageID" placeholder="Storage ID" required>
            <input type="text" name="location1" placeholder="Primary Location" required>
            <input type="text" name="location2" placeholder="Secondary Location">
            <input type="number" step="0.01" name="temperature" placeholder="Temperature" required>
            <input type="number" step="0.01" name="humidity" placeholder="Humidity" required>
            <input type="text" name="packagingType" placeholder="Packaging Type" value="Standard">
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
