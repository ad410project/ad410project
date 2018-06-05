-- DROP COMMANDS --
DROP PROCEDURE IF EXISTS `getOrganization`;
DROP PROCEDURE IF EXISTS `deleteOrganization`;
DROP PROCEDURE IF EXISTS `getOrganizationUsers`;
DROP PROCEDURE IF EXISTS `addOrganizationUser`;

DELIMITER //

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

DELIMITER;
