-----------------------------------------------------------------------------
NOTES ON DATABASE SETUP

Step 1: Run the create_db.sql script on the server.
Step 2: Run the populate_db.sql to populate with dummy data (optional).
Step 3: Run the storedProcs.sql file to populate stored procedures.
-----------------------------------------------------------------------------

NOTES ON BACKUP/RECOVERY SCRIPTS

Each script needs to be edited to include your database/serve information, 
including:

1. User
2. Password
3. Host
4. Database name
5. File path to store backups

Once that is completed, the backup script can be automated using a scheduler 
such as CRON. For more details, see comments in the scripts.
-----------------------------------------------------------------------------

USING STORED PROCEDURES IN PHP

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
-------------------------------------------------------------------------------

