<?php
// Database connection
$conn = new mysqli("localhost", "AdminUser", "adminPassword", "seedbankmanagementsystem", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'logout') {
        // Handle logout
        session_destroy();
        header("Location: account.php");
        exit();
    } elseif ($action == 'signup') {
        // Signup logic
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email1 = $_POST['email1'];
        $email2 = $_POST['email2'];
        $phoneNumber1 = $_POST['phoneNumber1'];
        $phoneNumber2 = $_POST['phoneNumber2'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmpassword'];
        $role = $_POST['role'];
        $institutionID = $_POST['institutionID'];

        if ($password === $confirmPassword) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO Users (firstName, lastName, email1, email2, phoneNumber1, phoneNumber2, password, role, institutionID)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssssi', $firstName, $lastName, $email1, $email2, $phoneNumber1, $phoneNumber2, $hashedPassword, $role, $institutionID);
            if ($stmt->execute()) {
                header('Location: adminProfile.php');
                exit();
            } else {
                $message = "Signup failed. Please try again.";
            }
        } else {
            $message = "Passwords do not match.";
        }
    } elseif ($action == 'login') {
        // Login logic
        $email1 = $_POST['email1'];
        $password = $_POST['password'];

        $sql = "SELECT userID, password, role FROM Users WHERE email1 = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email1);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'AdminUser') {
                    header('Location: adminProfile.php');
                    exit();
                } else {
                    echo "<script>alert('Website user permission page is coming soon.');</script>";
                }
            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "No user found with this email.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #eef2f5; margin: 0; padding: 0; }
        header { background-color: #5d6d7e; color: white; padding: 1rem; text-align: center; }
        nav { background-color: #3c4d5e; padding: 1rem; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; justify-content: center; }
        nav ul li { margin: 0 1rem; }
        nav ul li a.active { color: #ffffff; background-color: #5d6d7e; font-weight: bold; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; }
        nav ul li a { color: white; text-decoration: none; font-weight: bold; }
        nav ul li a:hover { text-decoration: underline; }
        .container { max-width: 600px; margin: auto; padding: 2rem; background: white; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #5d6d7e; }
        form input, form select, form button { display: block; width: 100%; margin: 0.5rem 0; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        form button { background-color: #5d6d7e; color: white; border: none; cursor: pointer; }
        form button:hover { background-color: #3c4d5e; }
        .message { text-align: center; color: #333; font-weight: bold; }
    </style>
    <script>
        function toggleForms() {
            const loginForm = document.getElementById("login-form");
            const signupForm = document.getElementById("signup-form");
            loginForm.style.display = loginForm.style.display === "none" ? "block" : "none";
            signupForm.style.display = signupForm.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
<header><h1>Account Management</h1></header>
<nav>
    <ul>
        <li><a href="home.php">Seed</a></li>
        <li><a href="storage.php">Storage</a></li>
        <li><a href="testing.php">Seed Testing</a></li>
        <li><a href="transactions.php">Transactions</a></li>
        <li><a href="institutions.php">Institution</a></li>
        <li><a class="active" href="account.php">Account</a></li>
    </ul>
</nav>
<div class="container">
    <form id="login-form" method="POST">
        <h2>Login</h2>
        <input type="hidden" name="action" value="login">
        <input type="email" name="email1" placeholder="Primary Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <form id="signup-form" method="POST" style="display: none;">
        <h2>Signup</h2>
        <input type="hidden" name="action" value="signup">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email1" placeholder="Primary Email*" required>
        <input type="email" name="email2" placeholder="Secondary Email">
        <input type="text" name="phoneNumber1" placeholder="Primary Phone Number*" required>
        <input type="text" name="phoneNumber2" placeholder="Secondary Phone Number">
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
        <select name="role" required>
            <option value="AdminUser">AdminUser</option>
            <option value="EmployeeUser">EmployeeUser</option>
            <option value="ManagerUser">ManagerUser</option>
        </select>
        <input type="number" name="institutionID" placeholder="Institution ID" required>
        <button type="submit">Signup</button>
    </form>
    <button onclick="toggleForms()">Switch to Signup/Login</button>
    <div class="message"><?php echo $message; ?></div>
</div>
</body>
</html>
