USE SeedBankManagementSystem;

-- Seed Table
INSERT INTO Seed (speciesName, family, genus, origin, collectionDate, collectorName, status)
VALUES
('Acacia tortilis', 'Fabaceae', 'Acacia', 'Kenya', '2025-03-01', 'John Mwangi', 'Active'),
('Balanites aegyptiaca', 'Zygophyllaceae', 'Balanites', 'Kenya', '2025-02-20', 'Jane Wanjiru', 'Collected'),
('Croton macrostachyus', 'Euphorbiaceae', 'Croton', 'Kenya', '2025-01-18', 'Michael Karanja', 'Stored'),
('Hibiscus fuscus', 'Malvaceae', 'Hibiscus', 'Kenya', '2025-03-25', 'Grace Ndungu', 'Active'),
('Ficus sycomorus', 'Moraceae', 'Ficus', 'Kenya', '2025-02-15', 'Ali Hassan', 'Active'),
('Prunus africana', 'Rosaceae', 'Prunus', 'Kenya', '2025-04-01', 'Irene Ndichu', 'Active'),
('Juniperus procera', 'Cupressaceae', 'Juniperus', 'Kenya', '2025-03-10', 'Peter Otieno', 'Stored'),
('Hagenia abyssinica', 'Rosaceae', 'Hagenia', 'Kenya', '2025-02-05', 'Ann Ndegwa', 'Collected'),
('Terminalia brownii', 'Combretaceae', 'Terminalia', 'Kenya', '2025-01-30', 'Lucy Kimani', 'Active'),
('Olea europaea africana', 'Oleaceae', 'Olea', 'Kenya', '2025-04-03', 'David Kamau', 'Active'),
('Grevillea robusta', 'Proteaceae', 'Grevillea', 'Kenya', '2025-03-05', 'George Gathogo', 'Active'),
('Albizia gummifera', 'Fabaceae', 'Albizia', 'Kenya', '2025-01-12', 'Nancy Mutua', 'Stored'),
('Erythrina abyssinica', 'Fabaceae', 'Erythrina', 'Kenya', '2025-02-18', 'James Karanja', 'Collected'),
('Brachystegia spiciformis', 'Fabaceae', 'Brachystegia', 'Kenya', '2025-03-02', 'Emily Wairimu', 'Active'),
('Melia volkensii', 'Meliaceae', 'Melia', 'Kenya', '2025-03-22', 'Paul Chege', 'Collected'),
('Syzygium guineense', 'Myrtaceae', 'Syzygium', 'Kenya', '2025-02-25', 'Edith Kariuki', 'Active'),
('Vachellia xanthophloea', 'Fabaceae', 'Vachellia', 'Kenya', '2025-01-20', 'Susan Wambui', 'Stored'),
('Warburgia ugandensis', 'Canellaceae', 'Warburgia', 'Kenya', '2025-04-02', 'Mark Kibicho', 'Active'),
('Cordia africana', 'Boraginaceae', 'Cordia', 'Kenya', '2025-02-11', 'Jane Mwangi', 'Collected'),
('Dombeya torrida', 'Malvaceae', 'Dombeya', 'Kenya', '2025-03-28', 'Ali Hassan', 'Active');


-- Storage Table
INSERT INTO Storage (location1, location2, temperature, humidity, packagingType, quantity, seedID)
VALUES
('Nairobi Seed Bank', 'Westlands', 15.50, 45.00, 'Vacuum-Sealed', 120, 1),
('Kisumu Agricultural Center', 'Milimani', 22.00, 50.00, 'Standard', 200, 2),
('Mombasa Research Institute', 'Nyali', 28.00, 70.00, 'Moisture-Proof', 300, 3),
('Eldoret Storage Facility', 'Kapseret', 18.00, 55.00, 'Standard', 150, 4),
('Nakuru Plant Vault', 'Njoro', 16.00, 48.00, 'Air-Tight', 250, 5),
('Thika Horticultural Hub', 'Makongeni', 20.50, 60.00, 'Vacuum-Sealed', 140, 6),
('Kericho Tea Research Center', 'Kipkelion', 17.00, 40.00, 'Standard', 160, 7),
('Nyeri Agro Center', 'Othaya', 14.00, 35.00, 'Standard', 130, 8),
('Machakos Seed Reserve', 'Matuu', 21.00, 50.00, 'Vacuum-Sealed', 190, 9),
('Kitui Rural Storage', 'Mutomo', 25.00, 65.00, 'Moisture-Proof', 110, 10),
('Narok Field Store', 'Oloolunga', 19.50, 42.00, 'Air-Tight', 210, 11),
('Malindi Crop Research', 'Ganda', 29.00, 75.00, 'Standard', 300, 12),
('Meru Agro Bank', 'Timau', 13.50, 33.00, 'Vacuum-Sealed', 170, 13),
('Embu Farmers Depot', 'Runyenjes', 18.50, 45.00, 'Air-Tight', 120, 14),
('Garissa Drylands Center', 'Dadaab', 32.00, 20.00, 'Standard', 90, 15),
('Isiolo Preservation Hub', 'Kinna', 30.00, 25.00, 'Standard', 85, 16),
('Lamu Coastal Storage', 'Shela', 27.50, 80.00, 'Moisture-Proof', 200, 17),
('Turkana Seed Reserve', 'Lodwar', 31.00, 35.00, 'Standard', 100, 18),
('Marsabit Storage Site', 'Moyale', 28.50, 30.00, 'Standard', 95, 19),
('Voi Research Station', 'Taita', 26.00, 70.00, 'Moisture-Proof', 220, 20);

