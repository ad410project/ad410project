
 
 
 -- DROP COMMANDS --
DROP PROCEDURE IF EXISTS `getLocation`;
DROP PROCEDURE IF EXISTS `getStartDate`;
DROP PROCEDURE IF EXISTS `getOrganizationId`;
DROP PROCEDURE IF EXISTS `getCategories`;
DROP PROCEDURE IF EXISTS `getType`;
DROP PROCEDURE IF EXISTS `getPrice`;
DROP PROCEDURE IF EXISTS `getName`;
DROP PROCEDURE IF EXISTS `addEvent`;
DROP PROCEDURE IF EXISTS `deleteEvent`;
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
DROP PROCEDURE IF EXISTS `addCategory`;
DROP PROCEDURE IF EXISTS `removeCategory`;
DROP PROCEDURE IF EXISTS `addAddress`;
DROP PROCEDURE IF EXISTS `removeAddress`;
DROP PROCEDURE IF EXISTS `addType`; 
DROP PROCEDURE IF EXISTS `removeType`; 


DELIMITER //





 
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


CREATE PROCEDURE addAddress(IN currentEventId INT, addressId INT, addressLine1 VARCHAR(45), addressLine2 VARCHAR(45), city VARCHAR(45), `state` VARCHAR(45), postalCode VARCHAR(45))
BEGIN
START TRANSACTION;

INSERT INTO Addresses VALUES
(addressId, addressLine1,addressLine2,city,`state`,postalCode);

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


END//
	
	



 -- public static function addEvent($event)
    -- {
        -- //add event to database
    -- }


CREATE PROCEDURE addEvent(IN currentEventId INT, currentOrganizationId INT, currentEventName VARCHAR(45), currentEventDescription TEXT, currentEventPrice INT, currentMinAge INT, currentMaxAge INT, currentEventDate DATETIME, currentRegistrationOpen DATETIME, currentRegistrationClose DATETIME)

BEGIN
START TRANSACTION;

INSERT INTO Events VALUES
(currentEventId, currentOrganizationId,currentEventName,currentEventDescription,currentEventPrice,currentMinAge,currentMaxAge,currentEventDate,currentRegistrationOpen,currentRegistrationClose);

COMMIT;
END//



CREATE PROCEDURE editEvent
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
   


DELIMITER ;
	
	

	