DELIMITER //

CREATE PROCEDURE `getOrginization` (IN orginizationIdp int)

BEGIN
SELECT organizationName
FROM organizations
WHERE organizationid = organizationIdp;

END//

#deletes an organization and all related details based off organizationId

CREATE PROCEDURE `deleteOrginization` (IN orginizationIdpd int)

BEGIN

DELETE organizationid, addressid, organizationName, organizationDescription, phoneNumber, organizationWebsite
FROM organizations
WHERE organizationid = organizationIdpd;

END


CREATE PROCEDURE `getOrginizationUsers` (IN orginizationIdpu int)

BEGIN

SELECT 
FROM organizations
WHERE organizationid = organizationIdpu;

END



