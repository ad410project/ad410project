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
DROP PROCEDURE IF EXISTS `getLocation`;
DROP PROCEDURE IF EXISTS `getStartDate`;
DROP PROCEDURE IF EXISTS `getOrganizationId`;
DROP PROCEDURE IF EXISTS `getCategories`;
DROP PROCEDURE IF EXISTS `getType`;
DROP PROCEDURE IF EXISTS `getPrice`;
DROP PROCEDURE IF EXISTS `getName`;
DROP PROCEDURE IF EXISTS `addEvent`;
DROP PROCEDURE IF EXISTS `deleteEvent`;
DROP PROCEDURE IF EXISTS `editEvent`;
DROP PROCEDURE IF EXISTS `getEventId`;
DROP PROCEDURE IF EXISTS `getDescription`;
DROP PROCEDURE IF EXISTS `getMinAge`;
DROP PROCEDURE IF EXISTS `getMaxAge`;
DROP PROCEDURE IF EXISTS `getRegistrationOpen`;
DROP PROCEDURE IF EXISTS `getRegistrationClose`;
DROP PROCEDURE IF EXISTS `getEventsByUserId`;
DROP PROCEDURE IF EXISTS `getEventsByCategory`;
DROP PROCEDURE IF EXISTS `getEventsByType`;
DROP PROCEDURE IF EXISTS `getEventsByKeyword`;
DROP PROCEDURE IF EXISTS `getEventsByAgeRange`;
DROP PROCEDURE IF EXISTS `getEventsByPriceRange`;
DROP PROCEDURE IF EXISTS `getEventsByPostalCode`;
DROP PROCEDURE IF EXISTS `getEventsByDateRange`;
DROP PROCEDURE IF EXISTS `getEndDate`; 
DROP PROCEDURE IF EXISTS `addCategory`;
DROP PROCEDURE IF EXISTS `removeCategory`;
DROP PROCEDURE IF EXISTS `addAddress`;
DROP PROCEDURE IF EXISTS `removeAddress`;
DROP PROCEDURE IF EXISTS `addType`; 
DROP PROCEDURE IF EXISTS `removeType`; 

-- ORGANIZATION PROCS DROP COMMANDS --
DROP PROCEDURE IF EXISTS `getOrganization`;
DROP PROCEDURE IF EXISTS `deleteOrganization`;
DROP PROCEDURE IF EXISTS `getOrganizationUsers`;
DROP PROCEDURE IF EXISTS `addOrganizationUser`;

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

CREATE PROCEDURE `getOrganization` (IN orginizationIdp int(11))
BEGIN
SELECT organizationName
FROM organizations
WHERE organizationid = organizationIdp;
END//

#deletes an organization and a user from the organizationId

CREATE PROCEDURE `deleteOrganization` (IN organizationIdd int(11))
BEGIN
DELETE FROM organizations
WHERE organizationid = organizationIdd;
END//


CREATE PROCEDURE `getOrganizationUsers` (IN orginizationIdpu int(11))
BEGIN
SELECT *
FROM organizations
WHERE organizationid = organizationIdpu;
END//


CREATE PROCEDURE `addOrganizationUser` (IN orginizationIdpu int(11), addressId int(11), organizationName varchar(45), 
organizationDescription text, phoneNumber int(11), ogranizationWebsite varchar(45), userId int(11))
BEGIN
INSERT INTO organizations VALUES
(organizationIdpu, addressId, organizationName, organizationDescription, phoneNumber, organizationWebsite, userIdaddressIdaddressIdorganizationsorganizations);
END//


-- ******************************************************EVENTS CLASS PROCS************************************************************ --

    -- -- -- public function getLocation()
    -- -- -- {
        -- -- -- return $this->location;
    -- -- -- }
 CREATE PROCEDURE getLocation(IN location VARCHAR(45))
 BEGIN
SELECT * FROM Events
JOIN EventAddresses ON Events.eventId = EventAddresses.eventId
 JOIN Addresses on EventAddresses.addressId = Addresses.addressId
WHERE Addresses.city = location;
 END//
	
	
	
	
    -- -- -- public function getStartDate(){
        -- -- -- return $this->startDate;
    -- -- -- }
	
CREATE PROCEDURE getStartDate(IN startDate DATETIME)
BEGIN
 SELECT * FROM Events
 WHERE eventDate = startDate; 
END//
	


     -- -- public function getEndDate(){
        -- -- return $this->endDate;
    -- -- }
 -- --

CREATE PROCEDURE getEndDate(IN currentEndDate DATETIME)
BEGIN
SELECT * FROM Events
WHERE endDate = currentEndDate; 
END//	


	
    -- public function getOrganizationId()
    -- {
        -- return $this->organizationId;
    -- }
	
CREATE PROCEDURE getOrganizationId(IN orgId INT)
BEGIN
SELECT * FROM Organizations
WHERE organizationId = orgId;
END//
	
		
	

    -- public function getCategories()
    -- {
        -- return $this->categories;
    -- }

