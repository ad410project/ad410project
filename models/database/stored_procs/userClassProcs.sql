-- *****USER CLASS PROCEDURES***** --

delimiter //

-- Add new user with type "Registered", blank address
CREATE PROCEDURE addUser(IN userEmail VARCHAR(45), IN userPassword VARCHAR(45))
BEGIN
START TRANSACTION;

INSERT INTO Users VALUES
(DEFAULT, userEmail, userPassword, DEFAULT, DEFAULT, DEFAULT, 0, 
(SELECT userTypeId FROM userType WHERE userTypeName = 'Registered'));

INSERT INTO Addresses VALUES
(DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT);

INSERT INTO UserAddresses VALUES
(userEmail, LAST_INSERT_ID());

COMMIT;
END//

-- Update User Profile
CREATE PROCEDURE editUser(
IN userEmail VARCHAR(45),
IN userPassword VARCHAR(45),
IN firstName VARCHAR(45),
IN lastName VARCHAR(45),
IN phoneNumber VARCHAR(10),
IN notificationState TINYINT(4),
IN userType VARCHAR(45))
BEGIN
UPDATE Users SET
  `email` = userEmail,
  `password` = userPassword,
  `firstName` = firstName,
  `lastName` = lastName,
  `phoneNumber` = phoneNumber,
  `notificationState` = notificationState,
  `userTypeId` = (SELECT userTypeId FROM userType WHERE userTypeName = userType) 
WHERE userEmail = email;
END//

--Update User Address
CREATE PROCEDURE editUserAddress(
IN userEmail VARCHAR(45),
IN addressLine1 VARCHAR(45),
IN addressLine2 VARCHAR(45),
IN city VARCHAR(45),
IN state VARCHAR(45),
IN postalCode VARCHAR(6))
BEGIN
UPDATE Addresses 
JOIN UserAddresses USING (addressId)
JOIN Users USING (userId)
SET
  `addressLine1` = addressLine1,
  `addressLine2` = addressLine2,
  `city` VARCHAR(45) = city,
  `state` VARCHAR(45) = state,
  `postalCode` VARCHAR(6) = postalCode,
WHERE email = userEmail;
END//

-- Remove user from the database (currently this orphans some data)
CREATE PROCEDURE deleteUser(
IN userEmail VARCHAR(45))
BEGIN
DELETE FROM users
WHERE userEmail = email;
END//

-- Get all user info about a specific user
CREATE PROCEDURE getUserById(IN userEmail VARCHAR(45))
BEGIN
SELECT * FROM users
WHERE userEmail = users.userEmail;
END//

delimiter ;