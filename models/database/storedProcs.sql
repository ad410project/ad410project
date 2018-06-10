-- ************************STORED PROCEDURES***************************** --
/*
-------------Loading stored procedures into the database--------------------
Run each of the .sql files on the MySQL database server in order to populate
the database with these procedures.
--------------------------Using procedures in php----------------------------
Note:  There has been no need to use OUTS in procedures thus far,
should the need arise that will complicate things greatly, for now this
will only cover how to use procedures with one IN parameter.
1.Simply establish a variable as a query essentially, except you use the 
CALL function to the call the procedure as it is named in the SQL database
2.For example if we have the procedure:
CREATE PROCEDURE `getOrginization` (IN orginizationIdp int)
BEGIN
SELECT organizationName
FROM organizations
WHERE organizationid = organizationIdp;
END//
in your PHP code you would type:
 $result = mysqli_query($connection, 
     "CALL getOrganization(1)") or die("Query fail: " . mysqli_error());
3.The $result variable will now contain the results of
the query contained within the stored procedure!
*/

-- CHILD PROCS DROP COMMANDS --
DROP PROCEDURE IF EXISTS `addChild`;
DROP PROCEDURE IF EXISTS `removeChild`;
DROP PROCEDURE IF EXISTS `editChild`;
DROP PROCEDURE IF EXISTS `findChild`;

-- EVENT PROCS DROP COMMANDS --
DROP PROCEDURE IF EXISTS `addEvent`;
DROP PROCEDURE IF EXISTS `deleteEvent`;
DROP PROCEDURE IF EXISTS `editEvent`;
DROP PROCEDURE IF EXISTS `editEventAddress`;
DROP PROCEDURE IF EXISTS `getEventId`;
DROP PROCEDURE IF EXISTS `getEventsByUserId`;
DROP PROCEDURE IF EXISTS `getEventsByDateRange`; 

-- ORGANIZATION PROCS DROP COMMANDS --
DROP PROCEDURE IF EXISTS `getOrganization`;
DROP PROCEDURE IF EXISTS `deleteOrganization`;
DROP PROCEDURE IF EXISTS `addOrganization`;
DROP PROCEDURE IF EXISTS `editOrganization`;

-- USER PROCS DROP COMMANDS --
DROP PROCEDURE IF EXISTS `addUser`;
DROP PROCEDURE IF EXISTS `editUser`;
DROP PROCEDURE IF EXISTS `editUserAddress`;
DROP PROCEDURE IF EXISTS `deleteUser`;
DROP PROCEDURE IF EXISTS `getUserById`;
DROP PROCEDURE IF EXISTS `userLogin`;

delimiter //

-- *******************************************************CHILD CLASS PROCS*************************************************** --
/*addChild(userId, firstName, lastName, childDob, childAllergies, emergencyContactNum)
	Adds a new child to the database, linked with a given parent's user ID.*/
CREATE PROCEDURE addChild
(IN userId INT(11),
IN firstName VARCHAR(45),
IN lastName VARCHAR(45),
IN childDob DATE,
IN childAllergies VARCHAR(45),
IN emergencyContactNum VARCHAR(10))
BEGIN
INSERT INTO Children VALUES
(DEFAULT, userId, firstName, lastName, 
childDob, childAllergies, emergencyContactNum);
END//

/*removeChild(childIdIn)
	Removes a child with the given ID from the database.*/
CREATE PROCEDURE removeChild
(IN childIdIn INT)
BEGIN
DELETE FROM Children
WHERE childId = childIdIn;
END//

/*editChild(childIdIn, firstName, lastName, childDob, childAllergies, emergencyContactNum)
	Edits all fields within a child's profile.*/
CREATE PROCEDURE editChild
(IN childIdIn INT,
IN firstName VARCHAR(45),
IN lastName VARCHAR(45),
IN childDob DATE,
IN childAllergies VARCHAR(45),
IN emergencyContactNum VARCHAR(10))
BEGIN
UPDATE Children
SET
	`firstName` = firstName,
    `lastName` = lastName,
    `childDob` = childDob,
    `childAllergies` = childAllergies,
    `emergencyContactNum` = emergencyContactNum
