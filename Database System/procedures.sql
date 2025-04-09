USE SeedBankManagementSystem;

# ---------------------- Logical Stored Procedures --------------------------
-- Inserts a new seed into the Seed table.
DELIMITER $$
CREATE PROCEDURE AddSeed(
    IN speciesName VARCHAR(50),
    IN family VARCHAR(50),
    IN genus VARCHAR(50),
    IN origin VARCHAR(50),
    IN collectionDate DATE,
    IN collectorName VARCHAR(50),
    IN status VARCHAR(20)
)
BEGIN
    INSERT INTO Seed (speciesName, family, genus, origin, collectionDate, collectorName, status)
    VALUES (speciesName, family, genus, origin, collectionDate, collectorName, status);
END$$
DELIMITER ;

-- Fetches all active seeds, sorted by collection date.
DELIMITER $$
CREATE PROCEDURE FetchActiveSeeds()
BEGIN
    SELECT speciesName, family, genus, collectionDate
    FROM Seed
    WHERE status = 'Active'
    ORDER BY collectionDate ASC;
END$$
DELIMITER ;

-- Counts seeds grouped by genus, showing genera with more than one seed.
DELIMITER $$
CREATE PROCEDURE SeedCountByGenus()
BEGIN
    SELECT genus, COUNT(*) AS seedCount
    FROM Seed
    GROUP BY genus
    HAVING seedCount > 1
    ORDER BY seedCount DESC;
END$$
DELIMITER ;

-- Updates the status of a seed based on its seedID.
DELIMITER $$
CREATE PROCEDURE UpdateSeedStatus(
    IN seedID INT,
    IN newStatus VARCHAR(20)
)
BEGIN
    UPDATE Seed
    SET status = newStatus
    WHERE seedID = seedID;
END$$
DELIMITER ;

-- Fetches seeds that are not stored in any location.
DELIMITER $$
CREATE PROCEDURE FetchUnallocatedSeeds()
BEGIN
    SELECT speciesName, family, origin
    FROM Seed
    WHERE seedID NOT IN (SELECT seedID FROM Storage);
END$$
DELIMITER ;

-- Fetches transaction details within a specified date range.
DELIMITER $$
CREATE PROCEDURE TransactionHistoryByDate(
    IN startDate DATE,
    IN endDate DATE
)
BEGIN
    SELECT purpose, quantity, transactionType, transactionDate, seedID
    FROM Transactions
    WHERE transactionDate BETWEEN startDate AND endDate
    ORDER BY transactionDate DESC;
END$$
DELIMITER ;

-- Adds storage information for a specific seed.
DELIMITER $$
CREATE PROCEDURE AddSeedStorage(
    IN seedID INT,
    IN location1 VARCHAR(100),
    IN location2 VARCHAR(100),
    IN temperature DECIMAL(5,2),
    IN humidity DECIMAL(5,2),
    IN packagingType VARCHAR(50),
    IN quantity INT
)
BEGIN
    INSERT INTO Storage (seedID, location1, location2, temperature, humidity, packagingType, quantity)
    VALUES (seedID, location1, location2, temperature, humidity, packagingType, quantity);
END$$
DELIMITER ;


-- Calculates the average humidity grouped by storage location.
DELIMITER $$
CREATE PROCEDURE AverageHumidityByLocation()
BEGIN
    SELECT location1, AVG(humidity) AS avgHumidity
    FROM Storage
    GROUP BY location1
    HAVING avgHumidity > 60
    ORDER BY avgHumidity DESC;
END$$
DELIMITER ;

-- Shows the total number of seeds collected by each collector.
DELIMITER $$
CREATE PROCEDURE CollectorContributionSummary()
BEGIN
    SELECT collectorName, COUNT(seedID) AS totalSeeds
    FROM Seed
    GROUP BY collectorName
    ORDER BY totalSeeds DESC;
END$$
DELIMITER ;

-- Fetches seed testing results with pathogen details.
DELIMITER $$
CREATE PROCEDURE SeedTestingResults(
    IN startDate DATE,
    IN endDate DATE
)
BEGIN
    SELECT testID, pathogenTest, testDate, germinationDate, seedID
    FROM SeedTesting
    WHERE testDate BETWEEN startDate AND endDate
    ORDER BY testDate ASC;
END$$
DELIMITER ;
