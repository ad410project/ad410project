-- *****CHILD CLASS PROCEDURES***** --

-- DROP COMMANDS --
DROP PROCEDURE IF EXISTS `addChild`;
DROP PROCEDURE IF EXISTS `removeChild`;
DROP PROCEDURE IF EXISTS `editChild`;
DROP PROCEDURE IF EXISTS `findChild`;

delimiter //

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

delimiter ;