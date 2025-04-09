<?php
// Establish the database connection
$conn = new mysqli("localhost", "root", "", "seedbankmanagementsystem", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define queries for analysis
$queries = [
    "Storage details for specific seeds:" => "
SELECT Storage.storageID, Storage.location1, Storage.quantity, Seed.speciesName
FROM Storage
INNER JOIN Seed ON Storage.seedID = Seed.seedID
WHERE Storage.quantity > 100
ORDER BY Storage.quantity DESC;

    ",
    "Storage locations without seeds" => "
SELECT Storage.storageID, Storage.location1, Seed.speciesName
FROM Storage
LEFT JOIN Seed ON Storage.seedID = Seed.seedID
WHERE Seed.speciesName IS NULL;

    ",
    "Seeds without storage details" => "
SELECT Seed.speciesName, Storage.storageID
FROM Seed
RIGHT JOIN Storage ON Seed.seedID = Storage.seedID
WHERE Storage.storageID IS NULL;

    ",
    "View all storage and seeds" => "
SELECT Storage.storageID, Storage.location1, Seed.speciesName
FROM Storage
LEFT JOIN Seed ON Storage.seedID = Seed.seedID
UNION
SELECT Storage.storageID, Storage.location1, Seed.speciesName
FROM Seed
RIGHT JOIN Storage ON Seed.seedID = Storage.seedID;

    ",
    "Average humidity per packaging type" => "
SELECT Storage.packagingType, AVG(Storage.humidity) AS avgHumidity
FROM Storage
GROUP BY Storage.packagingType
HAVING avgHumidity > 50;

    ",
    "Locations storing seeds with temperatures below 20°C" => "
SELECT location1, location2, temperature
FROM Storage
WHERE temperature < 20
ORDER BY temperature ASC;

    ",
    "Count of seeds per storage location" => "
SELECT Storage.location1, COUNT(Seed.seedID) AS seedCount
FROM Storage
INNER JOIN Seed ON Storage.seedID = Seed.seedID
GROUP BY Storage.location1;

    ",
    "Total quantity of seeds by storage location" => "
SELECT Storage.location1, SUM(Storage.quantity) AS totalQuantity
FROM Storage
GROUP BY Storage.location1
ORDER BY totalQuantity DESC;

    ",
    "Maximum temperature recorded for each seed family" => "
SELECT Seed.family, MAX(Storage.temperature) AS maxTemperature
FROM Storage
INNER JOIN Seed ON Storage.seedID = Seed.seedID
GROUP BY Seed.family;

    ",
    "Seed origins and their storage humidity levels" => "
SELECT Seed.origin, AVG(Storage.humidity) AS avgHumidity
FROM Storage
INNER JOIN Seed ON Storage.seedID = Seed.seedID
GROUP BY Seed.origin;

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
        <p>Storage Analysis</p>
    </header>
    <nav>
        <ul>
            <li><a href="home.php">Seed</a></li>
            <li><a class="active" href="storage.php">Storage</a></li>
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
