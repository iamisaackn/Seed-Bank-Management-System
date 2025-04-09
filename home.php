<?php
// Establish the database connection
$conn = new mysqli("localhost", "root", "", "seedbankmanagementsystem", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define queries for analysis
$queries = [
    "Seeds with active storage:" => "
SELECT Seed.speciesName, Seed.family, Storage.location1, Storage.quantity
FROM Seed
INNER JOIN Storage ON Seed.seedID = Storage.seedID
WHERE Seed.status = 'Active'
ORDER BY Storage.quantity DESC;

    ",
    "Identify seeds without storage" => "
SELECT Seed.speciesName, Storage.location1
FROM Seed
LEFT JOIN Storage ON Seed.seedID = Storage.seedID
WHERE Storage.location1 IS NULL;

    ",
    "Storage entries without linked seeds" => "
SELECT Storage.location1, Seed.speciesName
FROM Storage
RIGHT JOIN Seed ON Seed.seedID = Storage.seedID
WHERE Seed.speciesName IS NULL;

    ",
    "Count of seeds per genus" => "
SELECT genus, COUNT(*) AS seedCount
FROM Seed
GROUP BY genus
HAVING seedCount > 1;

    ",
    "Seeds collected in a specific time frame" => "
SELECT speciesName, collectionDate, collectorName
FROM Seed
WHERE collectionDate BETWEEN '2025-03-01' AND '2025-03-31'
ORDER BY collectionDate ASC;

    ",
    "Total seeds collected by each collector" => "
SELECT collectorName, COUNT(seedID) AS totalSeeds
FROM Seed
GROUP BY collectorName
ORDER BY totalSeeds DESC;

    ",
    "Average number of seeds per family" => "
SELECT family, AVG(Storage.quantity) AS avgSeeds
FROM Seed
INNER JOIN Storage ON Seed.seedID = Storage.seedID
GROUP BY family
HAVING avgSeeds > 50;

    ",
    "Seed families and their earliest collection date" => "
SELECT family, MIN(collectionDate) AS earliestCollection
FROM Seed
GROUP BY family;

    ",
    "Origins of seeds stored with above-average humidity levels" => "
SELECT Seed.origin, AVG(Storage.humidity) AS avgHumidity
FROM Seed
INNER JOIN Storage ON Seed.seedID = Storage.seedID
GROUP BY Seed.origin
HAVING avgHumidity > 60
ORDER BY avgHumidity DESC;

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
            text-align: center;
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
        <p>Seed Analysis</p>
    </header>
    <nav>
        <ul>
            <li><a class="active" href="home.php">Seed</a></li>
            <li><a href="storage.php">Storage</a></li>
            <li><a href="testing.php">Seed Testing</a></li>
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