CREATE PROCEDURE getCategories (IN eventCategories VARCHAR(45))
BEGIN
SELECT * FROM Categories
WHERE categoryName = eventCategories;
END//		
	
	
	
	
    -- public function getType()
    -- {
        -- return $this->type;
    -- }
	
CREATE PROCEDURE getType (IN type VARCHAR(45))
BEGIN
SELECT * FROM types
WHERE typeName = type;
END//	
	
	
	
	

    -- public function getPrice()
    -- {
        -- return $this->price;
    -- }
	
CREATE PROCEDURE getPrice(IN price INT)
BEGIN
SELECT * FROM events
WHERE eventPrice = price  ;
END//




    -- public function getEventId()
    -- {
        -- return $this->eventId;
    -- }

CREATE PROCEDURE getEventId(IN currentEventId INT)
BEGIN
SELECT * FROM events
WHERE eventId = currentEventId ;
END//





    -- public function getName()
    -- {
        -- return $this->name;
    -- }

CREATE PROCEDURE getName(IN currentName VARCHAR(45))
BEGIN
SELECT * FROM events
WHERE eventName = currentName ;
END//




    -- public function getDescription()
    -- {
        -- return $this->description;
    -- }

CREATE PROCEDURE getDescription(IN currentDescription TEXT)
BEGIN
SELECT * FROM events
WHERE eventDescription = currentDescription ;
END//	

	
	
    -- public function getMinAge()
    -- {
        -- return $this->minAge;
    -- }

CREATE PROCEDURE getMinAge(IN minAgeChild INT)
BEGIN
SELECT * FROM events
WHERE minAge = minAgeChild;
END//	
	
	
	

    -- public function getMaxAge()
    -- {
        -- return $this->maxAge;
    -- }
	
CREATE PROCEDURE getMaxAge(IN maxAgeChild INT)
BEGIN
SELECT * FROM events
WHERE maxAge = maxAgeChild;
END//
	
	
	
	
    -- public function getRegistrationOpen()
    -- {
        -- return $this->registrationOpen;
    -- }
	
CREATE PROCEDURE getRegistrationOpen(IN registrationOpenDate DATETIME)
BEGIN
SELECT * FROM events
WHERE registrationOpen = registrationOpenDate;
END//
	
	
	
	
    -- public function getRegistrationClose()
    -- {
        -- return $this->registrationClose;
    -- }
	
CREATE PROCEDURE getRegistrationClose(IN registrationCloseDate DATETIME)
BEGIN
SELECT * FROM events
WHERE registrationClose = registrationCloseDate;
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
	




    -- public static function getEventsByCategory($category)
    -- {
        -- //return events matching category
    -- }

CREATE PROCEDURE getEventsByCategory(IN currentCategoryName VARCHAR(45))
BEGIN
SELECT eventName FROM Events
JOIN EventCategories ON Events.eventId = EventCategories.eventId
JOIN Categories ON EventCategories.categoryId = Categories.categoryId
ORDER BY categoryName;
END//



-- public static function removeAddress($eventId, $address)
    -- {
        -- //remove an address from the event in the database

        -- //categories, types, and addresses likely need their own
        -- //methods for changes since they can have multiple entries
    -- }


CREATE PROCEDURE removeAddress(IN currentEventId INT, currentAddressId INT)
BEGIN
START TRANSACTION;

DELETE FROM EventAddresses
WHERE currentEventId = eventId;

DELETE FROM Addresses
WHERE currentAddressId = addressId;


END//	
		

  -- public static function addAddress($eventId, $address)
    -- {
	
        -- //add an address to the event in the database

        -- //categories, types, and addresses likely need their own
        -- //methods for changes since they can have multiple entries
    -- }


CREATE PROCEDURE addAddress(IN currentEventId INT, addressLine1 VARCHAR(45), addressLine2 VARCHAR(45), city VARCHAR(45), `state` VARCHAR(45), postalCode VARCHAR(45))
BEGIN
START TRANSACTION;

INSERT INTO Addresses VALUES
(DEFAULT, addressLine1,addressLine2,city,`state`,postalCode);

COMMIT;
END//
	


  -- public static function addType($eventId, $type)
    -- {
        -- //add a type to the event in the database

        -- //categories, types, and addresses likely need their own
        -- //methods for changes since they can have multiple entries
    -- }


CREATE PROCEDURE addType(IN currentEventId INT, currentTypeName VARCHAR(45))
BEGIN
START TRANSACTION;

INSERT INTO eventTypes VALUES
(typeId, DEFAULT);

INSERT INTO Types VALUES
(DEFAULT,typeName);

COMMIT;
END//
	

  -- public static function removeType($eventId, $type)
    -- {
        -- //remove a type from the event in the database

        -- //categories, types, and addresses likely need their own
        -- //methods for changes since they can have multiple entries
    -- }

