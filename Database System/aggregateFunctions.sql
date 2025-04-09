-- Total seeds in storage
SELECT SUM(quantity) AS totalSeeds FROM Storage;

-- Average germination rate
SELECT AVG(germinationRate) AS avgGerminationRate FROM SeedTesting;

-- Maximum and minimum temperatures in storage
SELECT MAX(temperature) AS maxTemp, MIN(temperature) AS minTemp FROM Storage;
