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
        $stmt = $conn->prepare("INSERT INTO SeedTesting (pathogenTest, testDate, germinationDate, seedID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $_POST['pathogenTest'], $_POST['testDate'], $_POST['germinationDate'], $_POST['seedID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM SeedTesting WHERE testID = ?");
        $stmt->bind_param("i", $_POST['testID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'update') {
        $stmt = $conn->prepare("UPDATE SeedTesting SET pathogenTest = ?, testDate = ?, germinationDate = ?, seedID = ? WHERE testID = ?");
        $stmt->bind_param("sssii", $_POST['pathogenTest'], $_POST['testDate'], $_POST['germinationDate'], $_POST['seedID'], $_POST['testID']);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all seed testing records for display
$seedTests = [];
$result = $conn->query("SELECT * FROM SeedTesting");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $seedTests[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Seed Testing Management</title>
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
        <h1>Admin Panel - Seed Testing Management</h1>
    </header>
     <nav>
        <ul>
            <li><a href="adminSeed.php">Seed</a></li>
            <li><a href="adminStorage.php">Storage</a></li>
            <li><a class="active" href="adminSeedTesting.php">Seed Testing</a></li>
            <li><a href="adminTransaction.php">Transactions</a></li>
            <li><a href="adminInstitutions.php">Institution</a></li>
            <li><a href="adminUser.php">Users</a></li>
            <li><a href="adminProfile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Seed Testing Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Test ID</th>
                    <th>Pathogen Test</th>
                    <th>Test Date</th>
                    <th>Germination Date</th>
                    <th>Seed ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seedTests as $test): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($test['testID']); ?></td>
                        <td><?php echo htmlspecialchars($test['pathogenTest']); ?></td>
                        <td><?php echo htmlspecialchars($test['testDate']); ?></td>
                        <td><?php echo htmlspecialchars($test['germinationDate']); ?></td>
                        <td><?php echo htmlspecialchars($test['seedID']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Insert Seed Test</h2>
        <form method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="text" name="pathogenTest" placeholder="Pathogen Test" required>
            <input type="date" name="testDate" placeholder="Test Date" required>
            <input type="date" name="germinationDate" placeholder="Germination Date">
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <button type="submit">Insert</button>
        </form>

        <h2>Delete Seed Test</h2>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="number" name="testID" placeholder="Test ID" required>
            <button type="submit">Delete</button>
        </form>

        <h2>Update Seed Test</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="number" name="testID" placeholder="Test ID" required>
            <input type="text" name="pathogenTest" placeholder="Pathogen Test" required>
            <input type="date" name="testDate" placeholder="Test Date" required>
            <input type="date" name="germinationDate" placeholder="Germination Date">
            <input type="number" name="seedID" placeholder="Seed ID" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
