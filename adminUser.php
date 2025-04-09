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
    $stmt = $conn->prepare("INSERT INTO Users (firstName, lastName, email1, email2, phoneNumber1, phoneNumber2, password, role, institutionID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $_POST['firstName'], $_POST['lastName'], $_POST['email1'], $_POST['email2'], $_POST['phoneNumber1'], $_POST['phoneNumber2'], $_POST['password'], $_POST['role'], $_POST['institutionID']);
    $stmt->execute();
    $stmt->close();
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Users WHERE userID = ?");
        $stmt->bind_param("i", $_POST['userID']);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'update') {
        $stmt = $conn->prepare("UPDATE Users SET firstName = ?, lastName = ?, email1 = ?, phoneNumber1 = ?, password = ?, role = ?, institutionID = ? WHERE userID = ?");
        $stmt->bind_param("ssssssii", $_POST['firstName'], $_POST['lastName'], $_POST['email1'], $_POST['phoneNumber1'], $_POST['password'], $_POST['role'], $_POST['institutionID'], $_POST['userID']);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all users for display purposes
$users = [];
$result = $conn->query("SELECT * FROM Users");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CRUD Operations</title>
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
        <h1>Admin Panel - User Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="adminSeed.php">Seed</a></li>
            <li><a href="adminStorage.php">Storage</a></li>
            <li><a href="adminSeedTesting.php">Seed Testing</a></li>
            <li><a href="adminTransactions.php">Transactions</a></li>
            <li><a href="adminInstitutions.php">Institution</a></li>
            <li><a class="active" href="adminUser.php">Users</a></li>
            <li><a href="adminProfile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Users</h2>
        <table>
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email1</th>
                    <th>Email2</th>
                    <th>Phone1</th>
                    <th>Phone2</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Institution ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['userID']); ?></td>
                        <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                        <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                        <td><?php echo htmlspecialchars($user['email1']); ?></td>
                        <td><?php echo htmlspecialchars($user['email2']); ?></td>
                        <td><?php echo htmlspecialchars($user['phoneNumber1']); ?></td>
                        <td><?php echo htmlspecialchars($user['phoneNumber2']); ?></td>
                        <td><?php echo htmlspecialchars($user['password']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['institutionID']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Insert User</h2>
        <form method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="lastName" placeholder="Last Name" required>
            <input type="email" name="email1" placeholder="Primary Email*" required>
            <input type="email" name="email2" placeholder="Secondary Email" required>
            <input type="text" name="phoneNumber1" placeholder="Primary Phone*" required>
            <input type="text" name="phoneNumber2" placeholder="Secondary Phone" required>
            <input type="text" name="password" placeholder="Password" required>
            <input type="text" name="role" placeholder="Role" required>
            <input type="number" name="institutionID" placeholder="Institution ID" required>
            <button type="submit">Insert</button>
        </form>

        <h2>Delete User</h2>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="number" name="userID" placeholder="User ID" required>
            <button type="submit">Delete</button>
        </form>

        <h2>Update User</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="number" name="userID" placeholder="User ID" required>
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="lastName" placeholder="Last Name" required>
            <input type="email" name="email1" placeholder="Email" required>
            <input type="text" name="phoneNumber1" placeholder="Phone" required>
            <input type="text" name="password" placeholder="Password" required>
            <input type="text" name="role" placeholder="Role" required>
            <input type="number" name="institutionID" placeholder="Institution ID" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