-- Seed Testing Table
INSERT INTO SeedTesting (pathogenTest, testDate, germinationDate, seedID)
VALUES
('Fungal Analysis', '2025-01-10', '2025-01-17', 1),
('Bacterial Inspection', '2025-02-05', '2025-02-12', 2),
('Viral Detection', '2025-03-01', '2025-03-10', 3),
('Fungal Analysis', '2025-01-15', '2025-01-22', 4),
('Bacterial Inspection', '2025-03-25', '2025-04-02', 5),
('Viral Detection', '2025-02-18', '2025-02-26', 6),
('Fungal Analysis', '2025-04-01', '2025-04-08', 7),
('Bacterial Inspection', '2025-01-22', '2025-01-30', 8),
('Viral Detection', '2025-02-12', '2025-02-20', 9),
('Fungal Analysis', '2025-03-10', '2025-03-18', 10),
('Bacterial Inspection', '2025-03-15', '2025-03-23', 11),
('Viral Detection', '2025-03-22', '2025-04-01', 12),
('Fungal Analysis', '2025-04-02', '2025-04-10', 13),
('Bacterial Inspection', '2025-01-31', '2025-02-08', 14),
('Viral Detection', '2025-02-25', '2025-03-05', 15),
('Fungal Analysis', '2025-03-12', '2025-03-19', 16),
('Bacterial Inspection', '2025-02-02', '2025-02-10', 17),
('Viral Detection', '2025-03-05', '2025-03-12', 18),
('Fungal Analysis', '2025-01-20', '2025-01-27', 19),
('Bacterial Inspection', '2025-04-01', '2025-04-09', 20);

