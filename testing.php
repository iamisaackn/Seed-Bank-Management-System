<?php
// Establish the database connection
$conn = new mysqli("localhost", "root", "", "seedbankmanagementsystem", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define queries for analysis
$queries = [
    "Seed Testing Details" => "
        SELECT SeedTesting.testID, SeedTesting.pathogenTest, Seed.speciesName
        FROM SeedTesting
        INNER JOIN Seed ON SeedTesting.seedID = Seed.seedID
        WHERE SeedTesting.testDate >= '2025-04-01'
        ORDER BY SeedTesting.testDate DESC;

    ",
    "Tests without matching seeds" => "
        SELECT SeedTesting.testID, SeedTesting.pathogenTest, Seed.speciesName
        FROM SeedTesting
        LEFT JOIN Seed ON SeedTesting.seedID = Seed.seedID
        WHERE Seed.speciesName IS NULL;
    ",
    "Seeds without tests" => "
SELECT Seed.speciesName, SeedTesting.testID
FROM Seed
RIGHT JOIN SeedTesting ON Seed.seedID = SeedTesting.seedID
WHERE SeedTesting.testID IS NULL;

    ",
    "All tests and seeds" => "
SELECT SeedTesting.testID, SeedTesting.pathogenTest, Seed.speciesName
FROM SeedTesting
LEFT JOIN Seed ON SeedTesting.seedID = Seed.seedID
UNION
SELECT SeedTesting.testID, SeedTesting.pathogenTest, Seed.speciesName
FROM SeedTesting
RIGHT JOIN Seed ON SeedTesting.seedID = Seed.seedID;

    ",
    "Count of tests per pathogen type" => "
SELECT pathogenTest, COUNT(*) AS testCount
FROM SeedTesting
GROUP BY pathogenTest
HAVING testCount > 1;

    ",
    "Tests conducted in a specific date range" => "
SELECT testID, testDate, pathogenTest
FROM SeedTesting
WHERE testDate BETWEEN '2025-04-01' AND '2025-04-05'
ORDER BY testDate ASC;

    ",
    "Average germination time per pathogen type" => "
SELECT pathogenTest, AVG(DATEDIFF(germinationDate, testDate)) AS avgGerminationTime
FROM SeedTesting
GROUP BY pathogenTest;

    ",
    "Latest germination date per seed species" => "
SELECT Seed.speciesName, MAX(SeedTesting.germinationDate) AS latestGerminationDate
FROM SeedTesting
INNER JOIN Seed ON SeedTesting.seedID = Seed.seedID
GROUP BY Seed.speciesName;
    ",
    "Count of tests conducted per seed origin" => "
SELECT Seed.origin, COUNT(SeedTesting.testID) AS testCount
FROM SeedTesting
INNER JOIN Seed ON SeedTesting.seedID = Seed.seedID
GROUP BY Seed.origin;

    ",
    "Total days taken for germination per seed family" => "
SELECT Seed.family, SUM(DATEDIFF(germinationDate, testDate)) AS totalGerminationDays
FROM SeedTesting
INNER JOIN Seed ON SeedTesting.seedID = Seed.seedID
GROUP BY Seed.family
ORDER BY totalGerminationDays DESC;

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
        <p>Seed Test Analysis</p>
    </header>
    <nav>
        <ul>
            <li><a href="home.php">Seed</a></li>
            <li><a href="storage.php">Storage</a></li>
            <li><a class="active" href="testing.php">Seed Testing</a></li>
            <li><a href="transactions.php">Transactions</a></li>
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