WHERE childId = childIdIn;
END//

/*findChild(userIdIn)
	Returns a list of all children associated with a given userId*/
CREATE PROCEDURE findChild(IN userIdIn INT)
BEGIN
SELECT * FROM children
WHERE userId = userIdIn;
END//


-- ***********************************************USER CLASS PROCS*********************************************** --


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
((SELECT userId FROM Users WHERE userEmail = email), LAST_INSERT_ID());

COMMIT;
END//

/*editUser(userEmail, userPassword, firstName, lastName, phoneNumber, notificationState, userType)
	Updates all user profile information based on input data. Note that as written, userType 
    should be input as the string value - "new", "registered", "organization", or "admin"*/
CREATE PROCEDURE editUser(
IN userIdIn INT(11),
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
WHERE userIdIn = userId;
END//

/*editUserAddress(userEmail, addressLine1, addressLine2, city, state, postalCode)
	Updates all userAddress information.*/
CREATE PROCEDURE editUserAddress(
IN userIdIn INT(11),
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
WHERE userIdIn = userId;
END//

/*deleteUser(userEmail)
	Removes the user from the userProfile section. Also removes related data from
	UserAddresses and Addresses tables.*/
CREATE PROCEDURE deleteUser(
IN userIdIn INT(11))
BEGIN

START TRANSACTION;

DELETE FROM Addresses
WHERE addressId = (SELECT addressId FROM UserAddresses WHERE userIdIn = userId);

DELETE FROM Users
WHERE userIdIn = userId;

COMMIT;
END//

/*getUserById(userEmail)
	Returns a list of users with a given e-mail address, which serves as their unique ID.*/
CREATE PROCEDURE getUserById(
IN userIdIn INT(11))
BEGIN
SELECT * FROM users
WHERE userIdIn = userId;
END//

/*userLogin(userEmail)
	Returns encrypted user password to check validity on backend.*/
CREATE PROCEDURE userLogin(
IN userEmail VARCHAR(45), 
IN userPassword VARCHAR(45))
BEGIN
SELECT * FROM users
WHERE email = userEmail AND password = userPassword;
END//

-- ****************************************************ORGANIZATION CLASS PROCS****************************************************** --
/*Gets all organization data*/
CREATE PROCEDURE getOrganization(
IN organizationIdIn int(11))
BEGIN
SELECT *
FROM organizations
JOIN addresses USING (addressId)
JOIN users USING (userId)
WHERE organizationid = organizationIdIn;
END//

/*Deletes organization by orgId. Also removes org address and user
account associated with the organization*/
CREATE PROCEDURE deleteOrganization
(IN organizationIdIn INT(11))
BEGIN
DECLARE userIdIn INT DEFAULT NULL;
DECLARE addressIdIn INT DEFAULT NULL;

START TRANSACTION;

SET userIdIn = (SELECT userId FROM organizations WHERE organizationIdIn = organizationId);
SET addressIdIn = (SELECT addressId FROM organizations WHERE organizationIdIn = organizationId);

DELETE FROM addresses
WHERE addressIdIn = addressId;

DELETE FROM users
WHERE userIdIn = userId;

DELETE FROM organizations
WHERE organizationId = organizationIdIn;

COMMIT;
END//


/*addOrganization(orgName, orgDescription, phoneNumber, orgWebsite,
org/userEmail, org/userPassword) - adds a new organization with basic
information. Populates with a blank address, will need to editOrg to
populate address*/
CREATE PROCEDURE addOrganization
(IN organizationName VARCHAR(45), 
IN organizationDescription TEXT, 
IN phoneNumber VARCHAR(10), 
IN ogranizationWebsite VARCHAR(45), 
IN userEmail VARCHAR(45),
IN userPassword VARCHAR(45))
BEGIN

DECLARE addressIdIn INT DEFAULT NULL;
DECLARE userIdIn INT DEFAULT NULL;

START TRANSACTION;

INSERT INTO Users VALUES
(DEFAULT, userEmail, userPassword, DEFAULT, DEFAULT, DEFAULT, 0, 
(SELECT userTypeId FROM userType WHERE userTypeName = 'Organization'));

SET userIdIn = LAST_INSERT_ID();

INSERT INTO Addresses VALUES
(DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT);

SET addressIdIn = LAST_INSERT_ID();

INSERT INTO organizations VALUES
(DEFAULT, addressIdIn, organizationName, organizationDescription, 
phoneNumber, organizationWebsite, userIdIn);

COMMIT;
END//

/*editOrganization - Edits all information related to organization,
user attached to org, and address attached to org.*/
CREATE PROCEDURE editOrganization(
IN organizationIdIn INT(11),
IN organizationName VARCHAR(45), 
IN organizationDescription TEXT, 
IN phoneNumber VARCHAR(10), 
IN ogranizationWebsite VARCHAR(45), 
IN userEmail VARCHAR(45),
IN userPassword VARCHAR(45),
IN addressLine1 VARCHAR(45),
IN addressLine2 VARCHAR(45),
IN city VARCHAR(45),
IN state VARCHAR(45),
IN postalCode VARCHAR(6),
IN firstName VARCHAR(45),
IN lastName VARCHAR(45))
BEGIN
UPDATE organizations 
JOIN addresses USING (addressId)
JOIN users USING (userId)
SET
  `organizationName` = organizationName,
  `organizationdescription` = organizationDescription,
  organizations.phoneNumber = phoneNumber,
  `organizationWebsite` = organizationWebsite,
  `addressLine1` = addressLine1,
  `addressLine2` = addressLine2,
  `city` = city,
  `state`  = state,
  `postalCode` = postalCode,
  `email` = userEmail,
  `password` = userPassword,
  `firstName` = firstName,
  `lastName` = lastName,
  users.phoneNumber = phonenumber
WHERE organizationIdIn = organizationId;
END//

-- ******************************************************EVENTS CLASS PROCS************************************************************ --

    -- public function getEventId()
    -- {
        -- return $this->eventId;
    -- }

CREATE PROCEDURE getEventId(IN currentEventId INT)
BEGIN
SELECT * FROM events
JOIN eventaddresses USING(eventId)
JOIN addresses USING(addressId)
WHERE eventId = currentEventId ;
END//


    -- public static function getEventsByUserId($userId)
    -- {
        -- //return events for the user ID
    -- }

CREATE PROCEDURE getEventsByUserId(IN currentUserId INT)
BEGIN
SELECT * FROM Events
JOIN ChildEvents ON Events.eventId = ChildEvents.eventId
JOIN Children ON ChildEvents.childId = Children.childId
JOIN Users ON Children.userId = Users.userId
WHERE Users.userId = currentUserId;
END//
	

   -- public static function deleteEvent($eventId)
    -- {
        -- //delete the event
		-- Does not currently remove the address from addresses table as addresses might be shared.
    -- }

CREATE PROCEDURE deleteEvent(IN currentEventId INT)
BEGIN
START TRANSACTION;

DELETE FROM Events 
WHERE currentEventId = eventId;

DELETE FROM EventAddresses
WHERE currentEventId = eventId;

END//

-- public static function addEvent($event)
    -- {
        -- //add event to database
    -- }
CREATE PROCEDURE addEvent(
IN currentOrganizationId INT, 
currentEventName VARCHAR(45), 
currentEventDescription TEXT, 
currentEventPrice INT, 
currentMinAge INT, 
currentMaxAge INT, 
currentEventDate DATETIME,
currentRegistrationOpen DATETIME, 
currentRegistrationClose DATETIME,  
currentEndDate DATETIME, 
currentEventType SET('Day Camp', 'Summer Camp', 'Overnight Camp', 'Half Day', 'Full Day', 'One Week', 'Two Week', 'Full Summer', 'Other'), 
currentEventCategory SET('Academics', 'Animals & Farms', 'Arts & Crafts', 'Language & Culture', 'Multi-Activity Day Camp', 'Nature & Environment', 'Overnight Camp', 'Performing Arts', 'Religious Programs', 'Science & Technology', 'Special Needs', 'Sports & Fitness'),
addressLine1 VARCHAR(45),
addressLine2 VARCHAR(45),
city VARCHAR(45),
state VARCHAR(45),
postalCode VARCHAR(6))

BEGIN
DECLARE eventIdNew INT DEFAULT NULL;
DECLARE addressIdNew INT DEFAULT NULL;
START TRANSACTION;

INSERT INTO Events VALUES
(DEFAULT, currentOrganizationId,currentEventName,currentEventDescription,
currentEventPrice,currentMinAge,currentMaxAge,currentEventDate,currentRegistrationOpen,
currentRegistrationClose,currentEndDate,currentEventType,currentEventCategory);

SET eventIdNew = LAST_INSERT_ID();

INSERT INTO Addresses VALUES
(DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT);

SET addressIdNew = LAST_INSERT_ID();

INSERT INTO eventaddresses VALUES
(eventIdNew, addressIdNew);

CALL editEventAddress(eventIdNew, addressLine1, addressLine2, city, state, postalCode);

COMMIT;
END//

/*editEvent - edits all fields in events table*/
CREATE PROCEDURE editEvent(
IN currentEventId INT(11),
IN currentOrganizationId INT(11),
IN currentEventName VARCHAR(45),
IN currentEventDescription TEXT,
IN currentEventPrice INT,
IN currentMinAge INT,
IN currentMaxAge INT,
IN currentEventDate DATETIME,
IN currentRegistrationOpen DATETIME,
IN currentRegistrationClose DATETIME,
IN currentEndDate DATETIME,
currentEventType SET('Day Camp', 'Summer Camp', 'Overnight Camp', 'Half Day', 'Full Day', 'One Week', 'Two Week', 'Full Summer', 'Other'), 
currentEventCategory SET('Academics', 'Animals & Farms', 'Arts & Crafts', 'Language & Culture', 'Multi-Activity Day Camp', 'Nature & Environment', 'Overnight Camp', 'Performing Arts', 'Religious Programs', 'Science & Technology', 'Special Needs', 'Sports & Fitness'),
addressLine1 VARCHAR(45),
addressLine2 VARCHAR(45),
city VARCHAR(45),
state VARCHAR(45),
postalCode VARCHAR(6))
BEGIN
START TRANSACTION;

UPDATE Events SET
  `eventId` = currentEventId,
  `organizationId` = currentOrganizationId,
  `eventName` = currentEventName,
  `eventDescription` = currentEventDescription,
  `eventPrice` = currentEventPrice,
  `minAge` = currentMinAge,
  `maxAge` = currentMaxAge,
  `eventDate` = currentEventDate,
  `registrationOpen` = currentRegistrationOpen,
  `registrationClose` = currentRegistrationClose,
  `endDate` = currentEndDate,
  `eventType` = currentEventType,
  `eventCategory` = currentEventCategory
WHERE eventId = currentEventId;

CALL editEventAddress(eventIdIn, addressLine1, addressLine2, city, state, postalCode);

COMMIT;
END//

/*Edits the event's address*/
CREATE PROCEDURE editEventAddress(
IN eventIdIn INT,
addressLine1 VARCHAR(45),
addressLine2 VARCHAR(45),
city VARCHAR(45),
state VARCHAR(45),
postalCode VARCHAR(6))
BEGIN
DECLARE addressIdIn INT DEFAULT NULL;
SET addressIdIn = (SELECT addressId FROM eventaddresses WHERE eventId = eventIdIn);
UPDATE addresses
SET
  `addressLine1` = addressLine1,
  `addressLine2` = addressLine2,
  `city` = city,
  `state` = state,
  `postalCode` = postalCode
WHERE addressIdIn = addressId;
END//
	

    -- -- public static function getEventsByDateRange($startDate, $endDate)
    -- -- {
        -- -- //return events that fall within the date range
    -- -- }

 CREATE PROCEDURE getEventsByDateRange(IN currentEventDate DATETIME, currentEndDate DATETIME)	
 BEGIN
SELECT eventName FROM Events	
WHERE eventDate >= currentEventDate  AND endDate <= currentEndDate;
END//	

delimiter ;