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
        $stmt = $conn->prepare("INSERT INTO Institutions (name, location1, location2, email1, email2, phoneNumber1, phoneNumber2) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $_POST['name'], $_POST['location1'], $_POST['location2'], $_POST['email1'], $_POST['email2'], $_POST['phoneNumber1'], $_POST['phoneNumber2']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Institutions WHERE institutionID = ?");
        $stmt->bind_param("i", $_POST['institutionID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'update') {
        $stmt = $conn->prepare("UPDATE Institutions SET name = ?, location1 = ?, location2 = ?, email1 = ?, email2 = ?, phoneNumber1 = ?, phoneNumber2 = ? WHERE institutionID = ?");
        $stmt->bind_param("sssssssi", $_POST['name'], $_POST['location1'], $_POST['location2'], $_POST['email1'], $_POST['email2'], $_POST['phoneNumber1'], $_POST['phoneNumber2'], $_POST['institutionID']);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all institutions for display purposes
$institutions = [];
$result = $conn->query("SELECT * FROM Institutions");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $institutions[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Institutions Management</title>
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
        <h1>Admin Panel - Institutions Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="adminSeed.php">Seed</a></li>
            <li><a href="adminStorage.php">Storage</a></li>
            <li><a href="adminSeedTesting.php">Seed Testing</a></li>
            <li><a href="adminTransaction.php">Transactions</a></li>
            <li><a class="active" href="adminInstitutions.php">Institution</a></li>
            <li><a href="adminUser.php">Users</a></li>
            <li><a href="adminProfile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Institutions</h2>
        <table>
            <thead>
                <tr>
                    <th>Institution ID</th>
                    <th>Name</th>
                    <th>Location 1</th>
                    <th>Location 2</th>
                    <th>Email 1</th>
                    <th>Email 2</th>
                    <th>Phone 1</th>
                    <th>Phone 2</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($institutions as $institution): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($institution['institutionID']); ?></td>
                        <td><?php echo htmlspecialchars($institution['name']); ?></td>
                        <td><?php echo htmlspecialchars($institution['location1']); ?></td>
                        <td><?php echo htmlspecialchars($institution['location2']); ?></td>
                        <td><?php echo htmlspecialchars($institution['email1']); ?></td>
                        <td><?php echo htmlspecialchars($institution['email2']); ?></td>
                        <td><?php echo htmlspecialchars($institution['phoneNumber1']); ?></td>
                        <td><?php echo htmlspecialchars($institution['phoneNumber2']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Insert Institution</h2>
        <form method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="location1" placeholder="Primary Location" required>
            <input type="text" name="location2" placeholder="Secondary Location">
            <input type="email" name="email1" placeholder="Primary Email" required>
            <input type="email" name="email2" placeholder="Secondary Email">
            <input type="text" name="phoneNumber1" placeholder="Primary Phone" required>
            <input type="text" name="phoneNumber2" placeholder="Secondary Phone">
            <button type="submit">Insert</button>
        </form>

        <h2>Delete Institution</h2>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="number" name="institutionID" placeholder="Institution ID" required>
            <button type="submit">Delete</button>
        </form>

        <h2>Update Institution</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="number" name="institutionID" placeholder="Institution ID" required>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="location1" placeholder="Primary Location" required>
            <input type="text" name="location2" placeholder="Secondary Location">
            <input type="email" name="email1" placeholder="Primary Email" required>
            <input type="email" name="email2" placeholder="Secondary Email">
            <input type="text" name="phoneNumber1" placeholder="Primary Phone" required>
            <input type="text" name="phoneNumber2" placeholder="Secondary Phone">
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
