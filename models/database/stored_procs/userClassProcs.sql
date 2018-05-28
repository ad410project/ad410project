-- *****USER CLASS PROCEDURES***** --

-- DROP COMMANDS --
DROP PROCEDURE IF EXISTS `addUser`;
DROP PROCEDURE IF EXISTS `editUser`;
DROP PROCEDURE IF EXISTS `editUserAddress`;
DROP PROCEDURE IF EXISTS `deleteUser`;
DROP PROCEDURE IF EXISTS `getUserById`;

delimiter //

/*addUser(userEmail, userPassword)
	Adds a new user to the database. Creates a new address entry
	for the user and adds to linking table. As this only takes in
	userEmail and userPassword, PROCEDURE editUser and editUserAddress
	will need to be called to add additional info.*/
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

/*editUser(userEmail, userPassword, firstName, lastName, phoneNumber, notificationState, userType)
	Updates all user profile information based on input data.*/
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

/*editUserAddress(userEmail, addressLine1, addressLine2, city, state, postalCode)
	Updates all userAddress information.*/
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
  `city` = city,
  `state`  = state,
  `postalCode` = postalCode
WHERE email = userEmail;
END//

/*deleteUser(userEmail)
	Removes the user from the userProfile section. Also removes related data from
	UserAddresses and Addresses tables.*/
CREATE PROCEDURE deleteUser(
IN userEmail VARCHAR(45))
BEGIN

START TRANSACTION;

DELETE FROM Users
WHERE userEmail = email;

DELETE FROM Addresses
WHERE `addressId` = (SELECT addressId FROM UserAddresses WHERE userEmail = email);

DELETE FROM UserAddresses
WHERE userEmail = email;
END//

/*getUserById(userEmail)
	Returns a list of users with a given e-mail address, which serves as their unique ID.*/
CREATE PROCEDURE getUserById(IN userEmail VARCHAR(45))
BEGIN
SELECT * FROM users
WHERE userEmail = users.userEmail;
END//

delimiter ;