#The following is a list of potentially useful queries that may later be turned
#into stored procedures. These should not be used by other teams at this point.

#A query that shows events types and locations

SELECT city, typeName
FROM addresses 
	JOIN eventaddresses 
		ON addresses.addressId = eventaddresses.addressId
	JOIN eventcategories
		ON eventaddresses.eventId = eventcategories.eventId
	JOIN eventtypes
		ON eventcategories.eventId = eventtypes.eventId
	JOIN `types`
		on eventtypes.typeId = `types`.typeId;
        
        
#A query that shows NUMBER of event types and locations

SELECT DISTINCT city, typeName, count(typeName) Event_Numbers
FROM addresses 
	JOIN eventaddresses 
		ON addresses.addressId = eventaddresses.addressId
	JOIN eventcategories
		ON eventaddresses.eventId = eventcategories.eventId
	JOIN eventtypes
		ON eventcategories.eventId = eventtypes.eventId
	JOIN `types`
		on eventtypes.typeId = `types`.typeId
GROUP BY typeName;


#Shows orginization names

SELECT organizationName
FROM organizations;


#Shows Childs name and age

SELECT CONCAT(firstName, " ", lastname) AS Name, FLOOR(datediff(current_date(), childDob)/365) AS Age
FROM children;



#Shows Childs name and age with where clause for backend manipulation

SELECT CONCAT(firstName, " ", lastname) AS Name, FLOOR(datediff(current_date(), childDob)/365) AS Age
FROM children
WHERE FLOOR(datediff(current_date(), childDob)/365) > 10;



#Shows what children have what allergies

SELECT CONCAT(firstName, " ", lastName) AS Name, childAllergies
FROM children;


#Shows Child and emergency contact number with parents userid, email and number

SELECT CONCAT(children.firstName, " ", children.lastName) AS Name, emergencyContactNum, email, phoneNumber
FROM children 
	JOIN users
		ON children.userId = users.userId;


-- Select child name based on being born after a certain date
SELECT firstname, lastname FROM children
WHERE childDob > "2008-01-01";


-- Select names for new users.
SELECT firstName, lastName FROM users
JOIN usersincommunity ON users.userID = usersincommunity.userID
WHERE userType = "new";


-- Select addresses listed in Seattle
SELECT * FROM addresses 
WHERE city = "Seattle";


-- Search limiting by event Id
SELECT * FROM events 
WHERE eventId > 2;


-- Search for event whose event name starts with C
SELECT * FROM events
WHERE eventNAME LIKE "C%";


-- Get the first and last name was a child with a useID less than 3, and an allergy that starts with K
SELECT firstName, lastName FROM children
WHERE userId < 3 AND childAllergies LIKE "K%";


-- Get the first and last name of a parent(s) (user in this database) who has a child with first name Steve
SELECT users.firstName, users.lastName FROM users
JOIN children ON users.userID = children.userID
WHERE children.firstName = "Steve";