-- Institutions Table
INSERT INTO Institutions (name, location1, location2, email1, email2, phoneNumber1, phoneNumber2)
VALUES
('Kenya Agricultural Research Institute', 'Nairobi', 'Upper Hill', 'info@kari.go.ke', 'support@kari.go.ke', '+254700123001', '+254700123002'),
('Kenya Forestry Research Institute', 'Kisumu', 'Maseno', 'contact@kefri.go.ke', 'research@kefri.go.ke', '+254701234001', '+254701234002'),
('International Livestock Research Institute', 'Nairobi', 'Kabete', 'info@ilri.org', 'support@ilri.org', '+254702345001', '+254702345002'),
('Kenya Seed Company', 'Kitale', 'Kwanza', 'info@kenyaseed.com', 'sales@kenyaseed.com', '+254703456001', '+254703456002'),
('Egerton University Seed Unit', 'Nakuru', 'Njoro', 'info@egerton.ac.ke', 'seed@egerton.ac.ke', '+254704567001', '+254704567002'),
('Kenya Wildlife Service', 'Mombasa', 'KWS Center', 'info@kws.go.ke', 'marine@kws.go.ke', '+254705678001', '+254705678002'),
('University of Nairobi Botany Dept.', 'Nairobi', 'Chiromo', 'botany@uon.ac.ke', 'info@uon.ac.ke', '+254706789001', '+254706789002'),
('Jomo Kenyatta University Agribusiness', 'Thika', 'Main Campus', 'agribusiness@jkuat.ac.ke', 'info@jkuat.ac.ke', '+254707890001', '+254707890002'),
('KALRO Crop Research', 'Eldoret', 'Chepkoilel', 'cropresearch@kalro.go.ke', 'info@kalro.go.ke', '+254708901001', '+254708901002'),
('Kenya Plant Health Inspectorate Service', 'Nairobi', 'Lenana Road', 'info@kephis.go.ke', 'inspections@kephis.go.ke', '+254709012001', '+254709012002'),
('Strathmore University Environment Unit', 'Nairobi', 'Madaraka', 'environment@strathmore.edu', 'info@strathmore.edu', '+254710123001', '+254710123002'),
('Kenya Red Cross Seed Program', 'Nairobi', 'South C', 'seedprogram@redcross.or.ke', 'info@redcross.or.ke', '+254711234001', '+254711234002'),
('Kenya Climate Innovation Center', 'Nairobi', 'Karen', 'info@kcic.org', 'innovation@kcic.org', '+254712345001', '+254712345002'),
('Regional Center for Resource Management', 'Machakos', 'Kathiani', 'info@resourcecenter.go.ke', 'admin@resourcecenter.go.ke', '+254713456001', '+254713456002'),
('Kenya Biodiversity Trust', 'Malindi', 'Kilifi', 'info@kenyabiodiversity.org', 'support@kenyabiodiversity.org', '+254714567001', '+254714567002'),
('Kenya Organic Agriculture Network', 'Nyeri', 'Rware', 'info@koan.or.ke', 'agriculture@koan.or.ke', '+254715678001', '+254715678002'),
('Kenya Agricultural Value Chain Program', 'Kericho', 'Litein', 'info@valuechain.go.ke', 'support@valuechain.go.ke', '+254716789001', '+254716789002'),
('Kenya Green Growth Hub', 'Nairobi', 'Hurlingham', 'info@greengrowth.ke', 'support@greengrowth.ke', '+254717890001', '+254717890002'),
('Kenya Water Towers Agency', 'Narok', 'Oloolunga', 'info@watertowers.go.ke', 'support@watertowers.go.ke', '+254718901001', '+254718901002'),
('Kenya Tree Planting Initiative', 'Garissa', 'Balambala', 'info@treeplanting.ke', 'support@treeplanting.ke', '+254719012001', '+254719012002');

