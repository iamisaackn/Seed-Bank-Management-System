-- Categorize seeds based on age
SELECT speciesName,
       CASE
           WHEN age < 30 THEN 'New'
           WHEN age BETWEEN 30 AND 90 THEN 'Moderate'
           ELSE 'Old'
       END AS AgeCategory
FROM Seed;
