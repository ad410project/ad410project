

SELECT * FROM children;

SELECT * FROM users;

SELECT * FROM events;

SELECT * FROM useraddresses;

SELECT * FROM organizations;

SELECT * FROM addresses;

SELECT * FROM usersincommunity;



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






