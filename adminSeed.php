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
        $stmt = $conn->prepare("INSERT INTO Seed (speciesName, family, genus, origin, collectionDate, collectorName, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $_POST['speciesName'], $_POST['family'], $_POST['genus'], $_POST['origin'], $_POST['collectionDate'], $_POST['collectorName'], $_POST['status']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Seed WHERE seedID = ?");
        $stmt->bind_param("i", $_POST['seedID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'update') {
        $stmt = $conn->prepare("UPDATE Seed SET speciesName = ?, family = ?, genus = ?, origin = ?, collectionDate = ?, collectorName = ?, status = ? WHERE seedID = ?");
        $stmt->bind_param("sssssssi", $_POST['speciesName'], $_POST['family'], $_POST['genus'], $_POST['origin'], $_POST['collectionDate'], $_POST['collectorName'], $_POST['status'], $_POST['seedID']);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all seeds for display purposes
$seeds = [];
$result = $conn->query("SELECT * FROM Seed");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $seeds[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Seed Management</title>
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
        <h1>Admin Panel - Seed Management</h1>
    </header>
    <nav>
        <ul>
            <li><a class="active" href="adminSeed.php">Seed</a></li>
            <li><a href="adminStorage.php">Storage</a></li>
            <li><a href="adminSeedTesting.php">Seed Testing</a></li>
            <li><a href="adminTransaction.php">Transactions</a></li>
            <li><a href="adminInstitutions.php">Institution</a></li>
            <li><a href="adminUser.php">Users</a></li>
            <li><a href="adminProfile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Seed Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Seed ID</th>
                    <th>Species Name</th>
                    <th>Family</th>
                    <th>Genus</th>
                    <th>Origin</th>
                    <th>Collection Date</th>
                    <th>Collector Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seeds as $seed): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($seed['seedID']); ?></td>
                        <td><?php echo htmlspecialchars($seed['speciesName']); ?></td>
                        <td><?php echo htmlspecialchars($seed['family']); ?></td>
                        <td><?php echo htmlspecialchars($seed['genus']); ?></td>
                        <td><?php echo htmlspecialchars($seed['origin']); ?></td>
                        <td><?php echo htmlspecialchars($seed['collectionDate']); ?></td>
                        <td><?php echo htmlspecialchars($seed['collectorName']); ?></td>
                        <td><?php echo htmlspecialchars($seed['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Insert Seed</h2>
        <form method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="text" name="speciesName" placeholder="Species Name" required>
            <input type="text" name="family" placeholder="Family">
            <input type="text" name="genus" placeholder="Genus">
            <input type="text" name="origin" placeholder="Origin">
            <input type="date" name="collectionDate" placeholder="Collection Date">
            <input type="text" name="collectorName" placeholder="Collector Name">
            <input type="text" name="status" placeholder="Status">
            <button type="submit">Insert</button>
        </form>

        <h2>Delete Seed</h2>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <button type="submit">Delete</button>
        </form>

        <h2>Update Seed</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <input type="text" name="speciesName" placeholder="Species Name" required>
            <input type="text" name="family" placeholder="Family">
            <input type="text" name="genus" placeholder="Genus">
            <input type="text" name="origin" placeholder="Origin">
            <input type="date" name="collectionDate" placeholder="Collection Date">
            <input type="text" name="collectorName" placeholder="Collector Name">
            <input type="text" name="status" placeholder="Status">
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