CREATE PROCEDURE removeType(IN currentEventId INT, currentTypeName VARCHAR(45))
BEGIN
START TRANSACTION;

DELETE FROM eventTypes
WHERE currentEventId = eventId;

DELETE FROM Types
WHERE currentTypeName = typeName;


END//	
	
	
    -- public static function removeCategory($eventId, $category)
    -- {
        -- //remove a category from the event in the database

        -- //categories, types, and addresses likely need their own
        -- //methods for changes since they can have multiple entries
    -- }


CREATE PROCEDURE removeCategory(IN currentCategoryId INT, currentCategoryName VARCHAR(45))
BEGIN
START TRANSACTION;

DELETE FROM eventCategories
WHERE currentCategoryId = categoryId;

DELETE FROM Categories
WHERE categoryName = eventId;


END//
	

  -- public static function addCategory($eventId, $category)
    -- {
        -- //add a category to the event in the database

        -- //categories, types, and addresses likely need their own
        -- //methods for changes since they can have multiple entries
    -- }

CREATE PROCEDURE addCategory(IN currentEventId INT, currentCategoryName VARCHAR(45))
BEGIN
START TRANSACTION;

INSERT INTO eventCategories VALUES
(DEFAULT,eventId);

INSERT INTO Categories VALUES
(DEFAULT,categoryName);

COMMIT;
END//


   -- public static function deleteEvent($eventId)
    -- {
        -- //delete the event

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


CREATE PROCEDURE addEvent(IN currentOrganizationId INT, currentEventName VARCHAR(45), currentEventDescription TEXT, currentEventPrice INT, currentMinAge INT, currentMaxAge INT, currentEventDate DATETIME, currentEndDate DATETIME, currentRegistrationOpen DATETIME, currentRegistrationClose DATETIME, currentEventType SET, currentEventCategory SET)

BEGIN
START TRANSACTION;

INSERT INTO Events VALUES
(DEFAULT, currentOrganizationId,currentEventName,currentEventDescription,currentEventPrice,currentMinAge,currentMaxAge,currentEventDate,currentEndDate,currentRegistrationOpen,currentRegistrationClose,currentEventType,currentEventCategory);

COMMIT;
END//



CREATE PROCEDURE editEvent(
IN currentEventId INT(11),
IN currentOrganizionId INT(11),
IN currentEventName VARCHAR(45),
IN currentEventDescription TEXT,
IN currentEventPrice INT,
IN currentMinAge INT,
IN currentMaxAge INT,
IN currentEventDate DATETIME,
IN currentRegistrationOpen DATETIME,
IN currentRegistrationClose DATETIME,
IN currentEndDate DATETIME,
IN currentEventType SET,
IN currentEventCategory SET
)
BEGIN
UPDATE Events SET
  `eventId` = currentEventId,
  `organizionId` = currentOrganizionId,
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
	  `eventCategory` = currentEventCategory,
  `eventTypeId` = (SELECT eventTypeId FROM eventType WHERE eventTypeName = eventType) 
WHERE eventId = currentEventId;
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



    -- public static function getEventsByType($type)
    -- {
        -- //return events matching type
    -- }

CREATE PROCEDURE getEventsByType(IN currentType VARCHAR(45))
BEGIN
SELECT typeName FROM Types
WHERE typeName  LIKE '% currentType %';
END//



    -- public static function getEventsByKeyword($keyword)
    -- {
        -- //return events with keyword in name or description
    -- }

CREATE PROCEDURE getEventsByKeyword(IN currentKeyword VARCHAR(45))
BEGIN
SELECT eventName FROM Events
WHERE eventName LIKE '% currentKeyword %';
END//


    -- public static function getEventsByAgeRange($minAge, $maxAge)
    -- {
        -- //return events for the age range
    -- }

CREATE PROCEDURE getEventsByAgeRange(IN currentMinAge INT, currentMaxAge INT)
BEGIN
SELECT eventName FROM Events
WHERE minAge <= currentMinAge  AND maxAge >= currentMaxAge;
END//


    -- public static function getEventsByPriceRange($minPrice, $maxPrice)
    -- {
        -- //return events for the price range
    -- }

CREATE PROCEDURE getEventsByPriceRange(IN currentMinPrice INT, currentMaxPrice INT)
BEGIN
SELECT eventName FROM Events
WHERE eventPrice >= currentMinPrice AND eventPrice <= currentMaxPrice; 
END//


    -- public static function getEventsByPostalCode($code)
    -- {
        -- //return events within a range of the location
    -- }

CREATE PROCEDURE getEventsByPostalCode(IN currentCode VARCHAR(45))
BEGIN
SELECT eventName FROM Events
JOIN Organizations ON Events.organizationId = Organizations.organizationId
JOIN Addresses on Organizations.addressId = Addresses.addressId
WHERE postalCode = currentCode; 
END//


delimiter ;