<?php
// Establish the database connection
$conn = new mysqli("localhost", "root", "", "seedbankmanagementsystem", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define queries for analysis
$queries = [
    "Missing Institution Transactions" => "
        SELECT Institutions.name AS institutionName, Transactions.transactionID
        FROM Institutions
        RIGHT JOIN Transactions ON Institutions.institutionID = Transactions.institutionID
        WHERE Transactions.transactionID IS NULL
    ",
    "Institutions Transaction" => "
        SELECT Transactions.transactionID, Transactions.purpose, Institutions.name AS institutionName
        FROM Transactions
        LEFT JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
        UNION
        SELECT Transactions.transactionID, Transactions.purpose, Institutions.name AS institutionName
        FROM Transactions
        RIGHT JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
    ",
    "Transaction type" => "
        SELECT Transactions.transactionType, COUNT(*) AS transactionCount
        FROM Transactions
        GROUP BY Transactions.transactionType
        HAVING transactionCount >= 1
    ",
    "Transactions in a date range" => "
        SELECT Transactions.transactionID, Transactions.transactionDate
        FROM Transactions
        WHERE Transactions.transactionDate BETWEEN '2025-01-01' AND '2025-03-31'
        ORDER BY Transactions.transactionDate ASC
    ",
    "Average quantity per institution" => "
        SELECT Institutions.name AS institutionName, AVG(Transactions.quantity) AS averageQuantity
        FROM Transactions
        INNER JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
        GROUP BY Institutions.institutionID
    ",
    "Latest transaction per institution" => "
        SELECT Institutions.name AS institutionName, MAX(Transactions.transactionDate) AS latestTransactionDate
        FROM Transactions
        INNER JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
        GROUP BY Institutions.institutionID
    ",
    "Transaction count per seed" => "
        SELECT Seed.speciesName, COUNT(Transactions.transactionID) AS transactionCount
        FROM Transactions
        INNER JOIN Seed ON Transactions.seedID = Seed.seedID
        GROUP BY Seed.seedID
    ",
    "Total quantity by seed origin" => "
        SELECT Seed.origin, SUM(Transactions.quantity) AS totalQuantity
        FROM Transactions
        INNER JOIN Seed ON Transactions.seedID = Seed.seedID
        GROUP BY Seed.origin
        ORDER BY totalQuantity DESC
    "
];

// Fetch results for each query
$results = [];
foreach ($queries as $description => $query) {
    $result = $conn->query($query);
    if ($result) {
        $results[$description] = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $results[$description] = ["Error" => $conn->error];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seed Bank Management System - Combined Analysis</title>
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
        <h1>Seed Bank Management System</h1>
        <p>Transactions Analysis</p>
    </header>
    <nav>
        <ul>
            <li><a href="home.php">Seed</a></li>
            <li><a href="storage.php">Storage</a></li>
            <li><a href="testing.php">Seed Testing</a></li>
            <li><a class="active" href="transactions.php">Transactions</a></li>
            <li><a href="institutions.php">Institution</a></li>
            <li><a href="account.php">Account</a></li>
        </ul>
    </nav>
    <div class="container">
        <?php foreach ($results as $description => $rows): ?>
            <h2><?php echo $description; ?></h2>
            <table>
                <thead>
                    <?php if (!empty($rows)): ?>
                        <tr>
                            <?php foreach (array_keys($rows[0]) as $key): ?>
                                <th><?php echo $key; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    <?php else: ?>
                        <tr><th>No Data</th></tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?php echo $cell; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>
</body>
</html>
