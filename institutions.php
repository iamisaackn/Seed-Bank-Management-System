<?php
// Establish the database connection
$conn = new mysqli("localhost", "root", "", "seedbankmanagementsystem", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define queries for analysis
$queries = [
    "Transactions conducted by institutions" => "
SELECT Institutions.name, Transactions.transactionType, COUNT(Transactions.transactionID) AS transactionCount
FROM Institutions
INNER JOIN Transactions ON Institutions.institutionID = Transactions.institutionID
GROUP BY Institutions.name, Transactions.transactionType
ORDER BY transactionCount DESC;

    ",
    "Identify institutions without any transactions" => "
SELECT Institutions.name, Transactions.transactionID
FROM Institutions
LEFT JOIN Transactions ON Institutions.institutionID = Transactions.institutionID
WHERE Transactions.transactionID IS NULL;

    ",
    "Transactions without matching institutions" => "
SELECT Transactions.transactionID, Institutions.name
FROM Transactions
RIGHT JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
WHERE Institutions.name IS NULL;

    ",
    "FULL OUTER JOIN using UNION" => "
SELECT Institutions.name, Transactions.transactionType
FROM Institutions
LEFT JOIN Transactions ON Institutions.institutionID = Transactions.institutionID
UNION
SELECT Institutions.name, Transactions.transactionType
FROM Institutions
RIGHT JOIN Transactions ON Institutions.institutionID = Transactions.institutionID;

    ",
    "Total number of institutions grouped by location" => "
SELECT location1, COUNT(institutionID) AS institutionCount
FROM Institutions
GROUP BY location1
HAVING institutionCount > 1
ORDER BY institutionCount DESC;

    ",
    "Transactions linked to institutions in a specific location" => "
SELECT Institutions.name, Transactions.transactionType, Transactions.transactionDate
FROM Institutions
INNER JOIN Transactions ON Institutions.institutionID = Transactions.institutionID
WHERE Institutions.location1 = 'Nairobi'
ORDER BY Transactions.transactionDate ASC;

    ",
    "Count of transactions handled by each institution" => "
SELECT Institutions.name, COUNT(Transactions.transactionID) AS transactionCount
FROM Transactions
INNER JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
GROUP BY Institutions.name
ORDER BY transactionCount DESC;

    ",
    "Average quantity of transactions per institution" => "
SELECT Institutions.name, AVG(Transactions.quantity) AS avgQuantity
FROM Transactions
INNER JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
GROUP BY Institutions.name
HAVING avgQuantity > 20;

    ",
    "Earliest transaction date for each institution" => "
SELECT Institutions.name, MIN(Transactions.transactionDate) AS earliestTransactionDate
FROM Transactions
INNER JOIN Institutions ON Transactions.institutionID = Institutions.institutionID
GROUP BY Institutions.name;

    ",
    "Institutions and their email details for outgoing transactions" => "
SELECT Institutions.name, Institutions.email1, COUNT(Transactions.transactionID) AS outgoingCount
FROM Institutions
INNER JOIN Transactions ON Institutions.institutionID = Transactions.institutionID
WHERE Transactions.transactionType = 'Outgoing'
GROUP BY Institutions.name, Institutions.email1
ORDER BY outgoingCount DESC;

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
        <p>Institutions Analysis</p>
    </header>
    <nav>
        <ul>
            <li><a href="home.php">Seed</a></li>
            <li><a href="storage.php">Storage</a></li>
            <li><a href="testing.php">Seed Testing</a></li>
            <li><a href="transactions.php">Transactions</a></li>
            <li><a class="active" href="institutions.php">Institution</a></li>
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