-- Users Table
INSERT INTO Users (firstName, lastName, email1, email2, phoneNumber1, phoneNumber2, password, role, institutionID)
VALUES
('John', 'Mwangi', 'john.mwangi@kari.go.ke', 'john.alt@kari.go.ke', '+254700111001', '+254700111002', 'Password123!', 'AdminUser', 1),
('Grace', 'Ndungu', 'grace.ndungu@kefri.go.ke', 'grace.alt@kefri.go.ke', '+254701222001', '+254701222002', 'SecurePass456!', 'EmployeeUser', 2),
('Ali', 'Hassan', 'ali.hassan@ilri.org', 'ali.alt@ilri.org', '+254702333001', '+254702333002', 'StrongPass789!', 'ManagerUser', 3),
('Mary', 'Wanjiku', 'mary.wanjiku@kenyaseed.com', 'mary.alt@kenyaseed.com', '+254703444001', '+254703444002', 'PassKey321!', 'AdminUser', 4),
('Peter', 'Mungai', 'peter.mungai@egerton.ac.ke', 'peter.alt@egerton.ac.ke', '+254704555001', '+254704555002', 'Secret456!', 'EmployeeUser', 5),
('Jane', 'Mwangi', 'jane.mwangi@kws.go.ke', 'jane.alt@kws.go.ke', '+254705666001', '+254705666002', 'TopSecret789!', 'ManagerUser', 6),
('David', 'Kamau', 'david.kamau@uon.ac.ke', 'david.alt@uon.ac.ke', '+254706777001', '+254706777002', 'AccessKey123!', 'AdminUser', 7),
('Lucy', 'Kimani', 'lucy.kimani@jkuat.ac.ke', 'lucy.alt@jkuat.ac.ke', '+254707888001', '+254707888002', 'SecureCode456!', 'EmployeeUser', 8),
('Mark', 'Kibicho', 'mark.kibicho@kalro.go.ke', 'mark.alt@kalro.go.ke', '+254708999001', '+254708999002', 'Protection789!', 'ManagerUser', 9),
('Ann', 'Ndegwa', 'ann.ndegwa@kephis.go.ke', 'ann.alt@kephis.go.ke', '+254709111001', '+254709111002', 'Shield123!', 'AdminUser', 10),
('James', 'Karanja', 'james.karanja@strathmore.edu', 'james.alt@strathmore.edu', '+254710222001', '+254710222002', 'Encrypt456!', 'EmployeeUser', 11),
('Irene', 'Ndichu', 'irene.ndichu@redcross.or.ke', 'irene.alt@redcross.or.ke', '+254711333001', '+254711333002', 'Defend789!', 'ManagerUser', 12),
('Edith', 'Kariuki', 'edith.kariuki@kcic.org', 'edith.alt@kcic.org', '+254712444001', '+254712444002', 'LockKey123!', 'AdminUser', 13),
('Nancy', 'Mutua', 'nancy.mutua@resourcecenter.go.ke', 'nancy.alt@resourcecenter.go.ke', '+254713555001', '+254713555002', 'Secure789!', 'EmployeeUser', 14),
('Michael', 'Njuguna', 'michael.njuguna@kenyabiodiversity.org', 'michael.alt@kenyabiodiversity.org', '+254714666001', '+254714666002', 'BlockCode456!', 'ManagerUser', 15),
('Susan', 'Wambui', 'susan.wambui@koan.or.ke', 'susan.alt@koan.or.ke', '+254715777001', '+254715777002', 'Password321!', 'AdminUser', 16),
('George', 'Gathogo', 'george.gathogo@valuechain.go.ke', 'george.alt@valuechain.go.ke', '+254716888001', '+254716888002', 'SecurePass456!', 'EmployeeUser', 17),
('Emily', 'Wairimu', 'emily.wairimu@greengrowth.ke', 'emily.alt@greengrowth.ke', '+254717999001', '+254717999002', 'StrongPass789!', 'ManagerUser', 18),
('Paul', 'Chege', 'paul.chege@watertowers.go.ke', 'paul.alt@watertowers.go.ke', '+254718111001', '+254718111002', 'Password123!', 'AdminUser', 19),
('Sarah', 'Njoroge', 'sarah.njoroge@treeplanting.ke', 'sarah.alt@treeplanting.ke', '+254719222001', '+254719222002', 'Shield456!', 'EmployeeUser', 20);

-- Transactions Table
INSERT INTO Transactions (purpose, quantity, transactionType, transactionDate, seedID, institutionID, userID)
VALUES
('Seed Distribution to Farmers', 100, 'Outgoing', '2025-01-15', 1, 1, 1),
('Seed Donation to NGO', 200, 'Outgoing', '2025-02-10', 2, 2, 2),
('New Seed Sample Added', 50, 'Incoming', '2025-03-05', 3, 3, 3),
('Seed Testing Sample Collection', 30, 'Internal', '2025-01-20', 4, 4, 4),
('Community Seed Bank Support', 120, 'Outgoing', '2025-03-10', 5, 5, 5),
('Research Seed Distribution', 60, 'Outgoing', '2025-02-25', 6, 6, 6),
('Seed Preservation Addition', 80, 'Incoming', '2025-04-01', 7, 7, 7),
('Seed Exchange Program', 40, 'Outgoing', '2025-02-15', 8, 8, 8),
('Emergency Relief Seed Distribution', 150, 'Outgoing', '2025-03-20', 9, 9, 9),
('Seed Storage Record', 70, 'Incoming', '2025-01-30', 10, 10, 10),
('Seed Testing for Pathogens', 20, 'Internal', '2025-02-05', 11, 11, 11),
('Seed Loan to Farmers Group', 100, 'Outgoing', '2025-03-18', 12, 12, 12),
('New Seed Storage Entry', 90, 'Incoming', '2025-04-02', 13, 13, 13),
('Seed Withdrawal for Study', 45, 'Internal', '2025-03-22', 14, 14, 14),
('Seed Redistribution to Regions', 200, 'Outgoing', '2025-01-25', 15, 15, 15),
('Seed Contribution by Farmers', 50, 'Incoming', '2025-02-28', 16, 16, 16),
('Government Relief Program Seeds', 300, 'Outgoing', '2025-03-02', 17, 17, 17),
('Seed Research Input', 70, 'Incoming', '2025-03-15', 18, 18, 18),
('Seed Bank Annual Stock Update', 110, 'Internal', '2025-04-01', 19, 19, 19),
('New Seed Variety Introduction', 80, 'Incoming', '2025-02-20', 20, 20, 20);