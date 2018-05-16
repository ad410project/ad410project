#Author August Kading
#DATE 5/11/18
#AD410
#Please note that any of these queries could be turned into a view or procedure upon request!


#A query that tells how many users are in each city

SELECT count(city) UserNumber, city  
FROM addresses
GROUP BY city; 
 
    
#A query that shows userid and phone numbers

SELECT userid, phoneNumber
FROM users;
 
 
#A query that shows userid and emails

SELECT userid, email
FROM users;


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
		ON children.userId = users.userId




