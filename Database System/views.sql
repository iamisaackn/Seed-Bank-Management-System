USE SeedBankManagementSystem;

# Fetch all views
SELECT TABLE_NAME AS view_name
FROM information_schema.VIEWS
WHERE TABLE_SCHEMA = 'SeedBankManagementSystem';

# Drop a view
DROP VIEW SeedsWithActiveStorage;

# -------------------------- Logical Views --------------------------
-- Lists active seeds with their associated storage details, such as storage locations and quantities.
CREATE VIEW ActiveSeedsStorage AS
SELECT 
    Seed.speciesName, 
    Seed.family, 
    Storage.location1, 
    Storage.quantity
FROM Seed
INNER JOIN Storage ON Seed.seedID = Storage.seedID
WHERE Seed.status = 'Active'
ORDER BY Storage.quantity DESC;

-- Lists all seeds that do not have a storage location assigned.
CREATE VIEW UnallocatedSeeds AS
SELECT 
    Seed.speciesName, 
    Seed.family, 
    Seed.origin
FROM Seed
LEFT JOIN Storage ON Seed.seedID = Storage.seedID
WHERE Storage.location1 IS NULL;

-- Counts the number of seeds belonging to each genus, showing only genera with multiple seeds.
CREATE VIEW GenusSeedCount AS
SELECT 
    genus, 
    COUNT(*) AS seedCount
FROM Seed
GROUP BY genus
HAVING seedCount > 1;

-- Displays the total number of seeds contributed by each collector.
CREATE VIEW CollectorContributions AS
SELECT 
    collectorName, 
    COUNT(seedID) AS totalSeeds
FROM Seed
GROUP BY collectorName
ORDER BY totalSeeds DESC;

-- Provides an overview of seed testing results, including test dates and pathogen tests performed.
CREATE VIEW SeedTestingOverview AS
SELECT 
    SeedTesting.testID,
    SeedTesting.pathogenTest,
    SeedTesting.testDate,
    SeedTesting.germinationDate,
    Seed.speciesName
FROM SeedTesting
JOIN Seed ON SeedTesting.seedID = Seed.seedID;