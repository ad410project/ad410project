-- Think of this file of an extension of the create db script run it once on your schema to use these!


delimiter //
-- basic getters for all tables
CREATE PROCEDURE getChildren ()
BEGIN
SELECT * FROM children;
END//

CREATE PROCEDURE getUsers()
BEGIN
SELECT * FROM users;
END//

CREATE PROCEDURE getEvents()
BEGIN
SELECT * FROM events;
END//

CREATE PROCEDURE getUserAddress()
BEGIN
SELECT * FROM useraddresses;
END//

CREATE PROCEDURE getOrganizations()
BEGIN
SELECT * FROM organizations;
END//

CREATE PROCEDURE getAddresses()
BEGIN
SELECT * FROM addresses;
END//

CREATE PROCEDURE getCategories()
BEGIN
SELECT * FROM categories;
END//

CREATE PROCEDURE getTypes()
BEGIN
SELECT * FROM types;
END//

-- Get all user info about a specific user
CREATE PROCEDURE getUserProfile(IN userEmail VARCHAR(45))
BEGIN
SELECT * FROM users
WHERE userEmail = userEmail;
END//

-- Get an Orginization by Id
CREATE PROCEDURE getOrganization(IN myOrgId INT)
BEGIN
SELECT * FROM organizations
WHERE organizationId = myOrgId;
END//

-- Get a Child by Id
CREATE PROCEDURE getChild(IN myChildId INT)
BEGIN
SELECT * FROM children
WHERE childId = myChildId;
END//

-- Get an Event by Id
CREATE PROCEDURE getEvent(IN myEventId INT)
BEGIN
SELECT * FROM events
WHERE eventId = myEventId;
END//

-- All children belonging to a user
CREATE PROCEDURE getUserChildren(IN myUserId INT)
BEGIN
SELECT * FROM children
WHERE userId = myUserId;
END//

-- All events a child is attending
CREATE PROCEDURE getChildEvents(IN myChildId INT)
BEGIN
SELECT * FROM events
JOIN childevents ON  events.eventId = childevents.eventId
WHERE childevents.childId = myChildId;
END//

-- All events of a certain type given a type ID
CREATE PROCEDURE getTypeEvent(IN myTypeId INT)
BEGIN
SELECT * FROM events
JOIN eventtypes ON events.eventId = eventtypes.eventId
WHERE eventtypes.typeId = myTypeId;
END//

-- All events of a certain category given a categoryId
CREATE PROCEDURE getCategoryEvent(IN myCategoryId INT)
BEGIN
SELECT * FROM events
JOIN eventCategories ON events.eventId = eventCategories.eventId
WHERE eventCategories.categoryId = myCategoryId;
END//

-- All events in a date range
CREATE PROCEDURE getEventsInDateRange(IN startTime DATETIME,IN endTime DATETIME)
BEGIN
SELECT * FROM events
WHERE eventDate BETWEEN startTime AND endTime;
END//

-- Register user
CREATE PROCEDURE Register(IN userEmail VARCHAR(45), IN userPassword VARCHAR(45))
BEGIN
INSERT INTO Users VALUES
(DEFAULT, userEmail, userPassword, DEFAULT, DEFAULT, DEFAULT, 0, 
(SELECT userTypeId FROM userType WHERE userTypeName = 'Registered'));
END//

-- Update User Profile
CREATE PROCEDURE UpdateUserProfile(
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
  
-- Update/Create User Address

delimiter ;