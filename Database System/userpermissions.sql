USE SeedBankManagementSystem;

-- Drop Users
-- DROP USER IF EXISTS 'AdminUser'@'localhost';
-- DROP USER IF EXISTS 'ManagerUser'@'localhost';
-- DROP USER IF EXISTS 'EmployeeUser'@'localhost';

-- Create the Users
CREATE USER 'AdminUser'@'localhost' IDENTIFIED BY 'adminPassword';
CREATE USER 'ManagerUser'@'localhost' IDENTIFIED BY 'managerPassword';
CREATE USER 'EmployeeUser'@'localhost' IDENTIFIED BY 'employeePassword';

-- Assign Privileges to AdminUser
GRANT ALL PRIVILEGES ON SeedBankManagementSystem.* TO 'AdminUser'@'localhost';

-- Assign Privileges to ManagerUser
GRANT SELECT, INSERT, UPDATE, DELETE ON SeedBankManagementSystem.* TO 'ManagerUser'@'localhost';

-- Assign Privileges to EmployeeUser
GRANT SELECT ON SeedBankManagementSystem.* TO 'EmployeeUser'@'localhost';

-- Verifying Permissions
SHOW GRANTS FOR 'AdminUser'@'localhost';
SHOW GRANTS FOR 'ManagerUser'@'localhost';
SHOW GRANTS FOR 'EmployeeUser'@'localhost';
