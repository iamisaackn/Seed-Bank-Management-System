<?php
// Establish the database connection
$conn = new mysqli("localhost", "AdminUser", "adminPassword", "seedbankmanagementsystem", 3307);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information based on the session or login
session_start();
$userID = $_SESSION['userID'] ?? null; // Retrieve userID from session or login process
$userInfo = [];

if ($userID) {
    $stmt = $conn->prepare("SELECT * FROM Users WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInfo = $result->fetch_assoc();
    $stmt->close();
} else {
    header("Location: account.php"); // Redirect to login/signup page if not logged in
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
            max-width: 600px;
            margin: auto;
            padding: 2rem;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #5d6d7e;
        }
        .user-info {
            margin: 2rem 0;
        }
        .user-info p {
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }
        .logout-btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            margin-top: 2rem;
            background-color: #d9534f;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Profile</h1>
    </header>
    <nav>
        <ul>
            <li><a href="adminSeed.php">Seed</a></li>
            <li><a href="adminStorage.php">Storage</a></li>
            <li><a href="adminSeedTesting.php">Seed Testing</a></li>
            <li><a href="adminTransactions.php">Transactions</a></li>
            <li><a href="adminInstitutions.php">Institution</a></li>
            <li><a href="adminUser.php">Users</a></li>
            <li><a class="active" href="profile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($userInfo['firstName'] ?? "User"); ?>!</h2>
        <div class="user-info">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($userInfo['firstName'] ?? "N/A"); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($userInfo['lastName'] ?? "N/A"); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userInfo['email1'] ?? "N/A"); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($userInfo['phoneNumber1'] ?? "N/A"); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($userInfo['role'] ?? "N/A"); ?></p>
            <p><strong>Institution ID:</strong> <?php echo htmlspecialchars($userInfo['institutionID'] ?? "N/A"); ?></p>
        </div>
        <form method="POST" action="account.php">
        <input type="hidden" name="action" value="logout">
        <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
